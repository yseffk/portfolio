<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogPostBlogItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i < 101; $i++) {
            $data[] = [
                'blog_post_id' => rand(1, 12),
                'blog_item_id' => $i,

            ];
        }

        DB::table('blog_post_blog_items')->insert($data);
    }
}
