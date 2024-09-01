<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionStack extends Model
{
    protected $table = 'position_stacks';

    public $incrementing = true;

    protected $fillable = ['rank', 'name', 'position_id', 'date'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
