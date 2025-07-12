@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
@endphp
<div id="notification-bar" class="notification-bar">
  <span class="message">
    🚀 Get <strong>50% OFF</strong> all products — limited time only! 
    <a href="/special-offer">Shop Now →</a>
  </span>
  <button id="close-notification" aria-label="Close">&times;</button>
</div>
<div class="sticky-header">
<div class="container">
    <div class="header-row py-4">
        <div class="col-md-4 p-0 m-0 logo-container">
            <a href="{{ url('/') }}">
                @if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
                    <img src="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" alt="Logo">
                @else
                    <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                @endif
            </a>
        </div>
        <div class="col-md-8 p-0 m-0 menu-container menu-1">
                <ul>
                   @if (!empty($subcategory))
                        <li class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('product.list.show') }}">
                                Our Products
                            </a>
                        </li>
                    @endif

                    <li class="dropdown-hover position-relative" 
                        onmouseenter="openDropdown()" 
                        onmouseleave="closeDropdown()">

                        <a href="#" class="dropdown-toggle">Categories</a>

                        <div class="dropdown-menu-custom d-flex flex-column" id="dropdownMenu">

                            <!-- Full-width horizontal category list at top -->
                            <div class="categories-panel d-flex gap-4 mb-2" style="width: 100%;">
                                @foreach ($headerCategories as $cat)
                                    <div 
                                        class="category-item" 
                                        data-subid="{{ $cat->id }}"
                                        onclick="toggleSubcategories({{ $cat->id }})"
                                    >
                                        <a href="#">{{ $cat->name }}</a>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Main content: Left (subcategories) + Right (products) -->
                            <div class="d-flex" style="gap: 32px;">
                                <!-- Left: Subcategories -->
                                <div class="subcategories-panel">
                                    @foreach ($headerCategories as $cat)
                                        @if ($cat->subcategories->isNotEmpty())
                                            <div class="sub-list d-none" id="sub-{{ $cat->id }}">
                                                @foreach ($cat->subcategories as $sub)
                                                    <a href="#" 
                                                        onclick="showProducts({{ $cat->id }}, {{ $sub->id }})"
                                                        data-cat="{{ $cat->id }}" 
                                                        data-sub="{{ $sub->id }}">
                                                        {{ $sub->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Right: Products -->
                                <div class="right-panel d-flex flex-column" style="flex: 1;">
                                    <div class="products-panel" id="productsPanel">
                                        <p>No products found.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>

                    </li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Blogs</a></li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Resources</a></li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Documentation</a></li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('contact-us') }}">Contact</a></li>
                    @auth
                    <li class="dropdown d_flex align-items-center justify-content-center">
                        <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d_flex align-items-center justify-content-center">  
                            @if (empty(auth()->user()->profile_pic) || auth()->user()->profile_pic == null)
                                @php
                                    $names = explode(' ', auth()->user()->name);
                                    $initials = '';
                                    foreach ($names as $name) {
                                        $initials .= strtoupper(substr($name, 0, 1));
                                    }
                                @endphp
                                  <div class="rounded-full bg-gray-200 d_flex items-center justify-content-center text-gray-700 mr-2" title="{{ auth()->user()->name }}">
                                    {{ $initials ?: strtoupper(implode('', array_map(function($namePart) { return $namePart[0]; }, explode(' ', auth()->user()->name)))) }}
                                </div>
                            @else
                                @php
                                    $profilePic = filter_var(auth()->user()->profile_pic, FILTER_VALIDATE_URL) 
                                            ? auth()->user()->profile_pic 
                                            : asset('assets/images/faces/' . auth()->user()->profile_pic);
                                @endphp
                                <img src="{{ $profilePic }}" alt="profile"
                                    class="rounded-full header_image">
                            @endif 
                         <span class="dropdown_label" data-fullname="{{ Auth::user()->name }}"> {{ Auth::user()->name }}  </span></span>
                        </a>
                        @if (auth()->user()->email === "superadmin@gmail.com")
                            <div class="dropdown-menu mt-6" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <span class="dropdown_label">  Dashboard </span>
                                </a>
                            </div>
                        @else
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('user-dashboard') }}">
                                <span class="dropdown_label">  Dashboard </span>
                            </a>
                            <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                <span class="dropdown_label">  Wishlist </span>
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
                        @endif
                    </li>
                @else
                    <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                    <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/signup') }}">Sign Up</a></li>
                @endif
                </ul>
        </div>

        <div class="menu-toggle d-lg-none" id="menu-toggle">
            <button class="menu-btn">
                <svg class="vbp-header-menu-button__svg">
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="top" shape-rendering="crispEdges" />
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="middle" shape-rendering="crispEdges" />
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="bottom" shape-rendering="crispEdges" />
                  </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="menu-container menu-1 d-none d-lg-block">
            <ul>
                @if (!empty($subcategory))
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}">Products</a></li>
                @endif
                {{-- <li><a href="#">Documentation</a></li> --}}
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Blog</a></li>
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('user-faq') }}">Faq</a></li>
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                @auth
                <li class="dropdown d_flex align-items-center justify-content-center">
                    <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d_flex align-items-center justify-content-center">  
                        @if (empty(auth()->user()->profile_pic) || auth()->user()->profile_pic == null)
                            @php
                                $names = explode(' ', auth()->user()->name);
                                $initials = '';
                                foreach ($names as $name) {
                                    $initials .= strtoupper(substr($name, 0, 1));
                                }
                            @endphp
                              <div class="rounded-full bg-gray-200 d_flex items-center justify-content-center text-gray-700 mr-2" title="{{ auth()->user()->name }}">
                                {{ $initials ?: strtoupper(implode('', array_map(function($namePart) { return $namePart[0]; }, explode(' ', auth()->user()->name)))) }}
                            </div>
                        @else
                            <img src="{{ asset('assets/images/faces/' . auth()->user()->profile_pic) }}" alt="profile"
                                class="rounded-full header_image">
                        @endif 
                     <span class="dropdown_label" data-fullname="{{ Auth::user()->name }}"> {{ Auth::user()->name }}  </span></span>
                    </a>
                    @if (auth()->user()->email === "superadmin@gmail.com")
                        <div class="dropdown-menu mt-6" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <span class="dropdown_label">  Dashboard </span>
                            </a>
                        </div>
                    @else
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
                    @endif
                </li>
            @else
                <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/signup') }}">Sign Up</a></li>
            @endif
            </ul>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="mobile-menu d-none" id="mobile-menu">
    <ul>
        @if (!empty($subcategory))
            <li>
                <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}">
                    Products
                </a>
            </li>
        @endif
        <!-- Toggle Button to show all categories -->
        <li>
            <a href="javascript:void(0);"
            onclick="toggleMobileCategoryList()"
            class="fw-bold d-flex justify-content-between align-items-center">
                <span>Categories</span>
                <span id="main-cat-arrow">▶</span>
            </a>

            <!-- Hidden category list -->
            <ul id="mobile-category-list" class="transition-collapse ps-3 text-start">
                @foreach ($headerCategories as $cat)
                    <li>
                        <a href="javascript:void(0);"
                            class="mobile-cat-toggle d-flex justify-content-between align-items-center"
                            data-cat="{{ $cat->id }}"
                            onclick="toggleMobileSubcategories({{ $cat->id }})">
                                <span>{{ $cat->name }}</span>
                                <span id="cat-arrow-{{ $cat->id }}">▶</span>
                        </a>

                        <!-- Subcategory container -->
                        <ul class="mobile-sub-list transition-collapse ps-3" id="mobile-sub-{{ $cat->id }}"></ul>
                    </li>
                @endforeach
            </ul>
        </li>

        <!-- Other menu items -->
        <li><a href="{{ route('blog-index') }}">Blog</a></li>
        <li><a href="{{ route('contact-us') }}">Contact</a></li>

        @auth
            <li><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('profile') }}">Profile Setting</a></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        @else
            <li><a href="{{ url('/user-login') }}">Login</a></li>
            <li><a href="{{ url('/signup') }}">Sign Up</a></li>
        @endif
    </ul>
</div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentRoute = "{{ Route::currentRouteName() }}";
        if (currentRoute === 'home') return;
        const currentCountry = "{{ strtolower($country) }}"; // from backend
        const currentIP = "{{ $ipAddress }}"; // from backend

        const storedIP = localStorage.getItem('ip_address');
        const storedCountry = localStorage.getItem('country');
        const preferredCurrency = localStorage.getItem('preferred_currency');

        // Save current IP and country
        localStorage.setItem('ip_address', currentIP);
        localStorage.setItem('country', currentCountry);

        const resetCurrencyAndPopup = () => {
            localStorage.removeItem('currency_popup_shown');
            localStorage.removeItem('preferred_currency');
        };

        // Reset popup if IP or country has changed
        if (storedIP !== currentIP || storedCountry !== currentCountry) {
            resetCurrencyAndPopup();
        }

        const popupShown = localStorage.getItem('currency_popup_shown');

        if (currentCountry === 'india') {
            if (!popupShown) {

                const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();

                document.getElementById('popupDismiss').addEventListener('click', function () {
                    this.disabled = true;
                    this.style.cursor = 'not-allowed';
                    // Save preferences and reload
                    localStorage.setItem('currency_popup_shown', 'true');
                    localStorage.setItem('preferred_currency', 'inr');
                    location.reload(); // force reload to let backend render INR
                });
            } else {
        
            }
        } else {
            // Outside India - always show USD
            localStorage.setItem('preferred_currency', 'usd');
    
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const closeButton = document.getElementById('close-notification');
        const bar = document.getElementById('notification-bar');

        closeButton.addEventListener('click', function() {
        // Smooth close by transitioning max-height and opacity
        bar.style.maxHeight = '0';
        bar.style.opacity = '0';
        setTimeout(() => {
            bar.style.display = 'none';
        }, 400); // wait for the transition to finish
        });
    });

    function toggleSubcategories(id) {
        // Remove active class from all categories and subcategories
        document.querySelectorAll('.category-item').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.sub-list a').forEach(el => el.classList.remove('active'));

        // Add active class to selected category
        const catItem = document.querySelector(`.category-item[data-subid="${id}"]`);
        if (catItem) catItem.classList.add('active');

        // Hide all subcategory lists
        document.querySelectorAll('.sub-list').forEach(el => el.classList.add('d-none'));

        // Show selected category's subcategory list
        const activeSubList = document.getElementById('sub-' + id);
        if (activeSubList) {
            activeSubList.classList.remove('d-none');
            activeSubList.style.display = 'flex';
        }

        // Find the selected category from productsData
        const selectedCategory = productsData.find(cat => cat.id === id);
        if (!selectedCategory || !selectedCategory.subcategories || selectedCategory.subcategories.length === 0) {
            document.getElementById('productsPanel').innerHTML = '<p>No products found.</p>';
            return;
        }

        // Auto-select and show products for first subcategory
        const firstSubcategory = selectedCategory.subcategories[0];
        const subAnchor = document.querySelector(`.sub-list a[data-cat="${id}"][data-sub="${firstSubcategory.id}"]`);
        if (subAnchor) subAnchor.classList.add('active');

        showProducts(id, firstSubcategory.id);
    }

    function openDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.add('dropdown-visible');

        const firstCategory = productsData[0];
        if (!firstCategory || !firstCategory.subcategories || firstCategory.subcategories.length === 0) return;

        // Remove active classes
        document.querySelectorAll('.category-item').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.sub-list a').forEach(el => el.classList.remove('active'));

        // Add active to first category
        const firstCategoryElement = document.querySelector(`.category-item[data-subid="${firstCategory.id}"]`);
        if (firstCategoryElement) {
            firstCategoryElement.classList.add('active');
        }

        // Show first category's subcategory list
        document.querySelectorAll('.sub-list').forEach(el => el.classList.add('d-none'));
        const firstSubList = document.getElementById('sub-' + firstCategory.id);
        if (firstSubList) {
            firstSubList.classList.remove('d-none');
            firstSubList.style.display = 'flex';
        }

        // Show first subcategory's products and highlight it
        const firstSubcategory = firstCategory.subcategories[0];
        if (firstSubcategory) {
            const firstSubAnchor = document.querySelector(`.sub-list a[data-cat="${firstCategory.id}"][data-sub="${firstSubcategory.id}"]`);
            if (firstSubAnchor) firstSubAnchor.classList.add('active');

            showProducts(firstCategory.id, firstSubcategory.id);
        } else {
            document.getElementById('productsPanel').innerHTML = '<p>No products found.</p>';
        }
    }

    function closeDropdown() {
        document.getElementById('dropdownMenu').classList.remove('dropdown-visible');
    }
</script>

<script>
    const assetBasePath = "{{ asset('public/storage/items_files') }}/";
</script>
<script>
    const productsData = @json($headerCategories);
</script>
<script>
    
    function showProducts(catId, subId) {
        const productsPanel = document.getElementById('productsPanel');
        const currency = localStorage.getItem('preferred_currency');
        productsPanel.innerHTML = '';

        const category = productsData.find(cat => cat.id === catId);
        if (!category) return;

        // Remove active class from all subcategories
        document.querySelectorAll('.sub-list a').forEach(a => a.classList.remove('active'));

        // Add active class to selected subcategory
        const selectedSub = document.querySelector(`.sub-list a[data-cat="${catId}"][data-sub="${subId}"]`);
        if (selectedSub) selectedSub.classList.add('active');

        const matchedItems = category.items.filter(item => item.subcategory_id === subId);

        if (matchedItems.length === 0) {
            productsPanel.innerHTML = '<p>No products found.</p>';
            return;
        }

        matchedItems.forEach(item => {
            if (item.item) {
                const product = item.item;
                const img = assetBasePath + product.thumbnail_image;

                const el = document.createElement('div');
                el.classList.add('product-card');
                let priceText = 'N/A';
                if (product.pricing) {
                    if (currency === 'inr') {
                        priceText = `₹${product.pricing.sales_inr_price} `;
                    } else {
                        priceText = `$${product.pricing.sale_price}`;
                    }
                }

                el.innerHTML = `
                    <a href="/product-details/${product.id}">
                        <img src="${img}" alt="${product.name}" class="product-image">
                    </a>
                    <a href="/product-details/${product.id}">
                        <div class="product-name">${product.name}</div>
                    </a>
                    <div class="product-price">
                        ${priceText}
                    </div>
                `;

                productsPanel.appendChild(el);
            }
        });
    }
</script>


<script>
    function toggleMobileCategoryList() {
        const list = document.getElementById('mobile-category-list');
        const arrow = document.getElementById('main-cat-arrow');
        if (!list) return;

        const isVisible = list.classList.contains('show');
        list.classList.toggle('show');
        list.classList.add('transition-collapse');

        if (arrow) arrow.textContent = isVisible ? '▶' : '▼';
    }
    function toggleMobileSubcategories(catId) {
        const subList = document.getElementById('mobile-sub-' + catId);
        const arrow = document.getElementById('cat-arrow-' + catId);

        const isAlreadyVisible = subList && subList.classList.contains('show');

        // Hide all others
        document.querySelectorAll('.mobile-sub-list').forEach(el => {
            el.classList.remove('show');
            el.classList.add('transition-collapse');
        });
        document.querySelectorAll('[id^="cat-arrow-"]').forEach(el => el.textContent = '▶');

        if (isAlreadyVisible) {
            if (arrow) arrow.textContent = '▶';
            return;
        }

        const cat = productsData.find(c => c.id === catId);
        if (!cat || !cat.subcategories || cat.subcategories.length === 0) return;

        if (subList && subList.children.length === 0) {
            let html = '';
            cat.subcategories.forEach(sub => {
                html += `
                    <li>
                        <a href="javascript:void(0);"
                        class="mobile-sub-toggle d-flex justify-content-between align-items-center py-1"
                        onclick="toggleMobileProducts(${catId}, ${sub.id})">
                            <span>${sub.name}</span>
                            <span id="sub-arrow-${catId}-${sub.id}">▶</span>
                        </a>
                        <div class="mobile-products-list transition-collapse" id="mobile-products-${catId}-${sub.id}"></div>
                    </li>
                `;
            });
            subList.innerHTML = html;
        }

        subList.classList.add('transition-collapse', 'show');
        if (arrow) arrow.textContent = '▼';
    }



    function toggleMobileProducts(catId, subId) {
        const container = document.getElementById(`mobile-products-${catId}-${subId}`);
        const arrow = document.getElementById(`sub-arrow-${catId}-${subId}`);

        const isAlreadyVisible = container && container.classList.contains('show');

        document.querySelectorAll('.mobile-products-list').forEach(el => {
            el.classList.remove('show');
            el.classList.add('transition-collapse');
        });
        document.querySelectorAll('[id^="sub-arrow-"]').forEach(el => el.textContent = '▶');

        if (isAlreadyVisible) {
            if (arrow) arrow.textContent = '▶';
            return;
        }

        const category = productsData.find(cat => cat.id === catId);
        if (!category) return;

        const matchedItems = category.items.filter(item => item.subcategory_id === subId);
        if (!matchedItems.length) {
            container.innerHTML = '<p>No products found.</p>';
            container.classList.add('transition-collapse', 'show');
            if (arrow) arrow.textContent = '▼';
            return;
        }

        const currency = localStorage.getItem('preferred_currency');

        if (container.children.length === 0) {
            let html = '<ul class="mobile-product-list-items" style="padding-left: 0;">';
            matchedItems.forEach(item => {
                const product = item.item;
                if (product) {
                    let price = 'N/A';
                    if (product.pricing) {
                        if (currency === 'inr') {
                            price = `₹${product.pricing.sales_inr_price}`;
                        } else {
                            price = `$${product.pricing.sale_price}`;
                        }
                    }
                    // const price = product.pricing ? `${product.pricing.fixed_price} ${product.currency}` : 'N/A';
                    const img = assetBasePath + product.thumbnail_image;
                    html += `
                        <li style="list-style: none; margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                            <a href="/product-details/${product.id}">
                                <img src="${img}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </a>
                            <div style="flex: 1;">
                                <a href="/product-details/${product.id}" style="text-decoration: none; color: #000;">
                                    <div style="font-weight: 500;">${product.name}</div>
                                </a>
                                <div style="color: #888; font-size: 14px;">${price}</div>
                            </div>
                        </li>
                    `;
                }
            });
            html += '</ul>';
            container.innerHTML = html;
        }

        container.classList.add('transition-collapse', 'show');
        if (arrow) arrow.textContent = '▼';
    }



</script>