<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Job;

class JobTable extends DataTableComponent
{
    protected $model = Job::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Personal id", "personal_id")
                ->sortable(),
            Column::make("File", 'id')
                ->format(function ($value, $column, $row) {
                    return view('components.job-file-view', ['job' => Job::find($value)]);
                }),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
