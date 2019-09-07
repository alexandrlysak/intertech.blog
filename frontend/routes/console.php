<?php

Artisan::command('laraveloctober:routes', function () {
    $routes = \Route::getRoutes();
    $array=[];
    foreach ($routes as $route) {
        if (!empty($route->action['middleware']) && in_array('GET', $route->methods) && !empty($route->action['middleware']) && is_array($route->action['middleware']) && in_array('web', $route->action['middleware']) && !empty($route->action['as'])) {
            array_push($array, [
                'name'=>$route->action['as'],
                'uri'=>$route->uri,
            ]);
        }
    }
    $json=response()->json($array)->content();
    Storage::disk('local')->put('routes.json', $json);
    $this->info("Список доступных роутов обновлен: `storage/app/routes.json`");
})->describe('Экспорт списка доступных роутов для системы управления');