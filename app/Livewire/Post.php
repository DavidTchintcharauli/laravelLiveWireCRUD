<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post as Posts;

class Post extends Component
{
    public $posts, $title, $description, $postId, $updatePost = false, $addPost = false;

    protected $listeners = [
        'deletePostListner' => 'deletePost'
    ];

    protected $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
    }
    /**
     * render the post data 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->posts = Posts::select('id', 'title', 'description')->get();
        return view('livewire.post');
    }

    /**
     * Open add Post form
     * @return void
     */
    public function addPost()
    {
        $this->resetFields();
        $this->addPost = true;
        $this->updatePost = false;
    }
    /**
     * store the user inputted post data in the posts table
     * @return void
     */
    public function storePost()
    {
        $this->validate();
        try {
            Posts::create([
                'title' =>$this->title,
                'description' => $this->description
            ]);
            session()->flash('success','Post Creted Successfully!');
            $this->resetFields();
            $this->addPost = false;
        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!');
        }
    }
}
