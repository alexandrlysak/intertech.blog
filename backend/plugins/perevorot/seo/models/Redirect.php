<?php namespace Perevorot\Seo\Models;

use Model;
use Config;
use October\Rain\Database\Traits\Validation;

/**
 * Redirect Model
 */
class Redirect extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'perevorot_seo_redirects';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array
     */
    public $rules = [
        'old_url'=>'required',
        'new_url'=>'required',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'old_url',
        'new_url',
        'counter',
        'is_enabled',
    ];
}
