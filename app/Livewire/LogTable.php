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
            Column::make("At", "created_at")
                ->format(function($value, $row, Column $column) {
                    return '
                    <div class="flex gap-2 items-center justify-center">
                        <span>' . $row->created_at->format('d M Y H:i') . '</span>
                        <span class="text-gray-300"> | </span>
                        <span class="text-[#0077C3]">' . $row->created_at->diffForHumans() . '</span>
                    </div>
                    ';
                })
                ->html()
                ->sortable(),
        ];
    }
}
