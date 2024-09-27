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
}
