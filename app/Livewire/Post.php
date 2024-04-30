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
    /**
     * show existing post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function editPost($id){
        try{
            $post = Posts::findOrFail($id);
            if( !$post) {
                session()->flash('error', 'Post not found');
            } else {
                $this->title = $post->title;
                $this->description = $post->description;
                $this->postId = $post->id;
                $this->updatePost = true;
                $this->addPost = false;
            }
        }catch (\Exception $ex) {
            session()->flash('error', 'Something is wrong!');
        }
    }

    /**
     * update the post data
     * @return void
     */
    public function updatePost()
    {
        $this->validate();
        try {
            Posts::whereId($this->postId)->update([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success', 'Post Update Successfully!');
            $this->resetFields();
            $this->updatePost = false;
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!');
        }
    }
}
