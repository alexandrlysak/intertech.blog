<?php

namespace Perevorot\Seo\Models;

use Model;
use October\Rain\Exception\ApplicationException;

/**
 * Model
 */
class External extends Model
{
    use \Perevorot\Seo\Traits\SeoEventsTrait;
    use \Perevorot\Seo\Traits\SeoPublicRoutesTrait;
    use \Perevorot\Page\Traits\CacheClear;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'perevorot_seo_external';
}
