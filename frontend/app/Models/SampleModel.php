<?php

namespace App\Models;

use Perevorotcom\LaravelOctober\Classes\LaravelOctoberModel;

class SampleModel extends LaravelOctoberModel
{
    use \TranslatableTrait;
    use \LongreadTrait;
    use \ModelTrait;

    public $table = 'intertech_...';
    public $backendModel='Intertech\...';
    public $similar;

    protected $translatable=[
        ['name', 'primary'=>true],
        'solution'
    ];

    public $attachments=[
        'image',
        'images'
    ];

    protected $longread=[
        'longread'
    ];
}
