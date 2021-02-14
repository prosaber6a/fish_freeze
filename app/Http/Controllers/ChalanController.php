<?php

namespace App\Http\Controllers;

use App\Models\Chalan;
use App\Models\ChalanItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chalan = Chalan::all();
        $customer = Customer::all();
        $product = Product::all();
        return view('chalan.index', ['chalans' => $chalan, 'customer' => $customer, 'products' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'date' => "required|date",
            'customer_id' => 'required|integer',
            'chalan_no' => 'required',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'rate' => 'required|array',
            'grand_quantity' => 'required|numeric',
            'subtotal' => 'required|array',

        ]);

        $chalan = new Chalan();
        $chalan->customer_id = $request->customer_id;
        $chalan->user_id = Auth::id();
        $chalan->date = date("Y-m-d", strtotime($request->date));
        $chalan->chalan_no = $request->chalan_no;
        $chalan->grand_quantity = $request->grand_quantity;
        $chalan->total = $request->total;
        $chalan->discount = $request->discount;
        $chalan->grand_total = $request->grand_total;

        $chalan->save();

        for ($i = 0; $i < count($request->product_id); $i++) {
            $cln_itm = new ChalanItem();
            $cln_itm->chalan_id = $chalan->id;
            $cln_itm->product_id = $request->product_id[$i];
            $cln_itm->quantity = $request->quantity[$i];
            $cln_itm->rate = $request->rate[$i];
            $cln_itm->sub_total = $request->subtotal[$i];
            $cln_itm->save();
        }

        return redirect()->route('chalan')->with('success', 'Successfully! New chalan information added.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Chalan $chalan
     * @return \Illuminate\Http\Response
     */
    public function show(Chalan $chalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Chalan $chalan
     * @return \Illuminate\Http\Response
     */
    public function edit(Chalan $chalan)
    {
        $customer = Customer::all();
        $product = Product::all();
        return view('chalan.edit', ['chalan' => $chalan, 'customer' => $customer, 'products' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chalan $chalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chalan $chalan)
    {
        $request->validate([
            'date' => "required|date",
            'customer_id' => 'required|integer',
            'chalan_no' => 'required',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'rate' => 'required|array',
            'grand_quantity' => 'required|numeric',
            'subtotal' => 'required|array',

        ]);

        $chalan->customer_id = $request->customer_id;
        $chalan->user_id = Auth::id();
        $chalan->date = date("Y-m-d", strtotime($request->date));
        $chalan->chalan_no = $request->chalan_no;
        $chalan->grand_quantity = $request->grand_quantity;
        $chalan->total = $request->total;
        $chalan->discount = $request->discount;
        $chalan->grand_total = $request->grand_total;

        $chalan->save();

        try {
            ChalanItem::where('chalan_id', '=', $chalan->id)->delete();
        } catch (\Exception $exception) {

            return redirect()->route('chalan')->with('error', 'Error! Chalan Item Delete Error');
        }
        for ($i = 0; $i < count($request->product_id); $i++) {
            $cln_itm = new ChalanItem();
            $cln_itm->chalan_id = $chalan->id;
            $cln_itm->product_id = $request->product_id[$i];
            $cln_itm->quantity = $request->quantity[$i];
            $cln_itm->rate = $request->rate[$i];
            $cln_itm->sub_total = $request->subtotal[$i];
            $cln_itm->save();
        }

        return redirect()->route('chalan')->with('success', 'Successfully! Chalan information updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chalan $chalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chalan $chalan)
    {
        try {
            ChalanItem::where('chalan_id', '=', $chalan->id)->delete();
        } catch (Exception $exception) {
            return redirect()->route('chalan')->with('error', 'Error! Chalan Item Delete Error');
        }

        $chalan->delete();
        return redirect()->route('chalan')->with('success', 'Successfully! Chalan information deleted');
    }
}
