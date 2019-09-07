<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogTags5 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->integer('sort_order')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
