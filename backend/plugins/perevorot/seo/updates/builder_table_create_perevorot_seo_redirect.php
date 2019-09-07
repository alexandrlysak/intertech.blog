<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePerevorotSeoRedirect extends Migration
{
    public function up()
    {
        Schema::create('perevorot_seo_redirects', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('old_url');
            $table->string('new_url');
            $table->integer('counter')->unsigned()->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('perevorot_seo_redirects');
    }
}