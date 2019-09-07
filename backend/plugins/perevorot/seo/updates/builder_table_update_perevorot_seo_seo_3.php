<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotSeoSeo3 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->text('route');
            $table->boolean('seo_url_type');
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->dropColumn('route');
            $table->dropColumn('seo_url_type');
        });
    }
}
