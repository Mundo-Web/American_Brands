<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bySale(Request $request, string $sale)
    {
        $details = SaleDetail::select('sale_details.*' , 'sales.doc_number' )
        ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
        ->where('quantity', '>', 0)
        ->where('sale_id', $sale)
        ->get();
        return $details;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleDetailRequest $request, SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleDetail $saleDetail)
    {
        //
    }
}
