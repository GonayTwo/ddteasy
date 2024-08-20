<?php

namespace App\Models\Customers;

use App\Models\Address;
use App\Models\Orders\Order;
use App\Models\User;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['pagarme_id', 'birth_date', 'cpf', 'phone', 'contact_methods', 'consent', 'newsletter'];

    protected $casts = ['contact_methods' => AsCollection::class];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function pagarme(): Attribute
    {
        return new Attribute(get: fn () => (new PagarmeService)->customers()->get($this->pagarme_id));
    }

    public function cards(): Attribute
    {
        return new Attribute(get: fn () => (new PagarmeService)->customers()->get($this->pagarme_id)->cards()->all());
    }

    public function lastServiceDate(): Attribute
    {
        return new Attribute(get: fn () => $this->orders()->count() > 0 ? $this->orders()->orderByDesc('created_at')->limit(1)->get()->first()->created_at : null);
    }
}
