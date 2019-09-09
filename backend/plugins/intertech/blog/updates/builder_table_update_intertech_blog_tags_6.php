<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogTags6 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->integer('sort_order')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->integer('sort_order')->default(null)->change();
        });
    }
}
