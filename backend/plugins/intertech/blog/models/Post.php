<?php namespace Intertech\Blog\Models;

use Model;

/**
 * Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'intertech_blog_posts';

    /* Relations */

    public $belongsTo = [
        'category' => [
            'Intertech\Blog\Models\Category',
            'table' => 'intertech_blog_posts_categories',
            'order' => 'title'
        ]
    ];

    public $belongsToMany = [
        'tags' => [
            'Intertech\Blog\Models\Tag',
            'table' => 'intertech_blog_posts_tags',
            'order' => 'title'
        ]
    ];


  
}
