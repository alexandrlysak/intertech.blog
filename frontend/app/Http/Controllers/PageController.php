<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Vacancy;

class PageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function homepage()
    {
        // SEO::setData([
        //     'item' => $item
        // ]);

        return $this->view('pages/homepage');
    }

    public function page()
    {
        return $this->view('pages/page');
    }
}
