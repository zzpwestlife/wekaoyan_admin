<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('exams')) {
            Schema::create('exams', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('type')->default(0)->comment('1 简单计算 2 论述 。。。');
                $table->integer('file_id')->default(0)->comment('所属文件id');
                $table->string('content', 5000)->default('');
                $table->timestamps();
                $table->softDeletes();
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
        if (Schema::hasTable('exams')) {
            Schema::dropIfExists('exams');
        }
    }
}
