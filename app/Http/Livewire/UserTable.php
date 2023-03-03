<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Имя", "fullname")
                ->sortable(),
            Column::make("Логин", "username")
                ->sortable(),
            Column::make("Телефон", "phone")
                ->sortable(),
            Column::make("Роли", "id")
                ->format(function ($value) {
                    $roles = User::find($value)->roles;
                    $roles = $roles->map(function ($role) {
                        return "<span class='badge bg-primary'>{$role->name}</span>";
                    });
                    return $roles->implode(", ");
                })->html(),
            Column::make("Действия", "id")
                ->format(function ($value) {
                    return view('components.users.actions', ['user' => User::find($value)]);
                })->html(),
        ];
    }
}
