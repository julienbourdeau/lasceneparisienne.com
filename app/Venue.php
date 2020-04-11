<?php

namespace App;

use App\Collection\VenueCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\Uuid;
use Spatie\SchemaOrg\Place;
use Spatie\SchemaOrg\Schema;

class Venue extends Model
{
    use SoftDeletes,
        Searchable;

    protected static $unguarded = true;

    protected $casts = [
        'meta' => 'array',
        'source' => 'array',
        'opening_hours' => 'array',
        'lat' => 'float',
        'lng' => 'float',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $hidden = [
        'id', 'meta', 'source', 'opening_hours', 'deleted_at',
    ];

    protected $appends = [
        'canonical_url'
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
        return $this->hasMany(Event::class)->without(['venue'])->orderBy('start_time');
    }

    public function upcomingEvents()
    {
        return $this->events()->where('start_time', '>', Carbon::yesterday());
    }

    public function nextEvents($limit = 5)
    {
        return $this->upcomingEvents()->limit($limit);
    }

    public function getCanonicalUrlAttribute()
    {
        return canonical($this);
    }

    public function toSchema(): Place
    {
        $canonical = $this->canonical_url;

        return Schema::place()
            ->identifier($canonical)
            ->url($canonical)
            ->name($this->name)
            ->address($this->address_formatted)
            ->geo(Schema::geoCoordinates()
                ->latitude($this->lat)
                ->longitude($this->lng)
            );
    }

    public function toMapPoint()
    {
        return [
            "type" => "Feature",
            "properties" => [
                "description" => '<strong>'.$this->name.'</strong>',
                "icon" => "music"
            ],
            "geometry" => [
                "type" => "Point",
                "coordinates" => [$this->lng, $this->lat],
            ]
        ];
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        unset($array['created_at'], $array['updated_at']);

        $array['total_events_count'] = $this->events()->count();
        $array['upcoming_events_count'] = $this->upcomingEvents()->count();

        return $array;
    }

    public function getAlgoliaIndexSettings()
    {
        return [
            'searchableAttributes' => [
                'name', 'description', 'address_formatted', 'email', 'id_facebook', 'uuid'
            ],
            'unretrievableAttributes' => ['id_facebook'],
            'disableTypoToleranceOnAttributes' => ['id_facebook', 'uuid'],
            'ranking' => [
                'desc(upcoming_events_count)', 'typo', 'geo', 'words', 'filters', 'proximity', 'attribute', 'exact', 'custom'
            ],
            'customRanking' => ['desc(total_events_count)'],
        ];
    }

    public function newCollection(array $models = [])
    {
        return new VenueCollection($models);
    }
}
