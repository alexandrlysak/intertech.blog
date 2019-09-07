<?php

namespace Perevorot\Seo\Models;

use October\Rain\Database\Model;
use Perevorot\Seo\Traits\SeoTrait;

class Settings extends Model
{
    use SeoTrait;
    use \Perevorot\Page\Traits\CacheClear;

    /**
     * @var array
     */
    public $implement = [
        'System.Behaviors.SettingsModel',
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    /**
     * @var array
     */
    public $translatable = [
        'title',
        'description',
        'keywords',
        'additional_tags',
        'og_title',
        'og_sitename',
        'og_description',
    ];

    /**
     * @var string
     */
    public $settingsCode = 'perevorot_seo_settings';

    /**
     * @var string
     */
    public $settingsFields = 'fields.yaml';

    /**
     * @var array
     */
    public $attachOne = [
        'og_image' => [
            'System\Models\File',
        ]
    ];
}
