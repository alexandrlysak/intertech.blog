<?php namespace Perevorot\Page\Controllers;

use Backend\Classes\Controller;
use Backend\Widgets\Form;
use BackendMenu;
use Flash;
use Input;
use DB;
use RainLab\Translate\Models\Locale;
use Perevorot\Page\Models\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Pages extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'page.structure_page'
    ];

    public $bodyClass;
    public $menu;

    public function __construct()
    {
        parent::__construct();

        $this->menu=Input::get('menu');

        if($this->menu)
            BackendMenu::setContext('Perevorot.Page', 'perevorot-page-main', 'perevorot-page-menu'.$this->menu);
        else
            BackendMenu::setContext('Perevorot.Page', 'perevorot-page-main');

        if($this->action!='reorder')
            $this->bodyClass='compact-container';
    }

    public function formExtendFields(Form $form)
    {
        $locales = Locale::get();
        $fields = [];
        $tableName = 'perevorot_page_page';

        foreach ($locales as $locale) {
            $fields['longread_' . $locale->code] = [
                'type' => 'longread',
                'cssClass' => 'field-slim',
                'stretch' => true,
                'tab' => $locale->name
            ];

            Schema::table($tableName, function(Blueprint $table) use ($locale, $tableName) {
                $column = 'longread_' . $locale->code;

                if (!Schema::hasColumn($tableName, $column)) {
                    $table->mediumtext($column)->nullable();
                }
            });
        }
        
        $form->addSecondaryTabFields($fields);
    }

    public function onResetTree()
    {
        if(empty(Input::get('menu'))){
            Flash::error('Укажите меню');
        }else{
            $pages=Page::where('menu_id', Input::get('menu'))->get();
            $counter=1;

            $pages->each(function($page) use(&$counter) {
                DB::table($page->table)->where('id', $page->id)->update([
                    'parent_id'=>null,
                    'nest_left'=>$counter,
                    'nest_right'=>$counter+1,
                    'nest_depth'=>0
                ]);
                
                $counter=$counter+2;
            });

            Flash::success('Вложенность очищена');
        }
    }
}