<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Idea extends Model
{
    use Rateable;

    protected $fillable = [
        'uuid', 'user_id', 'is_active', 'is_submitted', 'submitted_at', 'is_approved', 'approved_at', 'is_featured', 'featured_at', 'topic', 'title',
		'short_description', 'description',
		'name','contact','email','address','entrepreneur_id','product_code','order_id',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Boot Function
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(static function ($model) {
            if (self::whereUuid(uuid(8, 4, 4))->exists()) {
                $model->uuid = uuid(8, 4, 4);
            } else {
                $model->uuid = uuid(8, 4, 4);
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'first_name' => 'Guest', 'last_name' => 'Author',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class)->where(['is_liked' => true]);
    }

    /**
     * @return \Illuminate\Database\Query\Builder|\willvincent\Rateable\Rating
     */
    public function avgRating()
    {
        return $this->ratings()->selectRaw('ROUND((AVG(rating)), 2) as avgRating, rateable_id');
	}

	public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
