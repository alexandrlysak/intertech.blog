<?php namespace Perevorot\Page\Traits;

use ApplicationException;
use Flash;
use DB;
use Redirect;

trait PageModelEvents
{
    public function beforeCreate()
    {
        $pages=DB::table($this->table)->select('id')->get();
        $autoincrement=0;

        foreach($pages as $page) {
            $autoincrement=max($autoincrement, (int) substr($page->id, 2));
        }

        $this->id=(int) $this->menu_id.'00'.($autoincrement+1);
    }

    public function beforeValidate()
    {
        if($this->type==self::PAGE_TYPE_ALIAS)
            $this->url='';
            
         if($this->type==self::PAGE_TYPE_ROUTE)
            $this->url='';
    }

    public function beforeSave()
    {        
        switch($this->type)
        {
            case self::PAGE_TYPE_STATIC:
                $this->url_external='';
                $this->alias_page_id=0;
                $this->route_type=null;
                $this->route_name=null;
                $this->route_id=0;

            break;

            case self::PAGE_TYPE_ALIAS:
                $this->url_external=null;
                $this->route_type=null;
                $this->route_name=null;
                $this->route_id=0;
                $this->url='';

            break;

            case self::PAGE_TYPE_EXTERNAL:
                $this->url='';
                $this->route_type=null;
                $this->route_name=null;
                $this->route_id=0;
                $this->alias_page_id=0;

            break;

            case self::PAGE_TYPE_ROUTE:
                $this->alias_page_id=0;
                $this->url='';

                if(!$this->route_id) {
                    $this->route_type=null;
                }else{
                    $this->route_type=$this->route_name;
                }

            break;
        }
    }
}
