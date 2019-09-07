<?php namespace Perevorot\Longread\Controllers;

use Backend\Classes\Controller;
use Perevorot\Longread\Models\LongreadPreview;
use View;

class Preview extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function longread($user_id, $model_id, $model, $column)
    {
        echo View::make('perevorot.longread::longread', [
            'url'=>env('APP_FRONTEND_URL').'/backend/preview/longread/'.$user_id.'/'.$model_id.'/'.$model.'/'.$column,
            'frontend_url'=>env('APP_FRONTEND_URL')
        ]);

        exit;
    }
}
