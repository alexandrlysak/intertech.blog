<?php

Route::get('/', function(){
    return \Response::make('Page not found', 404);
});