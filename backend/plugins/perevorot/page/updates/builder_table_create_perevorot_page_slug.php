<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePerevorotPageSlug extends Migration
{
    public function up()
    {
        Schema::create('perevorot_page_slug', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('slug');
            $table->string('model');
            $table->integer('parent_id')->unsigned();

            $table->index('slug');
            $table->index('model');
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perevorot_page_slug');
    }
}