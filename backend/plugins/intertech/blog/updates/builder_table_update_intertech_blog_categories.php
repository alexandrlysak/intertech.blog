<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogCategories extends Migration
{
    public function up()
    {
        Schema::rename('intertech_blog_', 'intertech_blog_categories');
        Schema::table('intertech_blog_categories', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('title')->change();
            $table->string('slug')->change();
        });
    }
    
    public function down()
    {
        Schema::rename('intertech_blog_categories', 'intertech_blog_');
        Schema::table('intertech_blog_', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('title', 191)->change();
            $table->string('slug', 191)->change();
        });
    }
}
