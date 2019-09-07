<?php namespace Perevorot\Page\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Perevorot\Maksymkotsiuba\Models\Project;

class ThumbsGenerate extends Command
{
    protected $name = 'thumbs:generate';

    protected $description = '';

    public function handle()
    {
        $models=[
            'Perevorot\Page\Models\Page',
        ];

        foreach($models as $modelName) {
            $model=new $modelName;

            $data=$model->get();

            foreach($data as $item){
                $item->save();
            }

            $this->output->writeln($modelName.': '.sizeof($data));
            
            sleep(1);
        }

    }

    protected function getArguments()
    {
        return [];
    }

    protected function getOptions()
    {
        return [];
    }

}