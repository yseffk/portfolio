<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogItemAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [];

        for ($i = 1; $i < 301; $i++) {
            $data[] = [
                'blog_item_id' => rand(1, 100),
                'type' => $this->getType(rand(0, 4)),
                'source' => $this->getSource(rand(0, 1)),
                'file_path' => asset('blog_attach/file.png'),
            ];
        }


        DB::table('blog_item_attachments')->insert($data);
    }

    private function getType($i)
    {

        $arr = ['IMG', 'DOC', 'PDF', 'VIDEO', 'AUDIO'];
        //return (isset($arr[$i])) ?? $arr[0];
        return $arr[0];
    }

    private function getSource($i)
    {

        $arr = ['LINK', 'FILE'];
//        return (isset($arr[$i])) ?? $arr[0];
        return $arr[0];
    }
}
