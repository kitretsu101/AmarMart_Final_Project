<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OracleStatsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly OracleStatsService $stats) {}

    public function index(): View
    {
        $stats = $this->stats->dashboard();
        $recentOrders = Order::query()->withCount('items')->latest('id')->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
