<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Music;

class MusicTable extends DataTableComponent
{
    protected $model = Music::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Preview Audio", "path")
                ->format(fn($value) => $value
                    ? '<audio controls class="w-40">
                           <source src="'.e($value).'" type="audio/mpeg">
                           Your browser does not support the audio element.
                       </audio>'
                    : '<span class="text-gray-400 text-sm">Non Uploaded</span>'
                )
                ->html(),

            Column::make("Preview URL Audio", "music_url")
                ->format(fn($value) => $value
                    ? (
                        str_contains($value, 'spotify.com')
                        ? '<iframe src="'.e($value).'" 
                                   class="w-60 h-80 rounded" 
                                   frameborder="0" 
                                   allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
                                   loading="lazy"></iframe>'
                        : '<audio controls class="w-40">
                               <source src="'.e($value).'" type="audio/mpeg">
                               Your browser does not support the audio element.
                           </audio>'
                      )
                    : '<span class="text-gray-400 text-sm">Non URL Audio</span>'
                )
                ->html(),

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

            Column::make("Full Preview", "path")
                ->format(fn($value) => $value
                    ? '<div class="flex items-center justify-center">
                            <a href="'.$value.'" target="_blank" 
                               class="flex items-center justify-center gap-2 px-3 py-2 bg-[#0077C3] text-white text-xs rounded hover:bg-[#1A85C9]">
                                <i class="fa fa-play" aria-hidden="true"></i>
                                <span>Play</span>
                            </a>
                       </div>'
                    : '<span class="text-gray-400">Non Uploaded</span>'
                )
                ->html(),

            Column::make("Full Preview (URL)", "music_url")
                ->format(fn($value) => $value
                    ? '<div class="flex items-center justify-center">
                            <a href="'.$value.'" target="_blank" 
                               class="flex items-center justify-center gap-2 px-3 py-2 bg-[#0077C3] text-white text-xs rounded hover:bg-[#1A85C9]">
                                <i class="fa fa-play" aria-hidden="true"></i>
                                <span>Play</span>
                            </a>
                       </div>'
                    : '<span class="text-gray-400">Non URL</span>'
                )
                ->html(),

            Column::make('Actions')
                ->label(fn($row, Column $column) =>
                    '<div class="flex items-center justify-center">
                        <form method="POST" action="'.route('music.destroy', $row->id).'" onsubmit="return confirm(\'Are you sure you want to delete this audio?\');">
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
