<?php

namespace App\Livewire;

use App\Models\Image;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class ImageTable extends DataTableComponent
{
    protected $model = Image::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Preview Image", "path")
            ->format(fn($value) => $value
            ? '<img src="'.e($value).'" class="w-16 h-16 items-center justify-center object-cover rounded">'
            : '<span class="text-gray-400 text-sm">Non Uploaded</span>'
            )
            ->html(),

            Column::make("Preview URL Image", "image_url")
            ->format(fn($value) => $value
            ? '<img src="'.e($value).'" class="w-16 h-16 items-center justify-center object-cover rounded">'
            : '<span class="text-gray-400 text-sm">Non URL Image</span>'
            )
            ->html(),

            Column::make("Uploader", "user.username")
                ->format(fn($value) => '<span class="font-semibold text-green-500">'.$value.'</span>')
                ->html()
                ->sortable(),

            Column::make("Uploaded", "created_at")
                ->sortable(),

            Column::make("Filename", "path")
                ->format(fn($value) => $value 
                    ? '<div class="flex items-center justify-center">
                            <a href="'.$value.'" target="_blank" 
                            class="flex items-center justify-center gap-2 px-3 py-2 bg-[#0077C3] text-white text-xs rounded hover:bg-[#1A85C9]">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span>View</span>
                            </a>
                    </div>'
                    : '<span class="text-gray-400">Non Uploaded</span>'
                )
                ->html(),

            Column::make("URL", "image_url")
                ->format(fn($value) => $value 
                    ? '<div class="flex items-center justify-center">
                            <a href="'.$value.'" target="_blank" 
                            class="flex items-center justify-center gap-2 px-3 py-2 bg-[#0077C3] text-white text-xs rounded hover:bg-[#1A85C9]">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span>View</span>
                            </a>
                    </div>'
                    : '<span class="text-gray-400">Non URL</span>'
                )
                ->html(),
               
            Column::make('Actions')
                ->label(fn($row, Column $column) => 
                    '<div class="flex items-center justify-center">
                        <form method="POST" action="'.route('image.destroy', $row->id).'" onsubmit="return confirm(\'Are you sure you want to delete this image?\');">
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
