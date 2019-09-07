<?php namespace Perevorot\Settings;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'common' => [
                'label'       => 'Настройки сайта',
                'description' => 'контактная информация, общие настройки сайта',
                'category'    => 'Общие настройки',
                'icon'        => 'icon-info',
                'class'       => 'Perevorot\Settings\Models\Common',
                'order'       => 0,
                'permissions' => ['common.settings']
            ],
        ];
    }
}
