<?php namespace Perevorot\Seo\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class Tags extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'seo.permission.*'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Perevorot.Seo', 'seo', 'tags');
    }

    public function index()
    {
        if (!$this->user->hasAccess(['seo.permission.list'])) {
            return Response::make(View::make('backend::access_denied'), 403);
        }

        $this->asExtension('ListController')->index();
    }

    public function update($recordId, $context = null)
    {
        if (!$this->user->hasAccess(['seo.permission.edit'])) {
            return Response::make(View::make('backend::access_denied'), 403);
        }

        return $this->asExtension('FormController')->update($recordId, $context);
    }

    public function preview($recordId, $context = null)
    {
        if (!$this->user->hasAccess(['seo.permission.list'])) {
            return Response::make(View::make('backend::access_denied'), 403);
        }

        return $this->asExtension('FormController')->preview($recordId, $context);
    }

    public function create()
    {
        if (!$this->user->hasAccess(['seo.permission.create'])) {
            return Response::make(View::make('backend::access_denied'), 403);
        }

        return $this->asExtension('FormController')->create();
    }
}