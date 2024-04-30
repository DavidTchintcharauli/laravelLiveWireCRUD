<?php

namespace App\Livewire;

use Livewire\Component;

class Post extends Component
{
    public $posts, $title, $description, $postId, $updatePost = false, $addPost = false;

    protected $listeners = [
        'deletePostListner'=>'deletePost'
    ];

    public function render()
    {
        return view('livewire.post');
    }
}
