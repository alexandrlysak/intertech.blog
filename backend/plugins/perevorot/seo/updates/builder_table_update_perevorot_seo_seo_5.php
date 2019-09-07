<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotSeoSeo5 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->boolean('is_active')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->dropColumn('is_active');
        });
    }
}
