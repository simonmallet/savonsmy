<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('purchase_orders.index');
    }
}
