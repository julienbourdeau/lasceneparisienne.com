<?php

namespace App\Converters;

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
            $end = $endTime->setTimezone(new \DateTimeZone($tz));
        }
        $lastUpdated = tap($node->getUpdatedTime())->setTimezone(new \DateTimeZone($tz));

        return array_merge([
            'name' => $node->getName(),
            'slug' => $this->getSlug($node),
            'description' => $node->getDescription(),
            'meta' => $this->getMeta($node),
            'ticket_url' => $node->getTicketUri(),
            'start_time' => $start,
            'end_time' => $end,
            'id_facebook' => $node->getId(),
            'fb_updated_at' => $lastUpdated,
        ], $this->getStatusAttributes($node));
    }

    private function getMeta(GraphEvent $node): array
    {
        return [
            'rsvp' => [
                'maybe' => $node->getMaybeCount(),
                'noreply' => $node->getNoreplyCount(),
                'declined' => $node->getDeclinedCount(),
                'attending' => $node->getAttendingCount(),
                'invited' => $node->getInvitedCount(),
            ],
            'cover' => optional($node->getCover())->getSource(),
        ];
    }

    private function getSlug(GraphEvent $node): string
    {
        return rtrim(
            str_slug(
                $node->getName()
            )
            .'-'
            .str_slug(optional($node->getPlace())->getName()),
            '-'
        );
    }

    private function getStatusAttributes(GraphEvent $node)
    {
        $haystack = str_replace(' ', '', str_slug($node->getName()));

        foreach (['canceled', 'cancelled', 'annule'] as $needle) {
            if (strstr($haystack, $needle)) {
                return [
                    'canceled' => true,
                    'soldout' => false,
                ];
            }
        }

        foreach (['complet', 'soldout', 'annule'] as $needle) {
            if (strstr($haystack, $needle)) {
                return [
                    'canceled' => false,
                    'soldout' => true,
                ];
            }
        }

        return [
            'canceled' => false,
            'soldout' => false,
        ];
    }
}
