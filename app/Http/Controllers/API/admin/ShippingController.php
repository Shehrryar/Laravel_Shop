<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create()
    {
        $countries = Country::get();
        $data['countries'] = $countries;
        $shipping_charges = Shipping::select('shipping_charges.*', 'countries.name')->leftJoin('countries', 'countries.id', 'shipping_charges.country_id')->get();
        $data['shipping_charges'] = $shipping_charges;
        return view('admin.shipping.create', $data);
    }

    public function store(Request $request)
    {
        $count = Shipping::where('country_id', $request->country)->count();
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {
            if ($count > 0) {
                session()->flash('error', 'Shipping Already Exists');
                return response()->json([
                    'status' => true,
                ]);
            }

            $shipping = new Shipping();
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success', 'Shipping Added Successfully');

            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id)
    {
        $countries = Country::get();

        $shipping_charge = Shipping::find($id);

        $data['countries'] = $countries;
        $data['shipping_charge'] = $shipping_charge;
        return view('admin.shipping.edit', $data);

    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {

            $shipping = Shipping::find($id);
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success', 'Shipping updated Successfully');

            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function destroy($id)
    {
        $shipping_del = Shipping::find($id);

        if($shipping_del == null){
            session()->flash('error', 'Shipping Not Found');
            return response()->json([
                'status' => true,
            ]);
        }
        $shipping_del->delete();

        session()->flash('success', 'Shipping Deleted Successfully');

        return response()->json([
            'status' => true,
        ]);
    }
}
