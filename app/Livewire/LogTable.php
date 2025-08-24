<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Log;

class LogTable extends DataTableComponent
{
    protected $model = Log::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Action", "action")
                ->sortable(),
            Column::make("Ip address", "ip_address")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }
}
