<?php namespace Perevorot\Page\Traits;

use Cms\Classes\Page as CmsPage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Perevorot\Page\Classes\PageHelpers;
use Perevorot\Page\Models\Page;
use RainLab\Translate\Classes\Translator;
use Session;

trait PageModelMutators
{
    public function getTypeIconAttribute()
    {
        $icon='';

        switch($this->type)
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

        return $icon;
    }

    public function getPageUrlAttribute()
    {
        $href='';

        switch($this->type)
        {
            case $this::PAGE_TYPE_STATIC:
                $href=$this->url;

                break;

            case $this::PAGE_TYPE_ALIAS:
                $href=!empty($this->alias_page->pageUrl) ? $this->alias_page->pageUrl : '';

                break;

            case $this::PAGE_TYPE_EXTERNAL:
                $href=$this->url_external;

                break;

            case $this::PAGE_TYPE_ROUTE:
                $href=$this->route_name;

                break;
        }

        return $href;
    }
}
