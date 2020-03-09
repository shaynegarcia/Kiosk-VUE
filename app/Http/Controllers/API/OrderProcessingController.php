<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Kiosk;
use App\Stock;
use App\Order;
use App\OrderProcessing;
use App\PaymentType;

class OrderProcessingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_processings = OrderProcessing::with('stock.product')->get();
        $order_processings_total = $order_processings->sum('total');
        return response()->json([
            'processing' => $order_processings,
            'sum' => $order_processings_total,
        ]);
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
     * @param  \App\OrderProcessing  $orderProcessing
     * @return \Illuminate\Http\Response
     */
    public function show(OrderProcessing $orderProcessing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderProcessing  $orderProcessing
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderProcessing $orderProcessing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderProcessing  $orderProcessing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderProcessing $orderProcessing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderProcessing  $orderProcessing
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderProcessing $orderProcessing)
    {
        //
    }

}
