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
            "The Travelling Wanderer",
        ]);
    }

    public static function isArchetypeBase($archetype_id)
    {
        $archetype = self::find($archetype_id);

        if (!$archetype) {
            return false;
        }

        return in_array($archetype->name, [
            "The Architect",
            "The Ruler",
            "The Innovator",
            "The Philosopher",
            "The Shadowbroker",
            "The Artist",
            "The Conductor",
            "The Travelling Wanderer",
        ]);
    }

    public static function getEvolution($archetype_id)
    {
        $archetype = self::find($archetype_id);

        if (!$archetype) {
            return false;
        }

        switch ($archetype->name) {
            case "The Architect":
                // find The Master
                return self::where('name', 'The Master')->first();
            case "The Ruler":
                // find The King
                return self::where('name', 'The King')->first();
            case "The Innovator":
                // find The Visionary
                return self::where('name', 'The Visionary')->first();
            case "The Philosopher":
                // find The Arch-Wizard
                return self::where('name', 'The Arch-Wizard')->first();
            case "The Shadowbroker":
                // find The Shadow Monarch
                return self::where('name', 'The Shadow Monarch')->first();
            case "The Artist":
                // find The Renaissance Artisans
                return self::where('name', 'The Renaissance Artisans')->first();
            case "The Conductor":
                // find The Maestro
                return self::where('name', 'The Maestro')->first();
            default:
                // fint The Travelling Wanderer
                return self::where('name', 'The Travelling Wanderer')->first();
        }
    }

    public static function getBaseArchetypes()
    {
        $collection = self::all();

        $filtered = $collection->filter(function ($model) {
            return $model->is_base == true;
        });

        return $filtered;
    }

    public static function getImageUrl($archetype_name)
    {
        $archetype = self::where('name', $archetype_name)->first();

        if (!$archetype) {
            return null;
        }

        return asset($archetype->image);
    }
}
