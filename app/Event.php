<?php

namespace App;

use App\Collection\EventCollection;
use Carbon\Carbon;
use Eluceo\iCal\Component\Event as IcalEvent;
use Eluceo\iCal\Property\Event\Geo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\Uuid;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\SchemaOrg\MusicEvent;
use Spatie\SchemaOrg\Schema;

class Event extends Model implements Feedable
{
    use SoftDeletes;
    use HasCoverImageAttribute;
    use Searchable;

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

    protected $hidden = [
        'id', 'venue_id', 'deleted_at', 'meta', 'source',
    ];

    protected $appends = ['canonical_url'];

    protected $with = ['venue'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function startDateIs(\DateTime $newDate)
    {
        return $this->start_time->rawFormat('Y-m-d') === $newDate->format('Y-m-d');
    }

    public function isPast()
    {
        return $this->start_time->format('ymd') < now()->format('ymd');
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

    public function getFacebookUrlAttribute()
    {
        return "https://www.facebook.com/events/{$this->id_facebook}/";
    }

    public function getMetaDescriptionAttribute()
    {
        return str_limit($this->description, 155);
    }

    public function getPopularityAttribute()
    {
        $rsvp = $this->meta['rsvp'] ?? [];
        extract($rsvp + [
            'maybe' => 0,
            'noreply' => 0,
            'declined' => 0,
            'attending' => 0,
        ]);

        return eventPopularity($declined, $noreply, $maybe, $attending);
    }

    public function toSchema(): MusicEvent
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
            ->image($this->cover);
    }

    public function toArray()
    {
        $array = parent::toArray();

        unset($array['source']);

        return $array;
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        if ($this->isPast()) {
            $array['in_days'] = $this->start_time->diffInDays();
        } else {
            $array['in_days'] = 1000 + $this->start_time->diffInDays();
        }
        $array['popularity'] = $this->popularity;
        $array['start_date'] = $this->start_time->toFormattedDateString();

        unset(
            $array['slug'],
            $array['start_time'], $array['end_time'],
            $array['created_at'], $array['updated_at'],
            $array['fb_updated_at'], $array['last_pulled_at']
        );

        if ($this->venue) {
            $array['venue'] = [
                'name' => $this->venue->name,
                'city' => $this->venue->city,
                'address_formatted' => $this->venue->address_formatted,
                'lat' => $this->venue->lat,
                'lng' => $this->venue->lng,
                'canonical_url' => $this->venue->canonical_url,
            ];
        }

        return $array;
    }

    public function getAlgoliaIndexSettings()
    {
        return [
            'hitsPerPage' => 6,
            'searchableAttributes' => [
                'name', 'description', 'venue.name', 'venue.address_formatted', 'id_facebook', 'uuid',
            ],
            'unretrievableAttributes' => ['id_facebook', 'popularity'],
            'disableTypoToleranceOnAttributes' => ['id_facebook', 'uuid'],
            'ranking' => [
                'asc(in_days)', 'typo', 'geo', 'words', 'filters', 'proximity', 'attribute', 'exact', 'custom',
            ],
            'customRanking' => ['desc(popularity)'],
        ];
    }

    public function toIcalEvent()
    {
        $vEvent = (new IcalEvent($this->uuid))
            ->setSummary($this->name)
            ->setDescription($this->description)
            ->setStatus($this->is_canceled ? IcalEvent::STATUS_CANCELLED : IcalEvent::STATUS_CONFIRMED)
            ->setDtStart($this->start_time)
            ->setDtEnd($this->end_time)
            ->setDtStamp($this->created_at)
            ->setUrl($this->canonical_url)
            ->setModified($this->last_pulled_at)
        ;

        if ($venue = $this->venue) {
            $vEvent->setLocation(
                implode(', ', [$venue->name, $venue->address_formatted]),
                $venue->name
            );
        }
        if ($venue->lat && $venue->lng) {
            $vEvent->setGeoLocation(new Geo($venue->lat, $venue->lng));
        }

        return $vEvent;
    }

    public static function getAllFeedEvents()
    {
        return static::where('start_time', '>', Carbon::yesterday())
            ->orderByDesc('created_at')
            ->get();
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->uuid)
            ->title($this->name.' ['.$this->start_time->toDateString().']')
            ->summary($this->description_html)
            ->updated($this->updated_at)
            ->link($this->canonical_url)
            ->author('Julien Bourdeau');
    }

    public function newCollection(array $models = [])
    {
        return new EventCollection($models);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::getFactory()->uuid4();
        });
    }
}
