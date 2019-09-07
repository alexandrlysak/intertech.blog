<?php namespace Perevorot\Page;

use Perevorot\Page\Console\ProjectUpCommand;
use Perevorot\Page\Console\ThumbsGenerate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Perevorot\Page\Models\Menu;
use System\Classes\PluginBase;
use Backend;
use Event;
use Artisan;

class Plugin extends PluginBase
{
    public function registerNavigation()
    {
        $menu=Menu::get();

        $sideMenu=[];

        $k = null;

        foreach($menu as $k=>$group)
        {
            $sideMenu['perevorot-page-menu'.$group->id]=[
                'label'=>$group->title,
                'url'=>Backend::url('perevorot/page/pages/?menu='.$group->id),
                'icon'=>'icon-files-o',
                'permissions'=>['page.structure_page'],
                'order'=>$k
            ];
        };

        $sideMenu['perevorot-page-menugroup']=[
            'label'=>'perevorot.page::lang.plugin.menu',
            'url'=>Backend::url('perevorot/page/menu'),
            'icon'=>'icon-sitemap',
            'permissions'=>['page.structure_page'],
            'order'=>$k+1
        ];

        return [
            'perevorot-page-main' => [
                'label'=>'perevorot.page::lang.plugin.name',
                'url'=>head($sideMenu)['url'],
                'icon'=>'icon-files-o',
                'permissions'=>['page.structure_page'],
                'order'=>10,
                'sideMenu'=>$sideMenu
            ],
        ];
    }

    public function boot()
    {
        Event::listen('eloquent.created: RainLab\Translate\Models\Locale', function ($model)
        {
            Schema::table('perevorot_page_page', function(Blueprint $table) use ($model)
            {
                foreach(['longread_'] as $prefix)
                {
                    $column = $prefix.$model->code;

                    if (!Schema::hasColumn('perevorot_page_page', $column))
                        $table->mediumText($column)->nullable();
                }
            });
        });

        Event::listen('eloquent.deleted: RainLab\Translate\Models\Locale', function ($model)
        {
            Schema::table('perevorot_page_page', function(Blueprint $table) use ($model)
            {
                foreach(['longread_'] as $prefix)
                {
                    $column = $prefix.$model->code;
    
                    if (Schema::hasColumn('perevorot_page_page', $column))
                        $table->dropColumn($column);
                }
            });
        });
        
        Event::listen('eloquent.saving: RainLab\Translate\Models\Message', function ($model) {
            Artisan::call('cache:clear');
        });

        Event::listen('eloquent.deleting: RainLab\Translate\Models\Message', function ($model) {
            Artisan::call('cache:clear');
        });
        
        Event::listen('longread.blocks.get', function($longread){
            $longread->registerBlocks($this);
        });
        
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->removeMainMenuItem('October.Cms', 'cms');
            $manager->removeSideMenuItem('October.Cms', 'cms', 'pages');
        });
    }

    public function register()
    {
        $this->registerConsoleCommand('project.up', ProjectUpCommand::class);
        $this->registerConsoleCommand('thumbs.generate', ThumbsGenerate::class);
    }
    
    /**
     * Registers back-end form widget items for this plugin.
     *
     * @return array
     */
    public function registerFormWidgets()
    {
        return [
            'Perevorot\Page\FormWidgets\FileUploadExtra' => [
                'label' => 'fileuploadextra',
                'code'  => 'fileuploadextra',
            ],
        ];
    }
}
