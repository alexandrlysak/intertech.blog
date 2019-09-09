<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateIntertechBlogPostsTags2 extends Migration
{
    public function up()
    {
        Schema::create('intertech_blog_posts_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->primary(['post_id','tag_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('intertech_blog_posts_tags');
    }
}
