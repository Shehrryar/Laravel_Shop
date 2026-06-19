<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currency = Currency::latest('id');
        if (!empty($request->get('keyword'))) {
            $currency = $currency->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $currency = $currency->paginate(10);
        $data['currency'] = $currency;
        return view('admin.currency.list', $data);
    }


    public function create()
    {
        return view('admin.currency.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
                // 'symbol' => 'required',
                'exchange_rate' => 'required|numeric',
                'status' => 'required',
            ]
        );

        if ($validator->passes()) {
            $currency = new Currency();
            $currency->name = $request->name;
            $currency->code = $request->code;
            $currency->exchange_rate = $request->exchange_rate;
            $currency->status = $request->status;
            $currency->save();

            $request->session()->flash('success', 'Currency added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Currency added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request)
    {
        $currency = Currency::find($id);
        if (empty($currency)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('currency.index');
        }
        $data['currency'] = $currency;
        return view('admin.currency.edit', $data);
    }


    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
                // 'symbol' => 'required',
                'exchange_rate' => 'required|numeric',
                'status' => 'required',
            ]
        );

        if ($validator->passes()) {
            $currency = Currency::find($id);
            if (empty($currency)) {
                $request->session()->flash('error', 'Record not found');
                return response()->json([
                    'status' => false,
                    'message' => 'Record not found'
                ]);
            }

            $currency->name = $request->name;
            $currency->code = $request->code;
            // $currency->symbol = $request->symbol;
            $currency->exchange_rate = $request->exchange_rate;
            $currency->status = $request->status;
            $currency->save();

            $request->session()->flash('success', 'Currency updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Currency updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete($id, Request $request)
    {
        $currency = Currency::find($id);
        if (empty($currency)) {
            $request->session()->flash('error', 'Record not found');
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        $currency->delete();
        $request->session()->flash('success', 'Currency deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Currency deleted successfully'
        ]);
    }

}