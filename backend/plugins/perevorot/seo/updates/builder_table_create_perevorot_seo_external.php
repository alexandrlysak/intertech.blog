<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePerevorotSeoExternal extends Migration
{
    public function up()
    {
        Schema::create('perevorot_seo_external', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('url_mask');
            $table->text('head');
            $table->text('body_top');
            $table->text('body_bottom');
            $table->boolean('is_active')->default(1);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('perevorot_seo_external');
    }
}
