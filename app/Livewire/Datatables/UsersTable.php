<?php

namespace App\Livewire\Datatables;

use App\Models\User;
use Arm092\LivewireDatatables\Column;
use Illuminate\Database\Eloquent\Model;
use Arm092\LivewireDatatables\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{
    public string|null|Model $model = User::class;

    public function getBuilder()
    {
        return User::query();
    }

    public function getColumns(): array|Model
    {
        return [
            Column::name('userStatistic.archetype.image')->view('tables.archetype-icon')
                ->label('Archetype')
                ->hideable(),

            Column::name('name')
                ->label('Name')
                ->defaultSort('asc')
                ->searchable()
                ->hideable(),

            // Column::name('userStatistic.average')
            //     ->label('Overall')
            //     ->sortable()
            //     ->hideable(),

            Column::name('userStatistic.exp')
                ->label('Exp')
                ->sortable()
                ->hideable(),
        ];
    }
}
