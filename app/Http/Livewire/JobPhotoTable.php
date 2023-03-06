<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Termwind\Components\Dd;

class JobPhotoTable extends DataTableComponent
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
        return Job::query()->where('type', 'photo')->where('status', 'active')->orderBy('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Катнасыушы", "personal.fullname")
                ->sortable(),
                Column::make("Адрес", "personal.rayon")
                ->sortable(),
            Column::make("Мектеп", "personal.school")
                ->sortable(),
            Column::make("Класс", "personal.class")
                ->sortable(),
            Column::make("Файл", 'id')
                ->format(function ($value, $column, $row) {
                    return view('components.job-file-view', ['job' => Job::find($value)]);
                }),
            Column::make("Бахалаушы", 'id')
                ->format(function ($value, $column, $row) {
                    $job = Job::find($value);
                    $user = User::find($job->user_id);
                    return $user ? $user->fullname : '<i class="mdi mdi-account-alert text-danger"></i>';
                })
                ->html(),
            Column::make("Балл", 'ball')
                ->format(function ($value, $column, $row) {
                    return $value ? $value : '<i class="mdi mdi-timer-sand"></i>';
                })
                ->html(),
            Column::make("Уақыты", "created_at")
                ->sortable(),
        ];
    }
}
