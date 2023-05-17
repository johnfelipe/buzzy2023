<?php

namespace App;

use App\Vote;
use App\Report;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_seen'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'data',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->username_slug = Str::slug($user->username);
            if (Auth::check() && Auth::user()->id === $user->id) {
                $user->last_seen = Carbon::now();
                $user->ipno = request()->ip();
            }
        });

        static::deleting(function (User $user) {
            $user->comments()->delete();
            $user->votes()->delete();
            $user->reports()->delete();
        });
    }

    public function votes()
    {
          return $this->hasMany(Vote::class);
    }

    public function comments()
    {
          return $this->hasMany(Comment::class);
    }

    public function reports()
    {
          return $this->hasMany(Report::class);
    }

    public function isAdmin()
    {
        return $this->user_type == 'admin';
    }

    public function scopeByType($query, $type)
    {
        return $query->where('user_type', $type);
    }

    public function isOnline()
    {
        return get_user_is_online($this->last_seen);
    }
}
