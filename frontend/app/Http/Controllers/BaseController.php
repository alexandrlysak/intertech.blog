<?php

namespace App\Http\Controllers;

use Perevorotcom\LaravelOctober\Http\Controllers\Controller;
use Perevorotcom\LaravelOctober\Models\Menu;
use Perevorotcom\LaravelOctober\Models\Page;
use Localization;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $default=Localization::getCurrentLocale();
        $locales=Localization::getLocalesOrder();

        unset($locales[$default]);

        // $this->page->attachments=[
        //     'background'
        // ];

        $this->setCommonData([
            'menu' => Menu::label('menu-main', [
                'depth' => 1
            ]),
            'locales' => (object) [
                'list' => $locales,
                'default' => $default
            ]
        ]);
    }
}
