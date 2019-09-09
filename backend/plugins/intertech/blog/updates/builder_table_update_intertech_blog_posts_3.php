<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogPosts3 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->integer('category_id');
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->dropColumn('category_id');
        });
    }
}
