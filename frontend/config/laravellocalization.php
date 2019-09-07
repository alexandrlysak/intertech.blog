<?php

return [
    'supportedLocales' => [
        // 'en' => [
        //     'name' => 'English',
        //     'script' => 'Latn',
        //     'native' => 'ENG',
        //     'regional' => 'en_GB'
        // ],
        'ua' => [
            'name' => 'Ukrainian',
            'script' => 'Cyrl',
            'native' => 'УКР',
            'regional' => 'uk_UA.utf8'
        ],
    ],
    'useAcceptLanguageHeader' => false,
    'hideDefaultLocaleInURL' => true,
    'localesOrder' => ['ua', 'en'],
];
