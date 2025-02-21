<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $product_count = Product::count();
        $order_count = Order::whereDate('created_at',Carbon::today())->count();
        $omset = Order::whereDate('created_at',Carbon::today())->sum('total_price');
        $expense = Expense::whereDate('created_at',Carbon::today())->sum('amount');
        return [
            //
            Stat::make('Jumlah Produk Keseluruhan', $product_count),
            Stat::make('Jumlah Order Hari Ini', $order_count),
            Stat::make('Omset Hari Ini', 'Rp ' . number_format($omset,0,",",".")),
            Stat::make('Total Pengeluaran Hari Ini', 'Rp ' . number_format($expense,0,",","."))
        ];
    }
}
