<a href="{{$cancelUrl ?? '#'}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
<div class="btn-group dropdown float-right">
    <button type="submit" class="btn btn-outline-primary erp-pili-edit-form">
        Save
    </button>
    @if($module ?? '')
        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split _r_drop_right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" x-placement="right-start">
            <a class="dropdown-item" href="{{$printUrl ?? '#'}}" target="__blank">Print</a>
        </div>
    @endif
</div>
