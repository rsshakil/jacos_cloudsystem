<?php

use Illuminate\Database\Seeder;

class cmn_blogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmn_blog_list = array(
            [
                'blog_by'=>1,
                'blog_title'=>"Super Admin Blog",
                'blog_content'=>"<p>Super Admin AAAAA</p>",
            ],[
                'blog_by'=>4,
                'blog_title'=>"Buyer 1 Blog",
                'blog_content'=>"<p>Buyer1 AAAAAAAA</p>",
            ],[
                'blog_by'=>10,
                'blog_title'=>"Buyer 2 Blog",
                'blog_content'=>"<p>Buyer 2 BBBBBBB</p>",
           ],[
                'blog_by'=>11,
                'blog_title'=>"Buyer 3 Blog",
                'blog_content'=>"<p>Buyer 3 CCCCCCC</p>",
            ]
            
        );
        App\Models\CMN\cmn_blog::insert($cmn_blog_list);
    }
}
