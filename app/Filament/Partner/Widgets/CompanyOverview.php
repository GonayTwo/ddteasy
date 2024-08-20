<?php

namespace App\Filament\Partner\Widgets;

use App\Models\Orders\Order;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CompanyOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Receita Total', $this->formatCurrency($this->getTotalRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-banknotes')
                ->description('Receita total da plataforma no período selecionado'),

            Stat::make('Receita do Parceiro', $this->formatCurrency($this->getPartnersRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-user-group')
                ->description('Receita do parceiro no período selecionado'),

            Stat::make('Receita da DDTeasy', $this->formatCurrency($this->getDDTeasyRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Paid)))
                ->icon('heroicon-o-bug-ant')
                ->description('Receita da DDTeasy no período selecionado'),

            Stat::make('Receita Total à Receber', $this->formatCurrency($this->getTotalRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-banknotes')
                ->description('Receita total da plataforma à Receber no período selecionado'),

            Stat::make('Receita do Parceiro à Receber', $this->formatCurrency($this->getPartnersRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-user-group')
                ->description('Receita do parceiro à Receber no período selecionado'),

            Stat::make('Receita da DDTeasy à Receber', $this->formatCurrency($this->getDDTeasyRevenueInTimePeriod($this->getTimePeriod(), OrderPaymentStatus::Pending)))
                ->icon('heroicon-o-bug-ant')
                ->description('Receita da DDTeasy à Receber no período selecionado'),
        ];
    }

    private function getTotalRevenueInTimePeriod(array $timePeriod, OrderPaymentStatus $status)
    {
        return Order::where('payment_status', $status)
            ->where('company_id', filament()->getTenant()->id)
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
