<?php namespace Perevorot\Page\Traits;

use Artisan;

trait CacheClear
{
    public function afterSave()
    {
        Artisan::call('cache:clear');
    }

    public function afterDelete()
    {
        Artisan::call('cache:clear');
    }
}
