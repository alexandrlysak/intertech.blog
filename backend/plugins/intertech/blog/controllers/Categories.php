<?php namespace Intertech\Blog\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Categories extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relations.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Intertech.Blog', 'blog-menu-item', 'categories-menu-item');
    }

    public function beforeCreate() { $this->setDefaultLeftAndRight(); }
}
