<?php

namespace App\Models;

use App\Utils\NilaiHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UserStatistic extends Model
{
    protected $table = 'user_statistics';

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'archetype_id',
        'cognitive',
        'motivation',
        'adaptability',
        'creativity',
        'eq',
        'interpersonal',
        'technical',
        'scholastic',
        'exp',
    ];

    protected $extends = [
        'level',
        'percentage_to_next_level',
        'exp_to_next_level',
        'current_exp_on_current_level',
        'performance',
    ];

    private function exponentialMovingAverage($current, $previous, $alpha = 0.25)
    {
        return $alpha * $current + (1 - $alpha) * $previous;
    }

    public function evaluate(NilaiHelper $nilai)
    {
        $nilaiArray = $nilai->toArray();

        foreach ($nilaiArray as $key => $value) {
            if ($value !== null) {
                if ($key == 'exp') {
                    $this->$key += $value;
                    continue;
                }

                if ($this->$key == 0) {
                    $this->$key = ($value > 100) ? $value / 10 : $value;
                } else {
                    $this->$key = $this->exponentialMovingAverage(($value > 100) ? $value / 10 : $value, $this->$key);
                }
            }
        }

        $this->save();
    }

    public function archetype()
    {
        return $this->belongsTo(Archetype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLevelAttribute()
    {
        $exp = $this->exp;

        return $this->expToLevel($exp);
    }

    public function getPerformanceAttribute()
    {
        return [$this->cognitive, $this->scholastic, $this->technical, $this->interpersonal, $this->eq, $this->creativity, $this->adaptability, $this->motivation];
    }

    public function getPercentageToNextLevelAttribute()
    {
        $exp = $this->exp;

        return $this->percentageToNextLevel($exp);
    }

    public function getExpToNextLevelAttribute()
    {
        $level = $this->level;
        $expNeeded = $this->expNeeded($level);
        $expNeededNext = $this->expNeeded($level + 1);

        return $expNeededNext - $expNeeded;
    }

    public function getCurrentExpOnCurrentLevelAttribute()
    {
        $exp = $this->exp;

        return $this->currentExpOnCurrentLevel($exp);
    }

    private function expNeeded($level)
    {
        $a = 50; // base exp
        $r = 2; // exp growth rate

        return round($a * (pow($r, $level) - 1) / ($r - 1));
    }

    private function expToLevel($exp)
    {
        $level = 0;
        $expNeeded = 0;

        while ($exp >= $expNeeded) {
            $level++;
            $expNeeded = $this->expNeeded($level);
        }

        return $level - 1;
    }

    private function percentageToNextLevel($exp)
    {
        $level = $this->expToLevel($exp);
        $expNeeded = $this->expNeeded($level);
        $expNeededNext = $this->expNeeded($level + 1);

        return ($exp - $expNeeded) / ($expNeededNext - $expNeeded) * 100;
    }

    private function currentExpOnCurrentLevel($exp)
    {
        $level = $this->expToLevel($exp);
        $expNeeded = $this->expNeeded($level);

        return $exp - $expNeeded;
    }
}
