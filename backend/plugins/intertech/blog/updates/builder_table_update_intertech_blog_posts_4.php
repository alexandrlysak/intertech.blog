<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogPosts4 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->boolean('is_payout')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->dropColumn('is_payout');
        });
    }
}
