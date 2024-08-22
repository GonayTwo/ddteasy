<?php

namespace App\Filament\Partner\Resources\Orders\OrderResource\Pages;

use App\Filament\Partner\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
