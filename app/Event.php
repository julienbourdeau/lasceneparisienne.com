<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\Uuid;
use Spatie\SchemaOrg\Schema;

class Event extends Model
{
    use SoftDeletes,
        Searchable;

    protected static $unguarded = true;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'canceled' => 'boolean',
        'soldout' => 'boolean',
        'meta' => 'array',
        'source' => 'array',
        'last_pulled_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $appends = [
        'cover_url',
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

    public function getCoverUrlAttribute()
    {
        return asset('/storage/covers'.$this->cover);
    }

    public function getDescriptionHtmlAttribute()
    {
        // Automatic linking
        $url = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        $html = preg_replace($url, '<a href="http$2://$4" rel="nofollow">$0</a>', $this->description);

        return nl2br($html);
    }

    public function getCanonicalUrlAttribute()
    {
        return canonical($this);
    }

    public function getMetaDescriptionAttribute()
    {
        return str_limit($this->description, 155);
    }

    public function toSchema()
    {
        $canonical = $this->getCanonicalUrlAttribute();

        return Schema::musicEvent()
            ->identifier($canonical)
            ->url($canonical)
            ->name($this->name)
            ->location($this->venue->toSchema())
            ->startDate($this->start_time)
            ->endDate($this->end_time)
            ->description($this->description)
            ->image($this->cover_url);
    }

    public function toArray()
    {
        $array = parent::toArray();

        unset($array['source']);

        return $array;
    }
}
