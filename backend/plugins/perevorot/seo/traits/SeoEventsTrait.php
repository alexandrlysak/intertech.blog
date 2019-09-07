<?php

namespace Perevorot\Seo\Traits;

trait SeoEventsTrait
{
    public function beforeSave()
    {
        switch((int) $this->seo_url_type)
        {
            case 0:
                $this->url_mask='';

                break;

            case 1:
                $this->route='';
                $this->url_mask=!empty($this->url_mask) ? '/'.trim(trim($this->url_mask, '/')) : '';

                break;
        }
    }
}
