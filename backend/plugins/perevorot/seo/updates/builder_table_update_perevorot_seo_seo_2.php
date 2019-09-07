<?php namespace Perevorot\Seo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePerevorotSeoSeo2 extends Migration
{
    public function up()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->string('og_title');
            $table->text('og_description');
        });
    }
    
    public function down()
    {
        Schema::table('perevorot_seo_seo', function($table)
        {
            $table->dropColumn('og_title');
            $table->dropColumn('og_description');
        });
    }
}
