<?php

namespace App\Models\Orders;

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\Customers\Customer;
use App\Models\Partners\Company;
use App\Models\Partners\CompanyPartner;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use App\Services\Pagarme\Enums\PaymentMethods;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'pagarme_id',
        'date',
        'observation',
        'payment_method',
        'items',
        'property',
        'period',
        'recomendations',
        'finished',
        'payment_status',
        'partner_payment_attachment',
    ];

    protected $casts = [
        'payment_method' => PaymentMethods::class,
        'items' => 'array',
        'property' => 'array',
        'period' => 'array',
        'payment_status' => OrderPaymentStatus::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function userCompany(): BelongsTo
    {
        return $this->belongsTo(CompanyPartner::class, 'company_id', 'company_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function orderStatusUpdates(): HasMany
    {
        return $this->hasMany(OrderStatusUpdate::class);
    }

    public function latestStatus(): Attribute
    {
        return new Attribute(get: fn (): OrderStatus => $this->orderStatusUpdates()?->orderByDesc('created_at')->first()?->status ?? OrderStatus::Open);
    }

    public function pagarme(): Attribute
    {
        return new Attribute(get: fn () => (new PagarmeService)->orders()->get($this->pagarme_id));
    }

    public function itemsTotalPrice(): Attribute
    {
        return new Attribute(get: fn () => collect($this->items)->sum('daily_price'));
    }
}
