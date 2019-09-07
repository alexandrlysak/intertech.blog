<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogPosts2 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->string('title')->change();
            $table->string('slug')->change();
            $table->boolean('is_enabled')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->string('title', 191)->change();
            $table->string('slug', 191)->change();
            $table->boolean('is_enabled')->nullable(false)->change();
        });
    }
}
