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
            Column::name('userStatistic.archetype.id')->view('tables.archetype-icon')
                ->label('Archetype')
                ->hideable(),

            Column::name('name')
                ->label('Name')
                ->defaultSort('asc')
                ->searchable()
                ->hideable(),

            Column::name('userStatistic.cognitive')
                ->label('Kognitif')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.motivation')
                ->label('Motivasi')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.adaptability')
                ->label('Adaptabilitas')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.creativity')
                ->label('Kreativitas')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.eq')
                ->label('EQ')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.interpersonal')
                ->label('Interpersonal')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.technical')
                ->label('Teknikal')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.scholastic')
                ->label('Skolastik')
                ->sortable()
                ->hideable(),

            Column::name('userStatistic.exp')
                ->label('Exp')
                ->sortable()
                ->hideable(),

            Column::name('id')->view('tables.hire')
                ->label('Hubungi')
                ->hideable(),
        ];
    }
}
