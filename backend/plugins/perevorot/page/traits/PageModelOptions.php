<?php namespace Perevorot\Page\Traits;

use Perevorot\Page\Models\Page;
use Lang;
use ReflectionClass;

trait PageModelOptions
{
    public function getTypeOptions()
    {
        $dropdown=[];

        $class = new ReflectionClass(__CLASS__);

        $constants=array_where($class->getConstants(), function($value, $key){
            return starts_with($key, 'PAGE_TYPE_');
        });

        foreach($constants as $constant=>$id)
        {
            switch($id)
            {
                case self::PAGE_TYPE_STATIC:
                    $icon='oc-icon-file-text-o';
                    break;

                case self::PAGE_TYPE_ALIAS:
                    $icon='oc-icon-link';
                    break;

                case self::PAGE_TYPE_EXTERNAL:
                    $icon='oc-icon-external-link';
                    break;

                case self::PAGE_TYPE_ROUTE:
                    $icon='oc-icon-magic';
                    break;
            }

            $dropdown[constant('self::'.$constant)]=sprintf('<i class="%s"></i>%s', $icon, Lang::get('perevorot.page::lang.form.page.types.'.strtolower(substr($constant, 10))));
        }

        return $dropdown;
    }

    public function getAliasPageIdOptions()
    {
        $dropdown=[
            '' => Lang::get('perevorot.page::lang.form.page.select_cms_page_option')
        ];

        $pages=Page::get();

        $pages=$pages->filter(function($page){
            return !$this->id || $this->id!=$page->id;
        });

        foreach($pages as $page)
            $dropdown[$page->id]=sprintf('<i class="%s" style="margin-left:%spx"></i>%s, %s, %s', $page->typeIcon, $page->nest_depth*20, $page->title, $page->pageUrl, $page->menu->title);

        return $dropdown;
    }

    public function getRouteNameOptions()
    {
        $array=[''=>'Выберите страницу'];

        if (file_exists('storage/cms/routes.json')) {
            $json=json_decode(file_get_contents('storage/cms/routes.json'));

            foreach ($json as $item) {
                if(!in_array($item->name, ['page', 'homepage'])) {
                    $array[$item->name]=$item->name.', /'.trim($item->uri, '/');
                }
            }
        }

        return $array;
    }
    /*
    public function getRouteIdOptions()
    {
        if ($this->route_name == 'pay-category') {
            return $this->getServicesCategoriesOptions();
        }
        elseif ($this->route_name == 'pay-provider') {
             return $this->getServicesProvidersOptions();
        }
        return [];
    }

    public function getServicesProvidersOptions()
    {
        $providers=\ibox\Services\Models\Provider::get();
        $out=[];

        foreach($providers as $provider) {
            $out[$provider->PROVIDER_ID]=$provider->getLocalizedJsonDefault('PROVIDER_NAME').' #'.$provider->PROVIDER_ID;
        }

        $out=array_filter($out);
        asort($out);

        return $out;
    }

    public function getServicesCategoriesOptions()
    {
        $categories=\ibox\Services\Models\Category::orderBy('SORT_ORDER')->get();
        $out=[];

        foreach($categories as $category) {
            $out[$category->CATEGORY_ID]=$category->getLocalizedJsonDefault('CATEGORY_NAME').' #'.$category->CATEGORY_ID;
        }

        return $out;
    }
    */
}
