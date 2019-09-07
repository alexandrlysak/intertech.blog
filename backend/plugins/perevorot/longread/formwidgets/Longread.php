<?php namespace Perevorot\Longread\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Perevorot\Page\Models\Page;
use Perevorot\Longread\Models\LongreadPreview;
use RainLab\Translate\Models\Locale;
use ApplicationException;
use System\Models\File;
use SystemException;
use BackendAuth;
use Event;
use DB;

class Longread extends FormWidgetBase
{
    use \Perevorot\Longread\Traits\LongreadBlocks;

    const INDEX_PREFIX = '___index_';
    const ALIAS_PREFIX = '___alias_';

    public $form;

    protected $defaultAlias = 'longread';
    protected $indexCount = 0;
    protected $formWidgets = [];
    protected $availableLanguages = [];
    protected static $onAddItemCalled = false;
    protected $blocks = [];
    protected $user_id;

    public function init()
    {
        $this->user_id=BackendAuth::getUser()->id;

        Event::fire('longread.blocks.get', [$this], true);

        uasort($this->longreadBlocks, function($a, $b) {
            $a=!empty($a['order']) ? $a['order'] : 0;
            $b=!empty($b['order']) ? $b['order'] : 0;

            return $a-$b;
        });

        if(empty($this->longreadBlocks)) {
            throw new SystemException(sprintf('Longread blocks are not defined', $block));
        }

        $this->fillFromConfig([
            'blocks',
        ]);

        if(empty($this->blocks)) {
            $this->blocks=array_keys($this->longreadBlocks);
        }

        $blocks=[];

        foreach($this->blocks as $block)
        {
            if (!empty($this->longreadBlocks[$block])) {
                $blocks[$block]=$this->longreadBlocks[$block];
            }
        }

        $this->longreadBlocks=$blocks;

        if (!self::$onAddItemCalled) {
            $this->processExistingItems();
        }

        $this->availableLanguages = $this->getAvailableLanguages();
    }

    public function getAvailableLanguages()
    {
        return Locale::get();
    }

    public function render()
    {
        $this->prepareVars();
        //$this->clearPreview();

        return $this->makePartial('longread');
    }

    public function prepareVars()
    {
        if(!empty($this->config->config['blocks'])) {
            $this->longreadBlocks=$this->clearBlockArray($this->longreadBlocks, $this->config->config['blocks']);
        
            foreach($this->longreadBlocksGroups as $groupAlias=>$group) {
                $this->longreadBlocksGroups[$groupAlias]['blocks']=$this->clearBlockArray($group['blocks'], $this->config->config['blocks']);
                
                if(empty($this->longreadBlocksGroups[$groupAlias]['blocks'])) {
                    unset($this->longreadBlocksGroups[$groupAlias]);
                }
            }
        }

        if(!empty($this->config->config['blockGroups'])) {
            foreach($this->longreadBlocksGroups as $groupAlias=>$group) {
                if(!in_array($groupAlias, $this->config->config['blockGroups'])){
                    unset($this->longreadBlocksGroups[$groupAlias]);
                }
            }
        }
        
        $this->vars['indexName'] = self::INDEX_PREFIX.$this->formField->getName(false).'[]';
        $this->vars['aliasName'] = self::ALIAS_PREFIX.$this->formField->getName(false).'[]';
        $this->vars['fieldName'] = $this->formField->getName(false);
        $this->vars['aliasPrefix'] = self::ALIAS_PREFIX;
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['blocks'] = $this->longreadBlocks;
        $this->vars['blocksGroups'] = $this->longreadBlocksGroups;
        $this->vars['availableLanguages'] = $this->availableLanguages;
        $this->vars['currentLang'] = substr($this->formField->getName(false), -2);
    }

    protected function loadAssets()
    {
        $this->addCss('css/longread.css', 'core');

        $this->addJs('js/longread.js', 'core');
        $this->addJs('js/jquery.sticky.js', 'core');
    }

    public function clearPreview()
    {
        LongreadPreview::where('user_id', $this->user_id)->where('model', strtolower(last(explode('\\', get_class($this->model)))))->where('model_id', !empty($this->model->id) ? $this->model->id : 0)->delete();
    }

    public function getSaveValue($value)
    {
        $savedValues=(array) $value;

        $aliases=post(self::ALIAS_PREFIX.$this->formField->getName(false));
        $blocks=post(self::INDEX_PREFIX.$this->formField->getName(false));

        if(!$aliases) {
            return '';
        }

        $parsedValues=[];

        foreach($aliases as $index=>$alias)
        {
            $value=[];
            $files=[];

            $blockIndex=$blocks[$index];
            $savedValue=!empty($savedValues[$blockIndex]) ? $savedValues[$blockIndex] : [];

            foreach($this->longreadBlocks[$alias]['fields'] as $fieldAlias=>$field)
            {
                $value[$fieldAlias]=!empty($savedValue[$fieldAlias]) ? $savedValue[$fieldAlias] : '';

                if(!empty($field['valueFrom']))
                {
                    $valueFrom=explode('_', $field['valueFrom']);
                    array_pop($valueFrom);
                    $valueFrom[]=$blockIndex;

                    $files[$fieldAlias]=implode('_', $valueFrom);
                }
            }

            array_push($parsedValues, (object) [
                'alias'=>$alias,
                'value'=>$value,
                'index'=>$blockIndex,
                'files'=>$files
            ]);
        }

        //$this->clearPreview();

        return !empty($parsedValues) ? json_encode($parsedValues, JSON_UNESCAPED_UNICODE) : '';
    }

    protected function processExistingItems()
    {
        if(!empty(post('file_id')) && (request()->has('title') || request()->has('description'))) {
            if($file = File::where('id', post('file_id'))->first()) {
                if(empty($file->field)) {
                    $file->title=post('title');
                    $file->description=post('description');

                    $file->save();

                    echo json_encode((object)['displayName' => $file->title ?: $file->file_name]);
                    exit;
                }
            }
        }

        $values=$this->getLoadValue() ? : "[]";
        $values=json_decode($values, true);

        $itemIndexes=post(self::INDEX_PREFIX.$this->formField->getName(false), array_pluck($values, 'index'));
        $itemAliases=post(self::ALIAS_PREFIX.$this->formField->getName(false), array_pluck($values, 'alias'));

        if (!is_array($itemIndexes))
            return;

        foreach($itemIndexes as $index=>$itemIndex)
        {
            $value=array_first($values, function($value, $key) use($itemIndex){
                return $value['index']===$itemIndex;
            });

            $value=$value && array_key_exists('value', $value) ? $value['value'] : [];

            $this->makeItemFormWidget($itemIndex, $itemAliases[$index], $value);
            $this->indexCount=max((int) $itemIndex, $this->indexCount);
        }
    }

    public function onSaveAttachmentConfig()
    {
        try {
            $fileModel = $this->getRelationModel();
            if (($fileId = post('file_id')) && ($file = $fileModel::find($fileId))) {
                $file->title = post('title');
                $file->description = post('description');
                $file->save();

                return ['displayName' => $file->title ?: $file->file_name];
            }

            throw new ApplicationException('Unable to find file, it may no longer exist');
        }
        catch (Exception $ex) {
            return json_encode(['error' => $ex->getMessage()]);
        }
    }

    protected function makeItemFormWidget($index = 0, $alias, $value=[])
    {
        if (empty($this->longreadBlocks[$alias])) {
            return '';
        }

        if (empty($this->longreadBlocks[$alias]['fields'])) {
            return '';
        }

        $this->parseFileUploadData($index);

        $config = $this->makeConfig($this->longreadBlocks[$alias]);

        $config->model=$this->model;
        $config->data=$value;
        $config->alias=$this->alias.'Form'.$index;
        $config->arrayName=$this->formField->getName().'['.$index.']';
        $config->aliasValue=$alias;

        $widget=$this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();
        $widget->vars['aliasValue']=$alias;

        return $this->formWidgets[$index]=$widget;
    }

    public function parseFileUploadData($index)
    {
        foreach($this->longreadBlocks as $alias=>$block)
        {
            foreach($block['fields'] as $field=>$fields)
            {
                if(!empty($fields['type']) && starts_with($fields['type'], 'fileupload'))
                {
                    $this->longreadBlocks[$alias]['fields'][$field]['valueFrom'] = $this->getFileFieldName($field, $alias, $index);
                }
            }
        }
    }

    private function getFileFieldName($field, $alias, $index)
    {
        return sprintf(
            '__longread_%s_%s_%s_%s_%s',
            (ends_with($field, 's')?'many':'one'),
            $this->fieldName,
            $alias,
            $field,
            !self::$onAddItemCalled ? $index : ''
        );
    }

    public function onAddItem()
    {
        $alias=post(self::ALIAS_PREFIX);

        if(empty($alias)) {
            throw new SystemException('Please select block to add');
        }

        self::$onAddItemCalled = true;
        
        $isCreate=strpos(request()->path(), '/create')!==false;
        
        if($isCreate) {
            $this->indexCount=sizeof(post(self::ALIAS_PREFIX.$this->formField->getName(false)))+1;
        }else{
            $this->indexCount++;
        }

        $this->prepareVars();

        $this->vars['widget'] = $this->makeItemFormWidget($this->indexCount, $alias);
        $this->vars['indexValue'] = $this->indexCount;
        $this->vars['aliasValue'] = $alias;

        $itemContainer = '@#'.$this->getId('items');

        return [
            $itemContainer => $this->makePartial('longread_item')
        ];
    }
    
    public function onLivePreview()
    {
        $value = post($this->getFieldName());
        $longread_preview=$this->getSaveValue($value);

        $this->updatePreviewColumn($longread_preview);
    }

    public function onCopyLongread()
    {
        $fromFieldName = 'longread_' . post('fromFieldName');
        $model = $this->model;

        $fromLongreadContent = json_decode($model->{$fromFieldName}, 1);
        $toLongreadContent = (array) json_decode($model->{$this->fieldName}, 1);

        $offset=1;

        foreach($toLongreadContent as $longread){
            $offset=max((int) $longread['index'], $offset);
        }
        
        $offset++;

        if (empty($fromLongreadContent)) {
            throw new ApplicationException(sprintf('Лонгрид `%s` не содержит блоков', $fromFieldName));
        }

        array_walk($fromLongreadContent, function (&$value, $key) use ($offset) {
            $value['index'] = $offset + $key;
            $value['widget'] = $this->makeItemFormWidget($offset + $key, $value['alias'], (object) $value['value']);
        });

        $this->copyImages($fromLongreadContent);

        array_walk($fromLongreadContent, function (&$value, $key) {
            $files = [];
            $arrayOfFiles = (array) $value['files'];

            foreach ($arrayOfFiles as $key => $file) {
                $files[$key] = $this->getFileFieldName($key, $value['alias'], $value['index']);
            }

            $value['files'] = $files;
        });

        $this->prepareVars();
        $this->vars['blocks'] = $fromLongreadContent;

        $itemContainer = '@#'.$this->getId('items');

        return [$itemContainer => $this->makePartial('longread_items')];
    }

    private function copyImages($toLongreadContent)
    {
        foreach ($toLongreadContent as $block) {
            if (!isset($block['files'])) {
                continue;
            }

            $files = $block['files'];
            $id = @$block['widget']->model->id;
            
            if($id) {
                foreach ($files as $key => $file) {
                    $fromFile = File::where('field', $file)->where('attachment_id', $id)->get();
                    
                    foreach($fromFile as $ffile) {
                        $newFile = $ffile->replicate();
                        $newFile->field = $this->getFileFieldName($key, $block['alias'], $block['index']);
                        $newFile->disk_name = null;
                        $newFile->fromFile($ffile->getLocalPath());

                        $newFile->save();
                        
                        $newFile->sort_order=$newFile->id;
                        $newFile->file_name = $ffile->file_name;
                        $newFile->save();
                    }
                }
            }
        }
    }

    public function onRemoveItem()
    {
        $this->removeFiles();
    }

    private function removeFiles()
    {
        $blocks = (array) json_decode($this->model->{$this->fieldName});

        $block = array_first($blocks, function ($value, $key) {
            return $value->index == post('index');
        });

        if (!isset($block->files)) {
            return;
        }

        $files = (array) $block->files;
        $attachment_id = @$this->model->id;

        foreach ($files as $item) {
            if($attachment_id) {
                $file = File::where('field', $item)->where('attachment_id', $attachment_id)->delete();
            }
        }
    }

    private function updatePreviewColumn($value)
    {
        if(!empty($value))
        {
            $preview=new LongreadPreview();

            $preview->user_id=$this->user_id;
            $preview->model=strtolower(last(explode('\\', get_class($this->model))));
            $preview->field=$this->fieldName;
            $preview->model_id=!empty($this->model->id) ? $this->model->id : 0;
            $preview->longread=$value;

            $preview->save();
        }
    }

    public function getPreviewUrl()
    {
        return '/backend/perevorot/longread/preview/longread/'.$this->user_id.'/'.(!empty($this->model->id) ? $this->model->id : 0).'/'.strtolower(last(explode('\\', get_class($this->model)))).'/';
    }
}
