<?php

namespace App\Http\Controllers;

use App\Models\Chalan;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function show(Chalan $chalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function edit(Chalan $chalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chalan $chalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chalan $chalan)
    {
        //
    }
}
