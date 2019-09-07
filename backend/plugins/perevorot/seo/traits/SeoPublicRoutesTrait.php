<?php

namespace Perevorot\Seo\Traits;

trait SeoPublicRoutesTrait
{
    public function getRouteOptions()
    {
        $array=[''=>'Все роуты'];

        if (file_exists('storage/cms/routes.json')) {
            $json=json_decode(file_get_contents('storage/cms/routes.json'));

            foreach ($json as $item) {
                $array[$item->name]=$item->name.', /'.trim($item->uri, '/');
            }
        }

        return $array;
    }
}
