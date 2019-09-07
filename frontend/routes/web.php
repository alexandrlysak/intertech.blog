<?php

$routeGroup=[
    'prefix' => Localization::setLocale(),
    'middleware' => [
        //'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
        'redirectTrailingSlash',
        'caching'
    ]
];

Route::group($routeGroup, function () {
    if(env('APP_ENV')!=='production') {
        Route::get('/html/{slug?}', 'HtmlController@page');
    }

    Route::get('{slug}', 'PageController@page')->name('page');
	Route::get('/', 'PageController@homepage')->name('homepage');
});