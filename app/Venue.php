<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Venue extends Model
{
    use SoftDeletes;

    protected static $unguarded = true;

    protected $casts = [
        'cover' => 'array',
        'meta' => 'array',
        'opening_hours' => 'array',
        'lat' => 'float',
        'lng' => 'float',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::getFactory()->uuid4();
        });
    }

    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('start_time');
    }

    public function upcomingEvents()
    {
        return $this->events()->where('start_time', '>', Carbon::yesterday());
    }

    public function nextEvents($limit = 5)
    {
        return $this->events()
            ->where('start_time', '>', time())
            ->limit($limit);
    }
}
