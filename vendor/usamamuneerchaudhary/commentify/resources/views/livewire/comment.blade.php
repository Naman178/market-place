<div>
    @if($isEditing)
        @include('commentify::livewire.partials.comment-form',[
            'method'=>'editComment',
            'state'=>'editState',
            'inputId'=> 'reply-comment',
            'inputLabel'=> 'Your Reply',
            'button'=>'Edit Comment'
        ])
    @else
        <article class="p-6 mb-1 text-base bg-white rounded-lg dark:bg-gray-900">
            <footer class="mb-1 pt-3 p-0">

                <div class=" d_flex align-items-center justify-content-between ">
                    <p class="d-flex align-items-center justify-cotent-start mr-3 text-sm text-gray-900 dark:text-white">
                        @php
                            $profilePic = filter_var($comment->user->profile_pic, FILTER_VALIDATE_URL) 
                                ? $comment->user->profile_pic 
                                : asset('assets/images/faces/' . ($comment->user->profile_pic ?? 'avatar.png'));
                        @endphp
                    
                        <img class="rounded-full header_image" src="{{ $profilePic }}" alt="{{ $comment->user->name }}">
                      <span class="dropdown_label" data-fullname="{{ $comment->user->name }}">  {{ Str::ucfirst($comment->user->name) }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-cotent-end text-sm text-gray-600 dark:text-gray-400">
                        <time pubdate datetime="{{ $comment->presenter()->relativeCreatedAt() }}"
                            title="{{ $comment->presenter()->relativeCreatedAt() }}">
                            {{ $comment->presenter()->relativeCreatedAt() }}
                        </time>
                    </p>
                </div>
                {{-- <div class="relative">
                    
                   
                </div> --}}
            </footer>
            
            <div class="d-flex align-items-center " style="justify-content: space-between">
                <div class="d-flex align-items-center " style="justify-content: start">
                    <p class="text-gray-500 dark:text-gray-400"  style="text-align: left">
                        {!! $comment->presenter()->replaceUserMentions($comment->presenter()->markdownBody()) !!}
                    </p>
                </div>
                <button wire:click="$toggle('showOptions')"
                class="blue_common_btn inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        type="button">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <svg style=" display: inline-block;   width: 20px; height: 20px;     stroke-dasharray: 0 !important;" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                </button>
        </div>
         <!-- Dropdown menu -->
         @if($showOptions)
         <div style="justify-content: end"
                 class="d-flex align-items-center absolute z-10 top-full right-0 mt-1 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
             <ul class="py-1 text-sm text-gray-700 dark:text-gray-200 mt-0">
                 @can('update',$comment)
                     <li class="mb-1">
                         <button wire:click="$toggle('isEditing')" type="button"
                                  class="blue_common_btn block w-full text-left py-2 px-4 hover:bg-gray-100
                            dark:hover:bg-gray-600
                            dark:hover:text-white">
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                            </svg>
                            <span>Edit</span>
                         </button>
                     </li>
                 @endcan
                 @can('destroy', $comment)
                 <li>
                     <button
                         x-data="{
                             confirmCommentDeletion() {
                                 Swal.fire({
                                     title: 'Are you sure?',
                                     text: 'You won\'t be able to undo this!',
                                     icon: 'warning',
                                     showCancelButton: true,
                                     confirmButtonColor: '#d33',
                                     cancelButtonColor: '#3085d6',
                                     confirmButtonText: 'Yes, delete it!'
                                 }).then((result) => {
                                     if (result.isConfirmed) {
                                         @this.call('deleteComment');
                                     }
                                 });
                             }
                         }"
                         x-on:click="confirmCommentDeletion"
                         class="blue_common_btn block w-full text-left py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                         <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                             <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                             <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                         </svg>
                         <span>Delete</span>
                     </button>
                 </li>
                 @endcan
             </ul>
         </div>
     @endif

            <div class="d-flex align-item-center items-center mt-4 space-x-4 mb-2">
                <livewire:like :$comment :key="$comment->id"/>

                @include('commentify::livewire.partials.comment-reply')

            </div>

        </article>
    @endif
    @if($isReplying)
        @include('commentify::livewire.partials.comment-form',[
           'method'=>'postReply',
           'state'=>'replyState',
           'inputId'=> 'reply-comment',
           'inputLabel'=> 'Your Reply',
           'button'=>'Post Reply'
       ])
    @endif
    @if($hasReplies)

        <article class="p-1 mb-1 ml-1 lg:ml-12 border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            @foreach($comment->children as $child)
                <livewire:comment :comment="$child" :key="$child->id"/>
            @endforeach
        </article>
    @endif
    <script>

        function detectAtSymbol() {
            const textarea = document.getElementById('reply-comment');
            if (!textarea) {
                return;
            }

            const cursorPosition = textarea.selectionStart;
            const textBeforeCursor = textarea.value.substring(0, cursorPosition);
            const atSymbolPosition = textBeforeCursor.lastIndexOf('@');

            if (atSymbolPosition !== -1) {
                const searchTerm = textBeforeCursor.substring(atSymbolPosition + 1);
                if (searchTerm.trim().length > 0) {
                    @this.dispatch('getUsers', { searchTerm: searchTerm});
                }
            }
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</div>


