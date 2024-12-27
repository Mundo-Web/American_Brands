<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // conteo y costo total ventas de los dos ultimos meses
        $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        $sales = Sale::select([
            DB::raw('COUNT(id) AS quantity'),
            DB::raw('SUM(total + address_price) AS total'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month')
        ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status_id', [3, 4, 5])
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(2)
            ->get();

        $salesThisMonth = $sales->get(0) ?? json_decode('{"month": null, "total": 0, "quantity": 0}');
        $salesLastMonth = $sales->get(1) ?? json_decode('{"month": null, "total": 0, "quantity": 0}');

        if ($salesThisMonth->month) {
            $date = Carbon::createFromFormat('Y-m', $salesThisMonth->month);
            $salesThisMonth->month = $date->locale('es')->translatedFormat('F Y');
        } else {
            $salesThisMonth->month = 'Mes actual';
        }
        if ($salesLastMonth->month) {
            $date = Carbon::createFromFormat('Y-m', $salesLastMonth->month);
            $salesLastMonth->month = $date->locale('es')->translatedFormat('F Y');
        } else {
            $salesLastMonth->month = 'Mes anterior';
        }

        // conteo de ventas del mes actual por dia, se debe obtener la cantidad de ventas y el monto total
        $salesPerDay = Sale::select([
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day'),
            DB::raw('COUNT(id) AS quantity'),
            DB::raw('SUM(total + address_price) AS total')
        ])
            ->whereMonth('created_at', now()->month)
            ->whereIn('status_id', [3, 4, 5])
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $pendingSales = Sale::where('status_id', 3)->count();
        $servedSales = Sale::whereIn('status_id', [4, 5])->count();

        $topProducts = SaleDetail::select([
            'sale_details.product_image AS image',
            'sale_details.product_name AS name',
            'sale_details.product_color AS color',
            DB::raw('COUNT(DISTINCT sales.email) AS total_customers'),
            DB::raw('SUM(quantity) AS total_quantity'),
            DB::raw('SUM(quantity * price) AS total_price')
        ])
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereIn('sales.status_id', [3, 4, 5])
            ->groupBy('sale_details.product_name', 'sale_details.product_image', 'sale_details.product_color')
            ->orderBy('total_price', 'desc')
            ->limit(10)
            ->get();

        $topDistricts = Sale::select([
            'address_department AS department',
            'address_province AS province',
            'address_district AS district',
            DB::raw('COUNT(id) AS quantity')
        ])
            ->whereNotNull('address_district')
            ->whereIn('status_id', [3, 4, 5])
            ->groupBy('department', 'province', 'district')
            ->limit(10)
            ->orderBy('quantity', 'DESC')
            ->get();

        return view('pages/dashboard/dashboard')
            ->with('salesThisMonth', $salesThisMonth)
            ->with('salesLastMonth', $salesLastMonth)
            ->with('salesPerDay', $salesPerDay)
            ->with('pendingSales', $pendingSales)
            ->with('servedSales', $servedSales)
            ->with('topProducts', $topProducts)
            ->with('topDistricts', $topDistricts);
    }

    public function topProducts(Request $request, $orderBy = 'total_price')
    {
        return SaleDetail::select([
            'sale_details.product_image AS image',
            'sale_details.product_name AS name',
            'sale_details.product_color AS color',
            DB::raw('COUNT(DISTINCT sales.email) AS total_customers'),
            DB::raw('SUM(quantity) AS total_quantity'),
            DB::raw('SUM(quantity * price) AS total_price')
        ])
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereIn('sales.status_id', [3, 4, 5])
            ->groupBy('product_name', 'product_image', 'product_color')
            ->orderBy($orderBy, 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
