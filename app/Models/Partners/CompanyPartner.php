<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyPartner extends Pivot
{
    use HasUuids;
}
