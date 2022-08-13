<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "creating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setSlug($blogPost);
        $this->setUser($blogPost);
    }
    /**
     * Handle the BlogPost "updating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
        $this->creating($blogPost);

    }

    private function setSlug(BlogPost $blogPost): void
    {
        if(empty($blogPost->slug)){
            $blogPost->slug = Str::slug(rand(0,99).'-'.$blogPost->title);
        }
    }

    private function setUser(BlogPost $blogPost)
    {
        if(empty($blogPost->user_id)){
            $blogPost->user_id = 1;
        }

    }
}
