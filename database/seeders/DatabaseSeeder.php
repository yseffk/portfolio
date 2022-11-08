<?php

namespace Database\Seeders;

use App\Models\BlogItem;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(3)->create();

//        \App\Models\BlogItem::factory(100)->create();

//        $this->call(BlogItemAttachmentSeeder::class);

        \App\Models\BlogPost::factory(2)
            ->state(new Sequence(
                ['title' => 'Блог', 'slug' => Str::slug('Блог')],
                ['title' => 'Галерея', 'slug' => Str::slug('Галерея')],
                ))
            ->create();

        //$this->call(BlogPostBlogItemsSeeder::class);
        $this->call(RolesSeeder::class);

    }
}
