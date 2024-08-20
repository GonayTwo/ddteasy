<?php

namespace App\Tables\Columns\Orders;

use Filament\Tables\Columns\Column;

class TotalColumn extends Column
{
    protected string $view = 'tables.columns.orders.total-column';

    protected ?string $jsonField = null;

    public function jsonField(string $jsonField)
    {
        $this->jsonField = $jsonField;

        return $this;
    }

    public function getJsonField()
    {
        return $this->jsonField;
    }
}
