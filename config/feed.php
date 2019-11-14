<?php

return [
    'feeds' => [
        'recently_added' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Event::getAllFeedEvents',

            /*
             * The feed will be available on this url.
             */
            'url' => '',

            'title' => 'Concerts Metal à Paris - La Scene Parisienne',
            'description' => 'Tous les concerts Meta, Punk & Hardcore à Paris. Par ordre d\'ajout sur le site, seulement les concerts à venir.',
            'language' => 'en-US',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::atom',

            /*
             * The type to be used in the <link> tag
             */
            'type' => 'application/atom+xml',
        ],
    ],
];
