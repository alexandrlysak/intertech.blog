<?php namespace Perevorot\Page\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Db;
use Event;
use stdClass;
use Exception;
use System\Models\File;
use RainLab\Translate\Models\Locale;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProjectUpCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'project:up';

    /**
     * @var string The console command description.
     */
    protected $description = '';

    public $languages = [
        'ua' => 'Українська',
        'en' => 'English',
    ];

    public $tableLongread = [
        //'perevorot_maksymkotsiuba_services',
    ];

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        if (env('APP_ENV')=='production') {
            $this->output->error('Нельзя добавить тестовые данные при APP_ENV=production');

            return false;
        }

        if ($this->confirm('Добавить тестовые данные? Ранее добвленные в таблицы данные будут удалены', $this->option('force'))) {
            $this->seedLocales();
            $this->seedLongreadPages();
            $this->seedTables();
        }
    }

    public function seedLocales()
    {
        Locale::truncate();

        $default=true;

        foreach ($this->languages as $code => $language) {
            $model = new Locale();

            $model->code = $code;
            $model->name = $language;

            $model->is_enabled = true;
            $model->is_default = $default;

            $model->save();

            $default=false;
        }
    }

    public function seedLongreadPages()
    {
        $locales = Locale::get();

        foreach ($locales as $locale) {
            foreach ($this->tableLongread as $tableName) {
                Schema::table($tableName, function(Blueprint $table) use ($locale, $tableName) {

                    foreach(['longread_'] as $prefix) {
                        $column = $prefix.$locale->code;

                        if (!Schema::hasColumn($tableName, $column)) {
                            $table->mediumText($column)->nullable();
                        }
                    }
                });
            }
        }
    }

    public function seedTables()
    {
        $files = \File::glob('./plugins/perevorot/page/console/data/*.json');
        $total = sizeof($files);

        $current=0;

        foreach ($files as $file) {
            $tableName=substr(basename((string) $file), 0, -5);

            $data=json_decode(file_get_contents($file), true);

            $current++;

            $this->output->write($current.'/'.$total.': '.$tableName.' (записей: '.(!empty($data)?sizeof($data):'0').')............');

            if (!empty($data)) {
                try {
                    DB::table($tableName)->delete();

                    foreach (array_chunk($data, 1000) as $chunk) {
                        DB::table($tableName)->insert($chunk);
                    }

                    $this->output->writeln('DONE');
                } catch (\Illuminate\Database\QueryException $e) {
                    $this->output->writeln('ERROR: ');
                    dump($e->getMessage());
                }
            }

            usleep(500);
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force run command', null],
        ];
    }
}