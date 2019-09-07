<?php namespace Perevorot\Page\Models;

use Model;
use DB;

class Menu extends Model
{
    use \Perevorot\Page\Traits\CustomValidationMessages;
    use \October\Rain\Database\Traits\Validation;

    public $table = 'perevorot_page_menu';

    public $customMessages = [];

    public $timestamps = true;

    protected $guarded = ['*'];

    public $rules = [
        'title'=>'required',
        'alias'=>'required|unique:perevorot_page_menu|regex:/^[A-Za-z0-9\-_]+$/|min:3',
    ];

    protected $fillable = [
        'title',
    ];

    public $hasMany = [
        'pages' => [
            'Perevorot\Page\Models\Page',
            'scope'=>'visible'
        ]
    ];

    public function beforeDelete()
    {
        $page=new Page();

        DB::select('DELETE FROM '.$page->table.' WHERE menu_id = ?', [
            $this->id
        ]);
    }
}
