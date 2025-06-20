<form class="mb-6" wire:submit="{{$method}}">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                 role="alert">
                <span class="font-medium">Success!</span> {{session('message')}}
            </div>
        </div>
    @endif
    @csrf
    <div>
        <label for="{{$inputId}}" class="sr-only">{{$inputLabel}}</label>
        <textarea  class="py-2 px-2 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700" id="{{$inputId}}" rows="6" style="width: 100%; padding: 10px !important; outline: none;"
                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none
                              dark:text-white dark:placeholder-gray-400 dark:bg-gray-800 @error($state.'.body')
                              border-red-500 @enderror"
                  placeholder="Write a comment..."
                  wire:model.live="{{$state}}.body"
                  oninput="detectAtSymbol()"
        ></textarea>
        @if(!empty($users) && $users->count() > 0)
            @include('commentify::livewire.partials.dropdowns.users')
        @endif
        @error($state.'.body')
        <p class="mt-2 text-sm text-red-600">
            {{$message}}
        </p>
        @enderror
    </div>

    <button wire:loading.attr="disabled" type="submit"
            class=" blue_common_btn inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
            </svg>
            <span>{{$button}}</span>
            <div wire:loading wire:target="{{$method}}">
            @include('commentify::livewire.partials.loader')
        </div>
         {{-- {{$button}} --}}
    </button>

</form>
