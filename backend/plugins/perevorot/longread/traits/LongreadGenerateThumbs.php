<?php namespace Perevorot\Longread\Traits;

use System\Models\File;
use Event;
use DB;

trait LongreadGenerateThumbs
{
    public function __construct()
    {
        parent::__construct();

        $this::extend(function($model) {
            $model->bindEvent('model.beforeSave', function() use ($model) {
                if(method_exists($model, 'beforeSave')){
                    $model->beforeSave();
                }

                $model->generateThumbnails();
            });
        });
    }

    public function generateThumbnails()
    {
        $filesToGenerate=[];

        $deffered=DB::table('deferred_bindings')->where('master_field', 'like', '__longread%')->where('session_key', post('_session_key'))->get();
        
        foreach($deffered as $item) {
            $filesToGenerate[]=(object) [
                'master_field'=>$item->master_field,
                'slave_id'=>$item->slave_id,
            ];
        }

        $systemFiles=File::select('id as slave_id', 'field as master_field')->where('attachment_id', $this->id)->where('field', 'like', '__longread%')->get();

        foreach($systemFiles as $item) {
            $filesToGenerate[]=(object) [
                'master_field'=>$item->master_field,
                'slave_id'=>$item->slave_id,
            ];
        }

        $slaveIdThumbSizes=[];

        Event::fire('longread.blocks.get', [$this], true);

        foreach($filesToGenerate as $def) {
            $tmp=explode('_', $def->master_field);
            
            if($tmp[2]=='longread') {
                $longreadBlockName=$tmp[6];

                if(!empty($this->longreadBlocks[$longreadBlockName]['config']['thumbs'])){
                    $slaveIdThumbSizes[$def->slave_id]=$this->longreadBlocks[$longreadBlockName]['config']['thumbs'];
                }
            }
        }

        if(!empty($slaveIdThumbSizes)) {
            $files=File::whereIn('id', array_keys($slaveIdThumbSizes))->get();

            foreach($files as $file) {
                if(!empty($slaveIdThumbSizes[$file->id]) && file_exists($file->getLocalPath())) {
                    //['2000x1325xauto', '2000x1325xcrop', '1400x930xauto', '1400x930xcrop', '700x460xauto', '700x460xcrop'];

                    foreach($slaveIdThumbSizes[$file->id] as $dimensions) {
                        $size=explode('x', $dimensions);
        
                        $file->getThumb($size[0], $size[1], [
                            'mode' => !empty($size[2]) ? $size[2] : 'auto',
                            'quality' => 90
                        ]);
                    }
                }
            }
        }
    }
}