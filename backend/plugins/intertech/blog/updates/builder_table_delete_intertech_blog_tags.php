<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteIntertechBlogTags extends Migration
{
    public function up()
    {
        Schema::dropIfExists('intertech_blog_tags');
    }
    
    public function down()
    {
        Schema::create('intertech_blog_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 191);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
