<?php

namespace App\Livewire;

use Livewire\Component;

class Post extends Component
{
    public $posts, $title, $description, $postId, $updatePost = false, $addPost = false;

    protected $listeners = [
        'deletePostListner'=>'deletePost'
    ];

    protected $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    /**
    * Reseting all inputted fields
    * @return void
    */
    public function resetFields(){
        $this->title = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.post');
    }
}
