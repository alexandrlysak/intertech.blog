<?php namespace Perevorot\Seo\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Redirects Back-end Controller
 */
class Redirect extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    
    public $requiredPermissions = [
        'seo.permission.redirect'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Perevorot.Seo', 'seo', 'redirect');
    }
}