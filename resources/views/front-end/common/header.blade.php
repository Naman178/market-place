@php
use App\Models\Category;
use App\Models\SubCategory;
  $category = Category::where('sys_state','=','0')->get();
    if ($category->count()<=1){
        $category = Category::where('sys_state','=','0')->get();
    }
    else{
        $subcategory = SubCategory::where('sys_state','=','0')->get();
    }
@endphp
<div class="container header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                </a>
            </div>
        </div>
        <div class="col">
            <div class="menu-container menu-1">
                <ul>
                    @if ($category)
                        @foreach ($category as $item)
                            <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $item->id]) }}">Price</a></li>
                        @endforeach
                    @else
                        @foreach ($subcategory as $item)
                            <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $item->id]) }}">Price</a></li>
                        @endforeach
                    @endif
                    {{-- <li><a href="#">Documentation</a></li> --}}
                    <li><a href="{{ route('user-faq') }}">Faq</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="signin-container menu-1">
                <ul>
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="dropdown_label">  Welcome, {{ Auth::user()->name }} </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('user-dashboard') }}">
                                    <span class="dropdown_label">  Dashboard </span>
                                </a>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <span class="dropdown_label">  Profile Setting </span>
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="dropdown_label"> Logout </span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                    
                        <li class="signup-wrapper"><a class="signup_btn" href="{{ url('/signup') }}"> 
                            <svg width="119px" height="60px" viewBox="0 0 180 60" class="border">
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                            </svg>
                          </svg><span> Sign Up </span></a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>