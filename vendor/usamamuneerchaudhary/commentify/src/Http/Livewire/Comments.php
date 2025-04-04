<?php

namespace Usamamuneerchaudhary\Commentify\Http\Livewire;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $model;
    public $itemId; 

    public $users = [];

    public $showDropdown = false;
    
    protected $numberOfPaginatorsRendered = [];

    public $newCommentState = [
        'body' => ''
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|null
     */
    public function render(
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|null
    {
        if ($this->itemId) {
            $comments = $this->model->comments()
                ->where('item_id', $this->itemId)
                ->with('user')
                ->latest()
                ->paginate(config('commentify.pagination_count', 10)); // ✅ Fix: Use paginate() instead of get()
        } else {
            $comments = $this->model
                ->comments()
                ->where('item_id',null)
                ->with('user', 'children.user', 'children.children')
                ->parent()
                ->latest()
                ->paginate(config('commentify.pagination_count', 10));
        }
        
       
        return view('commentify::livewire.comments', [
            'comments' => $comments
        ]);
    }

    /**
     * @return void
     */
    #[On('refresh')]
    public function postComment(): void
    {
        $this->validate([
            'newCommentState.body' => 'required'
        ]);
        if ($this->itemId) {
            $this->newCommentState['item_id'] = $this->itemId;
        }
        $comment = $this->model->comments()->make($this->newCommentState);
        $comment->user()->associate(auth()->user());
        $comment->item_id = $this->itemId ?? null;
        $comment->save();
        $this->newCommentState = [
            'body' => ''
        ];
        $this->users = [];
        $this->showDropdown = false;

        $this->resetPage();
        session()->flash('message', 'Comment Posted Successfully!');
    }

}
