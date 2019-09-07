<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotPagePage extends Migration
{
    public function up()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            $table->string('route_name')->nullable();
            $table->smallInteger('type')->nullable(false)->unsigned()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            $table->dropColumn('route_name');
            $table->boolean('type')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
