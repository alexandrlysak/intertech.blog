<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteIntertechBlogPostsTags extends Migration
{
    public function up()
    {
        Schema::dropIfExists('intertech_blog_posts_tags');
    }
    
    public function down()
    {
        Schema::create('intertech_blog_posts_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->primary(['post_id','tag_id']);
        });
    }
}