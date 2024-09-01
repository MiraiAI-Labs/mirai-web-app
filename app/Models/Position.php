<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

    public $incrementing = true;

    protected $fillable = ['name', 'slug', 'description'];

    public function generateSlug(): string
    {
        return strtolower(str_replace(' ', '-', $this->name));
    }

    public function stacks()
    {
        return $this->hasMany(PositionStack::class);
    }
}
