<?php

namespace App\Observers;

use App\Models\BlogItem;

class BlogItemObserver
{
    /**
     * Handle the BlogItem "creating" event.
     *
     * @param  \App\Models\BlogItem  $blogItem
     * @return void
     */
    public function creating(BlogItem $blogItem)
    {

    }
    /**
     * Handle the BlogItem "created" event.
     *
     * @param  \App\Models\BlogItem  $blogItem
     * @return void
     */
    public function created(BlogItem $blogItem)
    {
//        $this->setPostItemRelationship($blogItem);

    }

    /**
     * Handle the BlogItem "updated" event.
     *
     * @param  \App\Models\BlogItem  $blogItem
     * @return void
     */
    public function updating(BlogItem $blogItem)
    {

    }


    private function setPostItemRelationship(BlogItem $blogItem)
    {
        request()->all();
    }

}
