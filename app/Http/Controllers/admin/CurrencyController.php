<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    private function isMainAdmin(): bool
    {
        $admin = Auth::guard('admin')->user();

        return $admin && (int) $admin->role === 2;
    }

    private function ensureMainAdmin()
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can manage currencies.');
        }
    }

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | View-only page
        |--------------------------------------------------------------------------
        | Super admin and allowed vendors can view currencies.
        | Route middleware controls vendor permission.
        */
        $currency = Currency::latest('id');

        if (!empty($request->get('keyword'))) {
            $currency = $currency->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('code', 'like', '%' . $request->get('keyword') . '%');
        }

        $currency = $currency->paginate(10);

        return view('admin.currency.list', [
            'currency' => $currency,
        ]);
    }

    public function create()
    {
        $this->ensureMainAdmin();

        return view('admin.currency.create');
    }

    public function store(Request $request)
    {
        $this->ensureMainAdmin();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
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
                'message' => 'Currency added successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function edit($id, Request $request)
    {
        $this->ensureMainAdmin();

        $currency = Currency::find($id);

        if (empty($currency)) {
            $request->session()->flash('error', 'Record not found');

            return redirect()->route('currency.index');
        }

        return view('admin.currency.edit', [
            'currency' => $currency,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->ensureMainAdmin();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
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
                    'message' => 'Record not found',
                ]);
            }

            $currency->name = $request->name;
            $currency->code = $request->code;
            $currency->exchange_rate = $request->exchange_rate;
            $currency->status = $request->status;
            $currency->save();

            $request->session()->flash('success', 'Currency updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Currency updated successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    public function delete($id, Request $request)
    {
        $this->ensureMainAdmin();

        $currency = Currency::find($id);

        if (empty($currency)) {
            $request->session()->flash('error', 'Record not found');

            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }

        $currency->delete();

        $request->session()->flash('success', 'Currency deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Currency deleted successfully',
        ]);
    }
}