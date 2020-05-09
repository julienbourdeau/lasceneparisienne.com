<?php

namespace App;

    class ApiDefinition
    {
        public static function get()
        {
            return collect([
                self::getEvents(),
                self::getEvent(),
                self::getVenues(),
                self::getVenue(),
            ])->mapWithKeys(function ($item) {
            $item['verb'] = strtoupper($item['verb'] ?? 'GET');
            $item['response'] = markdown(
                "```json\n".json_encode($item['response'], JSON_PRETTY_PRINT)."\n```"
            );

            return [$item['id'] => $item];
        });
        }

        private static function getEvents()
        {
            return [
                'id' => str_after(__METHOD__, '::'),
                'endpoint' => '/api/events',
                'response' => Event::paginate(2),
            ];
        }

        private static function getEvent()
        {
            return [
                'id' => str_after(__METHOD__, '::'),
                'endpoint' => '/api/event/{uuid}',
                'response' => Event::latest('id')->limit(1)->first(),
            ];
        }

        private static function getVenues()
        {
            return [
                'id' => str_after(__METHOD__, '::'),
                'endpoint' => '/api/venues',
                'response' => Venue::paginate(2),
            ];
        }

        private static function getVenue()
        {
            return [
                'id' => str_after(__METHOD__, '::'),
                'endpoint' => '/api/venue/{uuid}',
                'response' => Venue::first(),
            ];
        }
    }
