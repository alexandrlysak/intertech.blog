<?php namespace Intertech\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIntertechBlogPosts5 extends Migration
{
    public function up()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->text('payout_options');
        });
    }
    
    public function down()
    {
        Schema::table('intertech_blog_posts', function($table)
        {
            $table->dropColumn('payout_options');
        });
    }
}
