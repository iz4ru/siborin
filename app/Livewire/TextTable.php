<?php

namespace App\Livewire;

use App\Models\Text;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class TextTable extends DataTableComponent
{
    protected $model = Text::class;

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

            Column::make("Title", "title")
                ->sortable(),

            Column::make("Text Detail", "text")
                ->format(function ($value, $row, Column $column) {
                    return '
                        <div class="flex items-center justify-center">
                            <a href="' . route('text.show', $row->id) . '" 
                            class="flex items-center justify-center gap-2 px-3 py-2 bg-[#0077C3] text-white text-xs rounded hover:bg-[#1A85C9]">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span>View</span>
                            </a>
                        </div>
                    ';
                })
                ->html()
                ->sortable(),

            Column::make("Uploader", "user.username")
                ->format(fn($value) => '<span class="font-semibold">'.$value.'</span>')
                ->html()
                ->sortable(),

            Column::make("Uploaded", "created_at")
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

            Column::make('Actions')
                ->label(fn($row, Column $column) => 
                    '<div class="flex items-center justify-center">
                        <form method="POST" action="'.route('text.destroy', $row->id).'" onsubmit="return confirm(\'Are you sure you want to delete this text?\');">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="flex cursor-pointer items-center justify-center gap-2 px-3 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>'
                )
                ->html(),
        ];
    }
}
