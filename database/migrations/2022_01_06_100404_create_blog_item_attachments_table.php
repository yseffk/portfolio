<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogItemAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_item_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_item_id')->unsigned()->index();
            $table->enum('type',['IMG', 'NOTES', 'TEXT', 'VIDEO','AUDIO']);
            $table->enum('source',['LINK','FILE']);
            $table->string('file_path',255);
        });
        Schema::table('blog_item_attachments', function (Blueprint $table) {
            $table->foreign('blog_item_id')
                ->references('id')
                ->on('blog_items')
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
        Schema::dropIfExists('blog_item_attachments');
    }
}
