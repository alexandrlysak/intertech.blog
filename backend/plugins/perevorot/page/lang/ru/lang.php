<?php return [
    'plugin'=>[
        'name'=>'Структура сайта',
        'menu'=>'Группы меню',
        'reorder'=>'Изменить вложенность',
        'reset_tree'=>'Сбросить вложенность',
        'back_from_reorder'=>'Вернуться к списку',
        'description'=>'',
        'preview_page' => 'Превью раздела',
    ],
    'list'=>[
        'page'=>[
            'create'=>'Добавить страницу',
            'title'=>'Заголовок',
            'url'=>'Гиперссылка',
            'content'=>'Текст',
            'is_target_blank'=>'В новом окне',
            'is_hidden'=>'Скрыто в меню',
            'meta_title'=>'SEO заголовок',
            'meta_description'=>'SEO описание',
            'layout'=>'Шаблон',
        ],
        'menu'=>[
            'create'=>'Добавить меню'
        ]
    ],
    'form'=>[
        'page'=>[
            'name'=>'Страницы',
            'title'=>'Заголовок',
            'url'=>'Гиперссылка',
            'type'=>'Тип страницы',
            'css_class'=>'CSS класс на элементе меню',
            'types'=>[
                'static'=>'Текстовая страница',
                'cms'=>'Системная страница',
                'alias'=>'Повтор страницы',
                'external'=>'Внешняя ссылка',
                'route'=>'Системная страница',
            ],
            'select_cms_page_option'=>'Выберите страницу',
            'select_cms_partial_option'=>'Выберите partial',
            'cms_page_id'=>'Страница',
            'seo_tab'=>'SEO',
            'settings_tab'=>'Настройки',
            'more_tab'=>'Дополнительно',
            'preview_tab' => 'Превью раздела',
            'preview_image' => 'Картинка превью',
            'meta_title'=>'Заголовок, title',
            'meta_description'=>'Описание, description',
            'layout'=>'Шаблон',
            'is_closed_by_direct_open' => 'Закрыть страницу от прямого перехода',
            'is_closed_by_direct_open_comment' => 'Запретить открытие страницы по прямому переходу по гиперссылке, только после редиректа со страницы сайта',
            'is_cache_ignore' => 'Игнорировать кеширование страницы',
            'is_cache_ignore_comment' => 'Принудительно игнорировать кеширование этой страницы',
            'is_hidden'=>'Скрыто в меню',
            'is_hidden_comment'=>'Если страница скрыта в меню, то она будет доступна по прямому переходу',
            'is_disabled'=>'Скрыто на сайте',
            'is_disabled_comment'=>'Если страница скрыта на сайте, по обращению по ссылке будет 404 ошибка',
            'is_target_blank'=>'Открывать из меню в новом окне',
            'content'=>'Текст страницы',
            'alias_page_id'=>'Страница',
            'route_type'=>'Переход на страницу',
            'url_external'=>'Гиперссылка',
            'placeholder_title'=>'Введите заголовок',
            'placeholder_url'=>'Введите гиперссылку',
            'default_tab'=>'Настройки',
            'content_tab'=>'Текст страницы',
        ],
        'menu'=>[
            'name'=>'Меню',
            'title'=>'Название',
            'alias'=>'Метка',
        ]
    ],
    'permission'=>[
        'tab'=>'Структура сайта',
    ],
    'permissions'=>[
        'page'=>'Изменение структуры сайта',
    ],
    'validation'=>[
        'title_required'=>'Пожалуйста, введите заголовок',
        'type_required'=>'Пожалуйста, выберите тип',
        'menu_required'=>'Пожалуйста, укажите группу меню',
        'url_required_if'=>'Введите гиперссылку',
        'url_regex'=>'Гиперссылка должна содержать только знаки латинского алфавита, цифры или символы «-», «_», «/»',
        'url_unique'=>'Такая гиперссылка уже существует. Введите уникальное значение',
        'content_required_if'=>'Добавьте содержимое страницы',
        'alias_page_id_required_if'=>'Выберите страницу которую нужно повторить',
        'cms_page_id_required_if'=>'Выберите системную страницу',
        'url_external_required_if'=>'Укажите внешнюю гиперссылку',
        'url_external_url'=>'Внешняя гиперссылка должна быть в правильном формате, например: http://www.google.com',
        'alias_required'=>'Укажите метку',
        'alias_regex'=>'Метка должна содержать только знаки латинского алфавита, цифры или символы «-», «_»',
        'alias_min'=>'Метка должна быть больше 3х символов',
    ],
];
