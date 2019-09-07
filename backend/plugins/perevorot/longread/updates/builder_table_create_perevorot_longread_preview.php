<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePerevorotLongreadPreview extends Migration
{
    public function up()
    {
        Schema::create('perevorot_longread_preview', function($table)
        {
            $table->engine = 'InnoDB';

            $table->integer('user_id')->unsigned();
            $table->integer('model_id')->unsigned();

            $table->string('model', 255);
            $table->string('field', 255);

            $table->mediumText('longread');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perevorot_longread_preview');
    }
}