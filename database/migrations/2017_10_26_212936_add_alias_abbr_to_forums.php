<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAliasAbbrToForums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('forums', 'alias_abbr')) {
            Schema::table('forums', function (Blueprint $table) {
                $table->string('alias_abbr', 32)->nullable()->after('alias')->comment('拼音缩写');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('forums', 'alias_abbr')) {
            Schema::table('forums', function (Blueprint $table) {
                $table->dropColumn('alias_abbr');
            });
        };
    }
}
