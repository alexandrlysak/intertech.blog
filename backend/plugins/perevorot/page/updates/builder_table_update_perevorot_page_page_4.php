<?php namespace Perevorot\Page\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotPagePage4 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            $table->string('route_type', 255)->nullable();
            $table->integer('route_id')->nullable()->unsigned();
            $table->dropColumn('route_name');
            $table->dropColumn('route_name_slug');
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_page_page', function($table)
        {
            $table->dropColumn('route_type');
            $table->dropColumn('route_id');
            $table->string('route_name', 255)->nullable();
            $table->string('route_name_slug', 255)->nullable();
        });
    }
}
