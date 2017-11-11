<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentToMajor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('majors', 'department')) {
            Schema::table('majors', function (Blueprint $table) {
                $table->string('department')->nullable()->after('school_id')->comment('学院名称');
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
        if (Schema::hasColumn('majors', 'department')) {
            Schema::table('majors', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        };
    }
}
