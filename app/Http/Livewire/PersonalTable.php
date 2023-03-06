<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Personal;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class PersonalTable extends DataTableComponent
{
    protected $model = Personal::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTableRowUrl(function ($client) {
            // return route('personals.show', $client);
        })->setTableAttributes([
            'class' => 'table-bordered table-hover',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Имя Фамилия", "fullname")
                ->sortable()
                ->searchable(),
            Column::make("Телефон", "phone")
                ->sortable()
                ->searchable(),
            Column::make("Д.рождения", "birthday")
                ->sortable(),
            Column::make("Адрес", "Rayon")
                ->sortable()
            ->secondaryHeaderFilter("Район", "Rayon"),
            Column::make("Мектеп", "school")
                ->sortable(),
            Column::make("Класс", "class")
                ->sortable(),
        ];
    }

    public function filters(): array
    {

        return [
            'fullname' => TextFilter::make('Имя Фамилия'),
            'phone' => TextFilter::make('Телефон'),
            'birthday' => TextFilter::make('Д.рождения'),
            'Rayon' => TextFilter::make('Адрес'),
            'school' => TextFilter::make('Мектеп'),
            'class' => TextFilter::make('Класс'),
        ];
    }
}
