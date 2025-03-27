<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-end/css/mainstylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/home_page_responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/product_responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Toastr CSS (Toast notifications) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
    @yield('styles')

    <script src="{{ asset('front-end/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<body>
    @php
        use App\Models\Category;
        use App\Models\SubCategory;
        use App\Models\Settings;
        $category = Category::where('sys_state','=','0')->first();
        $subcategory = SubCategory::where('sys_state','=','0')->first();
        $site = Settings::where('key','site_setting')->first();
    @endphp
    @include('front-end.common.header')
    <div class="main-content">
        @yield('content')
    </div>
    @include('front-end.common.footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Toastr JS (Toast notifications) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield('scripts')

    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @elseif(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
        document.addEventListener("DOMContentLoaded", function () {
            let dropdownLabels = document.querySelectorAll(".dropdown_label");
            
            dropdownLabels.forEach(label => {
                let fullName = label.getAttribute("data-fullname");
                if (fullName) {
                    label.setAttribute("title", fullName.trim());
                }
            });
        });
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                // Toggle the 'd-none' class on the mobile menu
                mobileMenu.classList.toggle('d-none');
                menuToggle.classList.remove('d-none');
                console.log('Menu toggled');
            });
        } else {
            console.log('Menu toggle elements not found');
        }

        jQuery(document).ready(function () {
            var body = jQuery(document.body);
            var button = jQuery("svg");
            var line = jQuery("line");

            button.click(function () {
                if (jQuery(document.body).hasClass("menu-open")) {
                    body.removeClass("menu-open");
                    return;
                }
                body.addClass("menu-open");
            });
        });

    </script>
</body>
</html>
