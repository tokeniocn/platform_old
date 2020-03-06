<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediableTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0)->comment('上传用户');
            $table->string('disk', 32);
            $table->string('directory');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('extension', 32);
            $table->string('mime_type', 128);
            $table->string('aggregate_type', 32);
            $table->integer('size')->unsigned();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index(['disk', 'directory']);
            $table->unique(['disk', 'directory', 'filename', 'extension']);
            $table->index('aggregate_type');
        });

        Schema::create('mediables', function (Blueprint $table) {
            $table->integer('media_id')->unsigned();
            $table->string('mediable_type');
            $table->integer('mediable_id')->unsigned();
            $table->string('tag');
            $table->integer('order')->unsigned();

            $table->primary(['media_id', 'mediable_type', 'mediable_id', 'tag']);
            $table->index(['mediable_id', 'mediable_type']);
            $table->index('tag');
            $table->index('order');
            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mediables');
        Schema::drop('media');
    }
}
