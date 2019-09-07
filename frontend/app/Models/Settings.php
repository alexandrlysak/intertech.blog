<?php

namespace App\Models;

use Perevorotcom\LaravelOctober\Models\SystemSetting;

class Settings extends SystemSetting
{
    public $instance='common';

    public $backendModel='Perevorot\Settings\Models\Common';

    public $translatable=[
        'address',
        'working_hours',
    ];

    // public $attachments=[
    //     'logo'
    // ];
}
