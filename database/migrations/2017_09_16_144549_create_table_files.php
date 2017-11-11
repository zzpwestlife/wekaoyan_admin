<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('files')) {
            Schema::create('files', function (Blueprint $table) {
                $table->increments('id');
                $table->string('filename');
                $table->integer('user_id')->default(0);
                $table->integer('major_id');
                $table->tinyInteger('type')->default(0)->comment('0 公开课 1 专业课');
                $table->tinyInteger('category')->default(0)->comment('0 真题答案 1 资料');
                $table->tinyInteger('status')->default(0)->comment('状态 0 无效 1 有效');
                $table->integer('downloads')->default(0)->comment('下载量');
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
        if (Schema::hasTable('files')) {
            Schema::dropIfExists('files');
        }
    }
}
