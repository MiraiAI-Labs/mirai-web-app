<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'positionChosen',
    ];

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function getLastNameAttribute(): string
    {
        $name = explode(' ', $this->name);

        return (count($name) > 2) ? $name[2] : $name[1];
    }

    public function getPositionChosenAttribute(): bool
    {
        return $this->position()->exists();
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function userStatistic()
    {
        if (!UserStatistic::where('user_id', $this->id)->exists()) {
            $archetype = Archetype::where('name', 'The Travelling Wanderer')->first();
            $userStatistic = new UserStatistic();
            $userStatistic->user_id = $this->id;
            $userStatistic->archetype_id = $archetype->id;
            $userStatistic->save();
        }

        return $this->hasOne(UserStatistic::class);
    }

    public static function createIfNotExists(array $attributes): ?User
    {
        if (!array_key_exists('email', $attributes)) {
            return null;
        }

        // check if user already exists
        if (User::where('email', $attributes['email'])->exists()) {
            return null;
        }

        $user = User::create($attributes);

        return ($user) ? $user : null;
    }
}
