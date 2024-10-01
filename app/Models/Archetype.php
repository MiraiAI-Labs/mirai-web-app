<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Archetype extends Model
{
    protected $table = 'archetypes';

    public $incrementing = true;

    protected $fillable = ['name', 'description', 'image'];

    protected $appends = ['is_base'];

    public function getIsBaseAttribute()
    {
        return in_array($this->name, [
            "The Architect",
            "The Ruler",
            "The Innovator",
            "The Philosopher",
            "The Shadowbroker",
            "The Artist",
            "The Conductor",
        ]);
    }

    public static function getBaseArchetypes()
    {
        $collection = self::all();

        $filtered = $collection->filter(function ($model) {
            return $model->is_base == true;
        });

        return $filtered;
    }
}
