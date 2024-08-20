<?php

namespace App\Helpers;

use App\Enums\HouseRanges;
use App\Enums\PeriodTypes;
use App\Enums\PropertyTypes;
use App\Enums\ServicePeriods;
use App\Enums\SortOptions;
use App\Models\Partners\CompanyService;
use App\Models\Services\Service;
use App\Services\FindCep\Entities\Coordinates;
use App\Services\Pagarme;
use App\Services\Pagarme\Enums\PaymentMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderHelper
{
    public static function propertyToArray(PropertyTypes $property_type, ?int $rooms, ?HouseRanges $range): array
    {
        return [
            'type' => $property_type->value,
            'value' => $rooms ?? $range,
        ];
    }

    public static function periodToArray(PeriodTypes $period_type, ?ServicePeriods $period, ?string $range): array
    {
        return [
            'type' => $period_type->value,
            'value' => $period->value ?? $range,
        ];
    }

    public static function getServicesThatExterminatesTheSelectedPlagues(Collection $plagues): Collection
    {
        $services = Service::where(function ($query) use ($plagues) {
            foreach ($plagues as $plague) {
                $query->whereHas('plagues', function ($query) use ($plague) {
                    $query->where('plagues.slug', $plague->slug);
                });
            }
        })->orWhere(function ($query) use ($plagues) {
            $query->whereDoesntHave('plagues');
            $query->whereHas('plagues', function ($query) use ($plagues) {
                $query->whereIn('plagues.slug', $plagues->pluck('slug'));
            }, '>=', count($plagues));
        })->get();

        return $services;
    }

    public static function getCompaniesInRadiusArea(Builder $query, Coordinates $coordinates, float $radius = 25)
    {
        $sql = 'addresses.*, 6371 * acos(cos(radians(?)) 
        * cos(radians(addresses.lat)) 
        * cos(radians(addresses.lon) - radians(?)) 
        + sin(radians(?)) 
        * sin(radians(addresses.lat))) AS distance';

        $bindings = [$coordinates->location->lat, $coordinates->location->lon, $coordinates->location->lat];

        return $query->with('address', fn ($query) => $query->selectRaw($sql, $bindings))
            ->whereHas('address', fn ($query) => $query->selectRaw($sql, $bindings)->having('distance', '<=', $radius))
            ->whereHas('companyServices');
    }

    /**
     * @param  string  $order_by  [closest, distant, cheapest, costiest]
     * @return Collection
     */
    public static function sortCompanies(Collection $query, ?SortOptions $order_by)
    {
        return match ($order_by) {
            SortOptions::Recommendation => self::sortByClosest($query),
            SortOptions::Closest => self::sortByClosest($query),
            SortOptions::Cheapest => self::sortByCheapest($query),
            SortOptions::Costiest => self::sortByCostiest($query),
            default => self::sortByClosest($query),
        };
    }

    private static function sortByClosest(Collection $companies): Collection
    {
        return $companies->sortBy(fn ($company) => $company->address->distance)->values();
    }

    private static function sortByDistant(Collection $companies): Collection
    {
        return $companies->sortByDesc(fn ($company) => $company->address->distance)->values();
    }

    private static function sortByCheapest(Collection $companies): Collection
    {
        return $companies->sortBy(fn ($company) => $company->services->first()->pivot->daily_price)->values();
    }

    private static function sortByCostiest(Collection $companies): Collection
    {
        return $companies->sortByDesc(fn ($company) => $company->services->first()->pivot->daily_price)->values();
    }

    public static function schedulingIsInitialized(): bool
    {
        return session()->get('scheduling.order') && session()->get('scheduling.address') && session()->get('scheduling.selected_plagues');
    }

    public static function checkoutIsInitialized(): bool
    {
        return session()->get('scheduling.order') && session()->get('scheduling.address') && session()->get('scheduling.selected_plagues');
    }

    public static function makeOrder(PaymentMethods $payment_method, ?string $card_id = null): \App\Services\Pagarme\Entities\Orders\Order
    {
        $order = new Pagarme\Entities\Orders\Order();
        $order->customer()->byId(auth()->user()->userable->pagarme->id);
        $order->items->add(Pagarme\Entities\Orders\Item::fromCompanyService(CompanyService::find(session()->get('scheduling.order.items.0.id'))));
        match ($payment_method) {
            PaymentMethods::CreditCard => $order->payments()->credit_card($card_id),
            PaymentMethods::Pix => $order->payments()->pix(),
        };

        return $order;
    }

    public static function getResponseData(PaymentMethods $payment_method, mixed $response)
    {
        return match ($payment_method) {
            PaymentMethods::CreditCard => data_get($response, 'charges.0.last_transaction.gateway_response'),
            PaymentMethods::Pix => data_get($response, 'charges.0.last_transaction')
        };
    }
}
