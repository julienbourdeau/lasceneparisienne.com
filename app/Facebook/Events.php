<?php

namespace App\Facebook;

use Facebook\Facebook;
use Facebook\GraphNodes\GraphEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Events
{
    private $fb;

    private $token;

    private $fields;

    public function __construct(Facebook $facebook)
    {
        $this->fb = $facebook;

        $this->token = Cache::get('facebook-token');

        $this->fields = [
            'id', 'name', 'description', 'cover',
            'interested_count', 'attending_count', 'declined_count', 'maybe_count', 'noreply_count',
            'start_time', 'end_time', 'event_times',
            'place',
            'type', 'updated_time', 'timezone',
        ];
    }

    public function next()
    {
        $response = $this->fb->get('/me/events?since='.time().'&fields='.implode(',', $this->fields), $this->token);

        $edge = $response->getGraphEdge('GraphEvent');

        return $edge->all()[0];
    }

    public function upcoming()
    {
        $response = $this->fb->get('/me/events?since='.time().'&fields='.implode(',', $this->fields), $this->token);
        $client = $this->fb->getClient();
        $events = collect([]);

        do {
            if (isset($nextRequest) && !is_null($nextRequest)) {
                $response = $client->sendRequest($nextRequest);
            }

            $edge = $response->getGraphEdge('GraphEvent');
            $events = $events->merge(collect($edge->getIterator())
                ->map(function (GraphEvent $e) {
                    return $e;
                }));
        } while ($nextRequest = $edge->getNextPageRequest());

        return $events;
    }

    public function upcomingFiltered($idsToRemove)
    {
        return $this->upcoming()
            ->filter(function (GraphEvent $item) use ($idsToRemove) {
                return !in_array($item->getId(), $idsToRemove);
            });
    }

    public function get($id)
    {
        $response = $this->fb->get('/'.$id.'?fields='.implode(',', $this->fields), $this->token);

        return $response->getGraphEvent();
    }

    public function eachUpcoming(\Closure $cb)
    {
        $this->each($cb, time());
    }

    public function each(\Closure $cb, int $sinceTs = null)
    {
        $since = $sinceTs ?? now()->subYears(2)->timestamp;

        $response = $this->fb->get('/me/events?since='.$since.'&fields='.implode(',', $this->fields), $this->token);
        $client = $this->fb->getClient();

        do {
            if (isset($nextRequest) && !is_null($nextRequest)) {
                $response = $client->sendRequest($nextRequest);
            }

            $edge = $response->getGraphEdge('GraphEvent');
            foreach ($edge->getIterator() as $item) {
                $cb($item);
            }
        } while ($nextRequest = $edge->getNextPageRequest());
    }
}
