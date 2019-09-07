<?php

namespace Perevorot\Settings\Models;

use Model;

/**
 * Model
 */
class Common extends Model
{
    use \Perevorot\Page\Traits\CacheClear;

    public $implement = [
        'System.Behaviors.SettingsModel',
        'RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $translatable = [
        'address',
        'working_hours',
    ];

    public $settingsCode = 'common';

    public $settingsFields = 'fields.yaml';

    // public $attachOne = [
    //     'logo' => 'System\Models\File'
    // ];
}
