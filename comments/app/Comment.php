<?php

namespace App;

use App\User;
use App\Vote;
use App\Report;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];
    protected $appends = array('userdata');

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Comment $comment) {
            $comment->votes()->delete();
            $comment->reports()->delete();
            $comment->replies()->delete();
        });
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
          return $this->hasMany(Vote::class);
    }

    public function reports()
    {
          return $this->hasMany(Report::class);
    }

    /**
     * Filter get only parent comments.
     */
    public function scopeParent($query)
    {
        return $query->where('parent_id', null);
    }

    /**
     * Filter get only parent comments.
     */
    public function scopeOnlyReplies($query)
    {
        return $query->where('parent_id', '!=', null);
    }

   /**
     * Filter get only parent comments.
     */
    public function scopePopular($query)
    {
        return $query->withCount([
            'votes',
            'votes as votes_count' => function ($query) {
                $query->where('vote', 1);
            }])
            ->having('votes_count','>=', env('COMMENTS_POPULAR_LIKE_COUNT', 10))
            ->take(env('COMMENTS_POPULAR_COUNT', 3))
            ->orderBy('votes_count', 'desc')->get();
    }

    /**
     * Filter get approved comments.
     */
    public function scopeApproved($query, $approve = true)
    {
        return $query->where('approve', $approve);
    }

    /**
     * Filter by content id.
     */
    public function scopeByUser($query, $user_id)
    {
        if ($user_id) {
            return $query->where('user_id', intval($user_id));
        }

        return $query;
    }

    /**
     * Filter by content id.
     */
    public function scopeByContentId($query, $content_id)
    {
        if ($content_id) {
            return $query->where('content_id', $content_id);
        }

        return $query;
    }

    /**
     * Filter by domain.
     */
    public function scopeByAccessDomain($query, $access_domain)
    {
        if ($access_domain) {
            return $query->where('access_domain', $access_domain);
        }

        return $query;
    }

    /**
     * Filter get approved comments.
     */
    public function scopeOrderCommentsBy($query, $type = '')
    {
        if ($type === '') {
            $type = env('COMMENTS_DEFAULT_SORT', 'new');
        }

        if ($type === 'new') {
            return $query->orderBy('created_at', 'desc');
        } elseif ($type === 'old') {
            return $query->orderBy('created_at', 'asc');
        } elseif ($type === 'best') {
            return $query->withCount([
                'votes',
                'votes as votes_count' => function ($query) {
                    $query->where('vote', 1);
                }])
            ->orderBy('votes_count', 'desc');
        }

        return $query;
    }

    public function getDataAttribute($value)
    {
        return (array) json_decode($value);
    }


    public function getUserdataAttribute()
    {
        $data = new \stdClass();

        if ($this->user) {
            $data->type = "auth";
            $data->id = $this->user->id;
            $data->link = url('users/'.$this->user->username_slug);
            $data->admin_link = url('admin/users/'.$this->user->id);
            $data->icon = image_url_create($this->user->icon, 's', 'avatars');
            $data->username = $this->user->username;
            $data->user_type = $this->user->user_type;
        } elseif (isset($this->data['CUSER']) && $this->data['CUSER']) {
            $data->type = "cuser";
            $data->id = null;
            $data->link = $this->data['CUSER_LINK'];
            $data->admin_link = $data->link;
            $data->icon = $this->data['CUSER_ICON'];
            $data->username = $this->data['CUSER_NAME'];
            $data->user_type = null;
        } else {
            $data->type = "guest";
            $data->id = null;
            $data->link = null;
            $data->admin_link = null;
            $data->icon = image_url_create(null, 's', 'avatars');
            $data->username = isset($this->data['guest']) && isset($this->data['username']) ? $this->data['username'] : __('Guest');
            $data->user_type = 'guest';
        }

        return  $data;
    }
}
