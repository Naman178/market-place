@if(config('commentify.comment_nesting') === true)
    @auth
        @if($comment->isParent())
            <button type="button" wire:click="$toggle('isReplying')"
                    class="ml-2 blue_common_btn d-flex align-item-center items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                    </svg>
                    <span style="margin-left:15px">
                    <svg style=" left: 25px; stroke-dasharray: 0 !important;    width: 18px;" aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Reply
                    </span>
            </button>
            <div wire:loading wire:target="$toggle('isReplying')">
                @include('commentify::livewire.partials.loader')
            </div>
        @endif
    @endauth
    @if($comment->children->count())
        <button type="button" wire:click="$toggle('hasReplies')"
                class="ml-2 d-flex align-item-center  blue_common_btn  items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                </svg>
                <span>
                     @if(!$hasReplies)
                        View all Replies ({{$comment->children->count()}})
                    @else
                        Hide Replies
                    @endif
                </span>
        </button>
        <div wire:loading wire:target="$toggle('hasReplies')">
            @include('commentify::livewire.partials.loader')
        </div>
    @endif
@endif
