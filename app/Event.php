<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Event extends Model
{
    use SoftDeletes;

    protected static $unguarded = true;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'canceled' => 'boolean',
        'soldout' => 'boolean',
        'cover' => 'array',
        'meta' => 'array',
        'source' => 'array',
        'last_pulled_at' => 'datetime',
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

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}