<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class CustomerTable extends DataTableComponent
{
    protected $model = Customer::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTableRowUrl(function ($client) {
            return route('customers.show', $client);
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
            Column::make("Адрес", "address")
                ->sortable(),
            Column::make("Источник", "source")
                ->sortable(),
            Column::make("Комментарий", "comment")
                ->sortable(),
        ];
    }
}
