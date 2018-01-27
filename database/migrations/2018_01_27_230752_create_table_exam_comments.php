<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExamComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('exam_comments')) {
            Schema::create('exam_comments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('exam_id')->default(0);
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
        if (Schema::hasTable('exam_comments')) {
            Schema::dropIfExists('exam_comments');
        }
    }
}
