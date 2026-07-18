<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use PDO;

class OracleStatsService
{
    public function dashboard(): array
    {
        $pdo = DB::connection()->getPdo();

        $totalProducts = 0;
        $totalOrders = 0;
        $totalRevenue = 0.0;
        $lowStock = 0;
        $pendingOrders = 0;

        $stmt = $pdo->prepare(
            'BEGIN sp_dashboard_stats(:p1, :p2, :p3, :p4, :p5); END;'
        );

        $stmt->bindParam(':p1', $totalProducts, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(':p2', $totalOrders, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(':p3', $totalRevenue, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(':p4', $lowStock, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindParam(':p5', $pendingOrders, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->execute();

        return [
            'total_products' => (int) $totalProducts,
            'total_orders' => (int) $totalOrders,
            'total_revenue' => (float) $totalRevenue,
            'low_stock' => (int) $lowStock,
            'pending_orders' => (int) $pendingOrders,
        ];
    }

    public function totalRevenue(?string $status = null): float
    {
        $pdo = DB::connection()->getPdo();
        $result = 0.0;

        $stmt = $pdo->prepare('BEGIN :ret := fn_total_revenue(:status); END;');
        $stmt->bindParam(':ret', $result, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 32);
        $stmt->bindValue(':status', $status);
        $stmt->execute();

        return (float) $result;
    }
}
