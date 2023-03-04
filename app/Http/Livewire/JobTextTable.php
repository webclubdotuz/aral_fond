<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;

class JobTextTable extends DataTableComponent
{
    protected $model = Job::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTableRowUrl(function ($client) {
            // return route('personals.show', $client);
        })->setTableAttributes([
            'class' => 'table-bordered table-hover',
        ]);
    }

    public function builder(): Builder
    {
        return Job::query()->where('type', 'text');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Катнасыушы", "personal.fullname")
                ->sortable(),
            Column::make("Файл", 'id')
                ->format(function ($value, $column, $row) {
                    return view('components.job-file-view', ['job' => Job::find($value)]);
                }),
            Column::make("Уақыты", "created_at")
                ->sortable(),
        ];
    }
}
