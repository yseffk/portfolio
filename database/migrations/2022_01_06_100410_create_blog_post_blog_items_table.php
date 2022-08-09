<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostBlogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_blog_items', function (Blueprint $table) {
            $table->bigInteger('blog_post_id')->unsigned();
            $table->bigInteger('blog_item_id')->unsigned();
            $table->primary(['blog_post_id', 'blog_item_id']);
        });

        Schema::table('blog_post_blog_items', function (Blueprint $table) {
            $table->foreign('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('cascade');

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
        Schema::dropIfExists('blog_post_blog_items');
    }
}
