<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;

class JobExpertTable extends DataTableComponent
{
    protected $model = Job::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Job::where('user_id', auth()->user()->id)->orderBy('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Файл", 'id')
                ->format(function ($value, $column, $row) {
                    return view('components.job-file-view', ['job' => Job::find($value)]);
                }),
            Column::make("Балл", 'ball')
                ->sortable(),
            Column::make("Уақыты", "created_at")
                ->sortable(),
        ];
    }
}
