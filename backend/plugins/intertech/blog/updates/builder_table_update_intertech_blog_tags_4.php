<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogTags4 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_tags', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
