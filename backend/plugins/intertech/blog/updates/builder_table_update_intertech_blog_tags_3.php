<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogTags3 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->boolean('is_enabled');
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->dropColumn('is_enabled');
        });
    }
}
