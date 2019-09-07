<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotPagePage3 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            if (Schema::hasColumn('perevorot_page_page', 'is_divider')) {
                $table->dropColumn('is_divider');
            }
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            $table->boolean('is_divider');
        });
    }
}