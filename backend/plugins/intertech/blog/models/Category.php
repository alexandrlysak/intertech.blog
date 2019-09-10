<?php namespace Intertech\Blog\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'intertech_blog_categories';

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

    /* Relations */

    public $hasMany = [
        'posts' => [
            'Intertech\Blog\Models\Post',
            'table' => 'intertech_blog_posts_categories',
            'order' => 'title'
        ]
    ];
}
