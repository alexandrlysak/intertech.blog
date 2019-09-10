<?php namespace Intertech\Blog\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'intertech_blog_tags';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = [
        'title'
    ];


    // Set translatable fields
    public $translatable = [['title']];

    public static function boot()
    {
        parent::boot();
        if (!class_exists('RainLab\Translate\Behaviors\TranslatableModel'))
            return;

        self::extend(function($model)
        {
            $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';
        });
    }
}
