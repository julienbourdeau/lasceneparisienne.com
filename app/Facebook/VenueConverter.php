<?php

namespace App\Facebook;

use App\Venue;
use Facebook\GraphNodes\GraphLocation;
use Facebook\GraphNodes\GraphPage;

class VenueConverter
{
    public function convert(GraphPage $node): array
    {
        return array_merge([
            'name' => $node->getName(),
            'slug' => $this->getSlug($node),
            'meta' => ['cover' => optional($node->getCover())->getSource()],
            'id_facebook' => $node->getId(),
        ], $this->getLocationFields($node->getLocation()));
    }

    private function getLocationFields(?GraphLocation $node): array
    {
        if (null === $node) {
            return [];
        }

        return [
            'city' => $node->getCity(),
            'country' => $node->getCountry(),
            'address_formatted' => $this->formatAddress($node),
            'lat' => $node->getLatitude(),
            'lng' => $node->getLongitude(),
        ];
    }

    private function getSlug(GraphPage $node)
    {
        return rtrim(
            str_slug($node->getName()).'-'.str_slug(optional($node->getLocation())->getCity()),
            '-'
        );
    }

    private function formatAddress(GraphLocation $node): string
    {
        $addr = [
            $node->getStreet(),
            trim($node->getZip()." ".$node->getCity(), ' '),
            $node->getState(),
            $node->getCountry()
        ];

        return implode(', ', array_filter($addr));
    }
}
