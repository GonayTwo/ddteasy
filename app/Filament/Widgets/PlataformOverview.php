<?php

namespace App\Filament\Widgets;

use App\Models\Orders\Order;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlataformOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        return [
            Stat::make('Receita Total', $this->formatCurrency($this->getTotalRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-banknotes')
                ->description('Receita total da plataforma no período selecionado'),

            Stat::make('Receita dos Parceiros', $this->formatCurrency($this->getPartnersRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-user-group')
                ->description('Receita dos parceiros no período selecionado'),

            Stat::make('Receita da DDTeasy', $this->formatCurrency($this->getDDTeasyRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-bug-ant')
                ->description('Receita da DDTeasy no período selecionado'),

            Stat::make('Receita Total à Receber', $this->formatCurrency($this->getTotalRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-banknotes')
                ->description('Receita total da plataforma à Receber no período selecionado'),

            Stat::make('Receita dos Parceiros à Receber', $this->formatCurrency($this->getPartnersRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-user-group')
                ->description('Receita dos parceiros à Receber no período selecionado'),

            Stat::make('Receita da DDTeasy à Receber', $this->formatCurrency($this->getDDTeasyRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-bug-ant')
                ->description('Receita da DDTeasy à Receber no período selecionado'),
        ];
    }

    private function getTotalRevenueInTimePeriod(array $timePeriod, OrderPaymentStatus $status)
    {
        return Order::where('payment_status', $status)
            ->whereBetween('created_at', $timePeriod)
            ->get()
            ->sum(fn ($order) => collect($order->items)->sum('daily_price'));
    }

    private function getDDTeasyRevenueInTimePeriod(array $timePeriod, OrderPaymentStatus $status)
    {
        return $this->getTotalRevenueInTimePeriod($timePeriod, $status) * config('ddteasy.charge');
    }

    private function getPartnersRevenueInTimePeriod(array $timePeriod, OrderPaymentStatus $status)
    {
        return $this->getTotalRevenueInTimePeriod($timePeriod, $status) - $this->getDDTeasyRevenueInTimePeriod($timePeriod, $status);
    }

    private function getTimePeriod(): array
    {
        return [$this->filters['startDate'] ?? now()->startOfYear(), $this->filters['endDate'] ?? now()];
    }

    private function formatCurrency(int $currency)
    {
        return 'R$ ' . number_format($currency / 100, 2, decimal_separator: ',', thousands_separator: '.');
    }
}
