<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotSeoSeo4 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->string('image');
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->dropColumn('image');
        });
    }
}
