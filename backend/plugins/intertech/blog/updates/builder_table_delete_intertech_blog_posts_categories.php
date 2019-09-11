<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteIntertechBlogPostsCategories extends Migration
{
    public function up()
    {
        Schema::dropIfExists('intertech_blog_posts_categories');
    }
    
    public function down()
    {
        Schema::create('intertech_blog_posts_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id');
            $table->integer('category_id');
            $table->primary(['post_id','category_id']);
        });
    }
}
