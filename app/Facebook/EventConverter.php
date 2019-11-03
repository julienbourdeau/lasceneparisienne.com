<?php

namespace App\Converters;

use App\Event;
use Facebook\GraphNodes\GraphEvent;

class EventConverter
{
    public function convert(GraphEvent $node, $tz = 'Europe/Paris'): array
    {
        $start = tap($node->getStartTime())
            ->setTimezone(new \DateTimeZone($tz));

        if (null === ($endTime = $node->getEndTime())) {
            $end = clone $start;
            $end->add(\DateInterval::createFromDateString('4 hours'));
        } else {
            $end = tap($node->getEndTime())
                ->setTimezone(new \DateTimeZone($tz));
        }
        $lastUpdated = tap($node->getUpdatedTime())->setTimezone(new \DateTimeZone($tz));

        return [
            'name' => $node->getName(),
            'slug' => $this->getSlug($node),
            'description' => $node->getDescription(),
            'cover' => ['url' => optional($node->getCover())->getSource()],
            'meta' => $this->getMeta($node),
            'ticket_url' => $node->getTicketUri(),
            'start_time' => $start,
            'end_time' => $end,
            'id_facebook' => $node->getId(),
            'fb_updated_at' => $lastUpdated,
        ];
    }

    private function getMeta(GraphEvent $fb): array
    {
        return [
            'attending' => $fb->getAttendingCount(),
            'invited' => $fb->getInvitedCount(),
        ];
    }

    private function getSlug(GraphEvent $fb): string
    {
        return rtrim(
            str_slug(
                $fb->getName())
            .'-'
            .str_slug(optional($fb->getPlace())->getName())
            , '-');
    }
}
