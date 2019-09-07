<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotSeoExternal extends Migration
{
    public function up()
    {
        Schema::table('perevorot_seo_external', function($table)
        {
            $table->boolean('seo_url_type');
            $table->text('route');
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_seo_external', function($table)
        {
            $table->dropColumn('seo_url_type');
            $table->dropColumn('route');
        });
    }
}
