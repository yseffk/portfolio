<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_items', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('brief_content')->nullable();
            $table->longText('raw_content')->nullable();
            $table->longText('html_content')->nullable();
            $table->boolean('is_free')->default(false);
            $table->boolean('is_published')->default(false)->index();
            $table->string('external_url',255)->nullable();
            $table->integer('duration')->default(0);
            $table->integer('sort')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_items');
    }
}
