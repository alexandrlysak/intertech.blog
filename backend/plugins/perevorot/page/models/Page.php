<?php namespace Perevorot\Page\Models;

use Model;
use Input;
use Flash;
use ValidationException;

class Page extends TreeModel
{
    use \October\Rain\Database\Traits\Validation;

    use \Perevorot\Page\Traits\PageModelEvents;
    use \Perevorot\Page\Traits\PageModelOptions;
    use \Perevorot\Page\Traits\PageModelMutators;
    use \Perevorot\Page\Traits\CacheClear;
    use \Perevorot\Longread\Traits\LongreadMutators;
    use \Perevorot\Page\Traits\CustomValidationMessages;

    const PAGE_TYPE_STATIC=1;
    const PAGE_TYPE_ALIAS=2;
    const PAGE_TYPE_EXTERNAL=3;
    const PAGE_TYPE_ROUTE=4;

    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
        '@Perevorot.Longread.Behaviors.LongreadAttachFiles',
    ];

    public $table = 'perevorot_page_page';

    public $rules = [
        'title'=>'required',
        'type'=>'required',
        'menu'=>'required',
        'url'=>'sometimes|unique:perevorot_page_page|regex:/^[\/A-Za-z0-9\-_\:    ]+$/',
        'alias_page_id'=>'required_if:type,'.self::PAGE_TYPE_ALIAS,
        'url_external'=>'required_if:type,'.self::PAGE_TYPE_EXTERNAL.'|url',
        'route_name'=>'required_if:type,'.self::PAGE_TYPE_ROUTE,
    ];

    public $customMessages = [];

    public $translatable = [
        ['title', 'index' => true]
    ];

    public $timestamps = true;

    protected $guarded = ['*'];

    protected $fillable = [
        'title',
        'parent_id',
    ];

    public $belongsTo = [
        'menu' => [
            'Perevorot\Page\Models\Menu',
            'key'=>'menu_id'
        ],
        'alias_page' => [
            'Perevorot\Page\Models\Page',
            'key'=>'alias_page_id'
        ],
    ];

    public $hasMany = [
        'pages' => [
            'Perevorot\Page\Models\Page',
            'key'=>'parent_id'
        ]
    ];

    public function scopeEnabled($query, $menu_id)
    {
        $query->where('menu_id', '=', $menu_id);
        $query->where('is_hidden', '=', false);
        $query->where('is_disabled', '=', false);

        $query->orderBy('nest_left', 'ASC');
    }

    public function beforeDelete()
    {
        if($this->url=='/') {
            throw new ValidationException(['url' => 'Нельзя удалить главную страницу']);
            exit;
        }
    }

    public function filterFields($fields, $context = null)
    {
        if (!empty($fields->route_id)) {
            $fields->route_id->hidden = true;

            if ($this->route_name == 'pay-category') {
                $fields->route_id->hidden = false;
                $fields->route_id->label = 'Категория';
            }

            if ($this->route_name == 'pay-provider') {
                $fields->route_id->hidden = false;
                $fields->route_id->label = 'Провайдер';
            }
        }
    }

    public function setDefaultLeftAndRight()
    {
        $highRight = $this
            ->newQueryWithoutScopes()
            ->orderBy($this->getRightColumnName(), 'desc')
            ->where('menu_id', Input::get('menu'))
            ->limit(1)
            ->first()
        ;

        $maxRight = 0;
        if ($highRight !== null) {
            $maxRight = $highRight->getRight();
        }

        $this->setAttribute($this->getLeftColumnName(), $maxRight + 1);
        $this->setAttribute($this->getRightColumnName(), $maxRight + 2);
    }

    public function deleteDescendants()
    {
        if ($this->getRight() === null || $this->getLeft() === null)
            return;

        $this->getConnection()->transaction(function() {
            $this->reload();

            $leftCol = $this->getLeftColumnName();
            $rightCol = $this->getRightColumnName();
            $left = $this->getLeft();
            $right = $this->getRight();

            /*
             * Delete children
             */
            $this->newQuery()
                ->where($leftCol, '>', $left)
                ->where($rightCol, '<', $right)
                ->where('menu_id', Input::get('menu'))
                ->delete()
            ;

            /*
             * Update left and right indexes for the remaining nodes
             */
            $diff = $right - $left + 1;

            $this->newQuery()
                ->where($leftCol, '>', $right)
                ->where('menu_id', Input::get('menu'))
                ->decrement($leftCol, $diff)
            ;

            $this->newQuery()
                ->where($rightCol, '>', $right)
                ->where('menu_id', Input::get('menu'))
                ->decrement($rightCol, $diff)
            ;
        });
    }
}