<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogPosts extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->integer('sort_order')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('title')->change();
            $table->string('slug')->change();
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->dropColumn('sort_order');
            $table->increments('id')->unsigned()->change();
            $table->string('title', 191)->change();
            $table->string('slug', 191)->change();
        });
    }
}
