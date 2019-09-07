<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePerevorotPagePage extends Migration
{
    public function up()
    {
        Schema::create('perevorot_page_page', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();

            $table->integer('menu_id')->nullable()->unsigned();
            $table->boolean('type')->unsigned();

            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('nest_left')->nullable()->unsigned();
            $table->integer('nest_right')->nullable()->unsigned();
            $table->integer('nest_depth')->nullable()->unsigned();

            $table->string('title', 255);
            $table->string('url', 255);
            $table->string('url_external', 255)->nullable();

            $table->integer('alias_page_id')->nullable()->unsigned();

            $table->boolean('is_target_blank')->default(0);
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_disabled')->default(0);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            $table->index('title');
            $table->index('menu_id');
            $table->index('parent_id');
            $table->index('nest_left');
            $table->index('nest_right');
            $table->index('nest_depth');
            $table->index('url');
            $table->index('alias_page_id');
            $table->index('is_hidden');
            $table->index('is_disabled');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perevorot_page_page');
    }
}