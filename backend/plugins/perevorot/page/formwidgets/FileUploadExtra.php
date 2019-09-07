<?php namespace Perevorot\Page\FormWidgets;

use Backend\FormWidgets\FileUpload as FileUploadBase;

class FileUploadExtra extends FileUploadBase
{
    public $extra = [
        'isCheckBox' => true,
        'name' => 'Гиперссылка',
        'descriptionName' => ''
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'prompt',
            'imageWidth',
            'imageHeight',
            'fileTypes',
            'mimeTypes',
            'thumbOptions',
            'useCaption',
            'extra'
        ]);

        if ($this->formField->disabled) {
            $this->previewMode = true;
        }

        $this->vars['extra'] = $this->extra;

        $this->checkUploadPostback();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('fileuploadextra');
    }

    protected function loadAssets()
    {
        $this->addCss('/modules/backend/formwidgets/fileupload/assets/css/fileupload.css', 'core');
        $this->addJs('/modules/backend/formwidgets/fileupload/assets/js/fileupload.js', 'core');
    }

    public function onSaveAttachmentConfig()
    {
        try {
            $fileModel = $this->getRelationModel();

            if (($fileId = post('file_id')) && ($file = $fileModel::find($fileId))) {
                $file->title = post('title');

                $json=json_encode([
                    'description'=>post('description'),
                    'url'=>post('url'),
                    'is_target_blank'=>post('is_target_blank')==='on' ? true : false
                ]);

                $file->description = $json;
                $file->save();

                return ['displayName' => $file->title ?: $file->file_name];
            }

            throw new ApplicationException('Unable to find file, it may no longer exist');
        }
        catch (Exception $ex) {
            return json_encode(['error' => $ex->getMessage()]);
        }
    }
}
