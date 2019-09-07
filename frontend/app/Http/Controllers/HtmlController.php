<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HtmlController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page(Request $request)
    {
        return $this->view('html/'.(!empty($request->slug) ? $request->slug : 'homepage'));
    }
}
