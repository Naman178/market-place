<div>

    <section class="comment-box">
        <div class="">
            <h2 class="">Leave a Comment ({{$comments->count()}})</h2>
            @auth
            @include('commentify::livewire.partials.comment-form',[
            'method'=>'postComment',
            'state'=>'newCommentState',
            'inputId'=> 'comment',
            'inputLabel'=> 'Your comment',
            'button'=>'Post comment'
            ])
            @else

            <a href="/user-login" class="read_more_btn">
                <span class="text-line">
                    <span class="text">Sign In</span>
                    <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-dark.png" alt="Arrow">
                </span>
            </a>
            @endauth
            @if($comments->count())
            @foreach($comments as $comment)
            <livewire:comment :$comment :key="$comment->id" />
            @endforeach
            {{$comments->links()}}
            @else
            <p>No comments yet!</p>
            @endif
        </div>
    </section>
</div>