@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
<!-- Footer Start -->
<div class="flex-grow-1"></div>
<div class="app-footer">
    <div class="row">
        <p><strong>{{$site["value"]["site_name"] ?? "Infinity"}} {{\Carbon\Carbon::now()->year}} All rights reserved</strong></p>
    </div>
</div>
<!-- fotter end -->
