<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

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
        return Job::query()->where('type', 'text')->where('status', 'active')->orderBy('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Катнасыушы", "personal.fullname"),
                Column::make("Адрес", "personal.rayon")
                ->sortable(),
            Column::make("Мектеп", "personal.school"),
            Column::make("Класс", "personal.class"),
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
                ->html()
                ->sortable(),
            Column::make("Уақыты", "created_at")
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        $rayons = [
            "Нөкис қаласы" => "Нөкис қаласы",
            "Әмиўдәрья районы" => "Әмиўдәрья районы",
            "Беруний районы" => "Беруний районы",
            "Бозатаў районы" => "Бозатаў районы",
            "Кегейли районы" => "Кегейли районы",
            "Қанлыкөл районы" => "Қанлыкөл районы",
            "Қараөзек районы" => "Қараөзек районы",
            "Қоңырат районы" => "Қоңырат районы",
            "Мойнақ районы" => "Мойнақ районы",
            "Нөкис районы" => "Нөкис районы",
            "Тақыятас районы" => "Тақыятас районы",
            "Тахтакөпир районы" => "Тахтакөпир районы",
            "Төрткүлъ районы" => "Төрткүлъ районы",
            "Хожели районы" => "Хожели районы",
            "Шымбай районы" => "Шымбай районы",
            "Шоманай районы" => "Шоманай районы",
            "Елликқала районы" => "Елликқала районы",
        ];


        return [
            'fullname' => TextFilter::make('Имя Фамилия')
                ->filter(function (Builder $query, $value) {
                    $query->whereHas('personal', function (Builder $query) use ($value) {
                        $query->where('fullname', 'like', '%' . $value . '%');
                    });
                }),
            'phone' => TextFilter::make('Телефон')
                ->filter(function (Builder $query, $value) {
                    $query->whereHas('personal', function (Builder $query) use ($value) {
                        $query->where('phone', 'like', '%' . $value . '%');
                    });
                }),
            'Rayon' => SelectFilter::make("Район")
                ->options($rayons)
                ->filter(function (Builder $query, $value) {
                    $query->whereHas('personal', function (Builder $query) use ($value) {
                        $query->where('rayon', $value);
                    });
                }),

            'school' => TextFilter::make('Мектеп')
                ->filter(function (Builder $query, $value) {
                    $query->whereHas('personal', function (Builder $query) use ($value) {
                        $query->where('school', 'like', '%' . $value . '%');
                    });
                }),
            'class' => TextFilter::make('Класс')
                ->filter(function (Builder $query, $value) {
                    $query->whereHas('personal', function (Builder $query) use ($value) {
                        $query->where('class', 'like', '%' . $value . '%');
                    });
                }),
        ];
    }
}
