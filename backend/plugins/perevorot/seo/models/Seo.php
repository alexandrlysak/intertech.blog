<?php

namespace Perevorot\Seo\Models;

use Model;
use October\Rain\Exception\ApplicationException;

/**
 * Model
 */
class Seo extends Model
{
    use \Perevorot\Page\Traits\CacheClear;
    use \Perevorot\Seo\Traits\SeoTrait;
    use \Perevorot\Seo\Traits\SeoEventsTrait;
    use \Perevorot\Seo\Traits\SeoPublicRoutesTrait;
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var bool
     */
    public $timestamps = false;

    public $translatable = [
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'perevorot_seo_seo';

    public $attachOne = [
        'og_image' => 'System\Models\File'
    ];
}
