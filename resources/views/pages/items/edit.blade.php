@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $item ? 'Edit: '.$item->id : 'New'}}</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!--  FOR LOCAL -->
   <!--  <script src="https://cdn.tiny.cloud/1/o7h5fdpvwna0iulbykb99xeh6i53zmtdyswqphxutmkecio6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->

   <!--  FOR LIVE -->
    <script src="https://cdn.tiny.cloud/1/ccs0n7udyp8c417rnmljbdonwhsg4b8v61la4t8s2eiyhk5q/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    {{-- <script>
        tinymce.init({
            selector: 'textarea#html_description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tableofcontents footnotes autocorrect inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
            init_instance_callback: function(editor) {
                editor.on('keyup', function(e) {
                    $(document).find('textarea').removeClass('is-invalid');
                    $('textarea').closest(".form-group").find('.error').text("");
            });
            }
        });
    </script> --}}
@endsection
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .image-input, .file-input{
        display:none;
    }
    .filelabel{
        height: auto;
        margin-bottom:0;
    }
    .previewImgCls{
        width: 50px;
        height: 50px;
        margin: 0 20px;
        object-fit: scale-down!important;
        transition: transform .2s;
        position: relative;
    }
    .previewImgCls:hover{
        transform: scale(5.0);
        border-radius: 2px;
        z-index: 1;
    }
    .previewImgCls{
        display: none;
    }
    /* .remove-btn {
        background-color: rgb(244, 67, 54);
        color: #fff;
        font-size: 27px;
        border-radius: 5px;
        text-align: center;
        width: 45px;
        line-height: 0;
        padding: 16px 0;
        margin-left: 30px;
        cursor: pointer;
    } */

    .select2-container .select2-selection--single {
        padding-bottom: 2px;
        padding-top: 2px;
        height: unset;
    }
</style>
@endsection
@section('main-content')
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('items-index')}}">Item</a> | Item {{ $item ? 'Edit: '.$item->name : 'New'}} </a>
        @if ($isshow == false)
            <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
            <div class="btn-group dropdown float-right">
                <button type="submit" class="btn btn-outline-primary erp-item-form">
                    Save
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    @if ($isshow == true)
        <div class="col-md-9 mx-auto">
            <div class="card mb-3" style="background-color: #eee;">
                <div class="card-body">
                    <form action="{{ route('items.type.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                    <div class="mb-3">
                                        <h4>Select Item Type</h4>
                                        <select class="form-control select2" id="item_type" name="item_type" required>
                                            <option value="">Select Plan Type</option>
                                            <option value="one-time">One-Time Payment</option>
                                            <option value="recurring">Recurring Payment</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div d-none d-lg-flex>
                                <div class="vr" style="height: 79%; width:0.1%; background-color: #ddd; position: absolute;"></div>
                            </div>
                            <div class="col-lg-8 col-12">
                                    <h5>Need Help Selecting an Item Type?</h5>
                                    <p><span style="font-weight: bold;">One-Time Payment:</span> If you choose One-Time Payment, the user will pay a single amount to purchase the item. The item will have lifetime validity or the validity period you have set.</p>
                                    <p><span style="font-weight: bold;">Recurring Payment:</span> If you choose Recurring Payment, the user will be required to pay a fixed amount at regular intervals. If the user fails to make the payment, the item will automatically expire.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-8">
        @if ($isshow == false)
            @if($item)
                <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h4 class="heading-color">Item</h4>
                            <input type="hidden" id="item_id" class="erp-id" value="{{$itemid}}" name="item_id" />
                            <input type="hidden" id="item_id_type" class="erp-id" value="old" name="item_id_type" />
                            <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="name">Name</label>
                                        <input placeholder="Enter Item Name" class="form-control input-error" id="item_name" name="name" type="text" value="{{ $item->name }}">
                                        <div class="error" style="color:red;" id="name_error"></div>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Preview URL</label>
                                        <input placeholder="Include http:// or https:// in the URL" class="form-control" id="item_preview_url" name="preview_url" type="url" value="{{ $item->preview_url }}" pattern= 'https?://.*'>
                                        <div class="error" style="color:red;" id="preview_url_error"></div>
                                    </div>
                                    <div class="col-6 form-group input-file-col">
                                        <label>Item Thumbnail</label>
                                        <?php $showImagePrev = (!empty($item->thumbnail_image)) ? 'display:inline-block' : ''; ?>
                                        <label id="item_thumbnail_label" class="form-control filelabel image-input-label">
                                            <input type="hidden" name="old_thumbnail_image" value="@if(!empty($item->thumbnail_image)){{$item->thumbnail_image}}@endif">
                                            <input type="file" name="item_thumbnail" id="item_thumbnail"  class="image-input form-control input-error">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="item_thumbnail_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($item->thumbnail_image)){{asset('storage/items_files/'.$item->thumbnail_image)}}@endif" data-title="previewImgCls" style="{{$showImagePrev}}">
                                            <span class="title" id="item_thumbnail_title" data-title="title">{{ $item->thumbnail_image ??  ''}}</span>
                                        </label>
                                        <div class="error" style="color:red;" id="item_thumbnail_error"></div>
                                    </div>
                                    <div class="col-6 form-group input-file-col">
                                        <label>Main file</label>
                                        <label id="item_main_file_label" class="form-control filelabel file-input-label">
                                            <input type="hidden" name="old_main_file" value="@if(!empty($item->main_file_zip)){{$item->main_file_zip}}@endif">
                                            <input type="file" name="item_main_file" id="item_main_file"  accept=".zip"  class="form-control file-input">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <span class="title" id="item_files_title"  data-title="title">{{ $item->main_file_zip ??  ''}}</span>
                                        </label>
                                        <div class="error" style="color:red;" id="zip_file_error"></div>
                                    </div>
                                    <div class="col-md-12 form-group mb-4">
                                        <label>Description</label>
                                        <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$item->html_description!!}</div>
                                        <input type="hidden" name="html_description" id="html_description" value="{{$item->html_description}}">
                                        <div class="error" style="color:red;" id="description_error"></div>
                                    </div>
                                    @if ($type !== 'recurring')
                                        <div class="col-md-12 form-group add-more-input">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="key_feature_label">Features</label>
                                                </div>
                                                <div class="col-6 text-right">
                                                <button type="button" class="btn btn-outline-primary mb-3" id="add-feature" data-value="one-time">Add Feature</button>
                                                </div>
                                            </div>
                                            <div class="add-more-wrapper feature-input-wrapper">
                                                @foreach($item->features as $feature)
                                                    <div class="row input-row feature-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                                        <div class="col-11">
                                                            <input placeholder="Enter key feature" class="form-control mb-3" id="key_feature" name="key_feature[]" type="text" value="{{ $feature->key_feature }}">
                                                        </div>
                                                        <div class="col-1"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="error" style="color:red;" id="feature_error"></div>
                                        </div>
                                        <div class="col-md-12 form-group input-file-col add-more-input">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Images</label>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-outline-primary mb-3" id="add-image" data-value="one-time">Add Image</button>
                                                </div>
                                            </div>
                                            <div class="add-more-wrapper image-input-wrapper">
                                                @foreach($item->images as $image)
                                                    <?php $showImagePrev = (!empty($image->image_path)) ? 'display:inline-block' : ''; ?>
                                                    <div class="row input-row image-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                                        <div class="col-11">
                                                            <label class="form-control filelabel mb-3 image-input-label">
                                                                <input type="hidden" name="old_image[]" value="@if(!empty($image->image_path)){{$image->image_path}}@endif">
                                                                <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control">
                                                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                                <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($image->image_path)){{asset('storage/items_files/'.$image->image_path)}}@endif" data-title="previewImgCls" style="{{$showImagePrev}}">
                                                                <span class="title" id="item_images_title" data-title="title">{{ $image->image_path ??  ''}}</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-1"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="error" style="color:red;" id="image_error"></div>
                                        </div>
                                    @endif

                                    <div class="col-md-12 col-12 form-group licensevaliditycontainer" id="licensevaliditycontainer" style="display: none;">
                                        <label for="">License Validity</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="licenseradio" [value]="1" formcontrolname="radio" id="licensevalidityradio" value="lifetime" {{$item->pricing->validity == 'Lifetime' ? 'checked' : ''}}>
                                            <span>Lifetime</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="licenseradio" [value]="1" formcontrolname="radio" id="licensevalidityradio" value="expirydate" {{$item->pricing->validity != 'Lifetime' ? 'checked' : ''}}>
                                            <span>Expiry Date</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div id="expirydatecontainer" @if($item->pricing->validity == 'Lifetime') style="display: none;" @endif>
                                            <label for="expiryDate">Select Expiry Date</label>
                                            <input type="date" class="form-control" name="expiryDate" id="expiryDate" value="{{ $item->pricing->expiry_date }}">
                                        </div>
                                        <input type="text" name="licensevaluetext" class="licensevaluetext" style="display:none">
                                    </div>
                            </div>
                        </div>
                    </div>

                    @if ($type !== 'recurring')
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <div class="col-md-12 form-group">
                                    <h5>Pricing</h5>
                                    <div class="row">
                                        @php
                                        $fixed_price = isset($item->pricing->fixed_price) ? floatval($item->pricing->fixed_price) : 0;
                                        $sale_price = isset($item->pricing->sale_price) ? floatval($item->pricing->sale_price) : 0;
                                        $gst_percentage = isset($item->pricing->gst_percentage) ? floatval($item->pricing->gst_percentage) : 0;

                                        $gst_amount = ($sale_price * $gst_percentage) / 100;

                                        $gst_amount_formatted = number_format($gst_amount, 2);
                                        @endphp
                                        <div class="col-md-12 mt-2 mb-2">
                                            <label for="fixed_price">Enter fixed price</label>
                                            {!! Form::number('fixed_price', $item->pricing->fixed_price, array('placeholder' => 'Enter fixed price','class' => 'form-control input-error price-input' , 'id' => 'item_fixed_price')) !!}
                                            <div class="error" style="color:red;" id="fixed_price_error"></div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2">
                                            <label for="sale_price">Enter Sale Price</label>
                                            {!! Form::number('sale_price', $item->pricing->sale_price, array('placeholder' => 'Enter sale price','class' => 'form-control input-error price-input' , 'id' => 'item_sale_price')) !!}
                                            <div class="error" style="color:red;" id="sale_price_error"></div>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-2">
                                            <label for="gst_percentage">Enter GST %</label>
                                            {!! Form::number('gst_percentage', $item->pricing->gst_percentage, array('placeholder' => 'Enter GST %','class' => 'form-control input-error price-input' , 'id' => 'item_gst_percentage')) !!}
                                            <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                            <div class="gst-amount" id="gst_amount">GST Amount: <strong><span>{{ $gst_amount_formatted }}</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            @else
                <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="item_id">
                    <div class="card">
                        <div class="card-body mb-3">
                            {{-- <input type="hidden" id="item_id" class="erp-id" name="item_id" value="0" /> --}}
                            <input type="hidden" id="item_id" class="erp-id" value="{{$itemid}}" name="item_id" />
                            <input type="hidden" id="item_id_type" class="erp-id" value="new" name="item_id_type" />
                            <input type="hidden" name="status" value="1">
                            <div class="row">
                                <div class="col-6 form-group">
                                        <label for="name_label">Name</label>
                                        {!! Form::text('name', null, array('placeholder' => 'Enter Item Name','class' => 'form-control input-error' , 'id' => 'name')) !!}
                                        <div class="error" style="color:red;" id="name_error"></div>
                                </div>
                                <div class="col-6 form-group">
                                        <label for="preview_url_label">Preview URL</label>
                                        {!! Form::url('preview_url', null, ['placeholder' => 'Include http:// or https:// in the URL', 'class' => 'form-control', 'id' => 'item_preview_url', 'title' => 'Include http:// or https:// in the URL', 'pattern' => 'https?://.*']) !!}
                                        <div class="error" style="color:red;" id="preview_url_error"></div>
                                </div>
                                <div class="col-6 form-group input-file-col">
                                        <label for="item_thumbnail_label">Item Thumbnail</label>
                                        <label id="item_thumbnail_label" class="form-control filelabel image-input-label">
                                            <input type="file" name="item_thumbnail" id="item_thumbnail"  class="image-input form-control input-error">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="item_thumbnail_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                            <span class="title" id="item_thumbnail_title" data-title="title"></span>
                                        </label>
                                        <div class="error" style="color:red;" id="item_thumbnail_error"></div>
                                </div>
                                <div class="col-6 form-group input-file-col">
                                        <label for="item_main_file_label">Main file</label>
                                        <label id="item_main_file_label"  class="form-control filelabel file-input-label">
                                            <input type="file" name="item_main_file" id="item_main_file"  accept=".zip"  class="form-control file-input">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <span class="title" id="item_files_title"  data-title="title"></span>
                                        </label>
                                        <div class="error" style="color:red;" id="zip_file_error"></div>
                                </div>
                                <div class="col-md-12 form-group mb-4">
                                        <label for="html_description_label">Description</label>
                                        <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                                        <input type="hidden" name="html_description" id="html_description">
                                        <div class="error" style="color:red;" id="description_error"></div>
                                </div>
                                @if ($type !== 'recurring')
                                    <div class="col-md-12 form-group add-more-input">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="key_feature_label">Features</label>
                                                </div>
                                                <div class="col-6 text-right">
                                                <button type="button" class="btn btn-outline-primary mb-3" id="add-feature" data-value="one-time">Add Feature</button>
                                                </div>
                                            </div>
                                            <div class="add-more-wrapper feature-input-wrapper">
                                                <div class="row input-row feature-input-row mt-3" data-order='1'>
                                                    <div class="col-12">
                                                        {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="error" style="color:red;" id="feature_error"></div>
                                    </div>
                                    <div class="col-md-12 form-group input-file-col add-more-input">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="item_images_label">Images</label>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-outline-primary mb-3" id="add-image" data-value="one-time">Add Image</button>
                                                </div>
                                            </div>
                                            <div class="add-more-wrapper image-input-wrapper">
                                                <div class="row input-row image-input-row mt-3" data-order='1'>
                                                    <div class="col-12">
                                                        <label class="form-control filelabel mb-3 image-input-label">
                                                            <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error">
                                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                            <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                                            <span class="title" id="item_images_title" data-title="title"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error" style="color:red;" id="image_error"></div>
                                            </div>
                                    </div>
                                @endif

                                <div class="col-md-12 col-12 form-group licensevaliditycontainer" id="licensevaliditycontainer" style="display: none;">
                                        <label for="">License Validity</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="radio" formcontrolname="radio" id="licensevalidityradio" value="lifetime">
                                            <span>Lifetime</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="radio" formcontrolname="radio" id="licensevalidityradio" value="expirydate">
                                            <span>Expiry Date</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div id="expirydatecontainer" style="display: none;">
                                            <label for="expiryDate">Select Expiry Date</label>
                                            <input type="date" class="form-control" name="expiryDate" id="expiryDate">
                                        </div>
                                        <input type="text" name="licensevaluetext" class="licensevaluetext" style="display:none">
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($type !== 'recurring')
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <div class="col-md-12 form-group">
                                    <h5>Pricing</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="fixed_price">Enter Fixed Price</label>
                                            {!! Form::number('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control price-input input-error' , 'id' => 'item_fixed_price')) !!}
                                            <div class="error" style="color:red;" id="fixed_price_error"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="sale_price">Enter Sale Price</label>
                                            {!! Form::number('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control price-input input-error' , 'id' => 'item_sale_price')) !!}
                                            <div class="error" style="color:red;" id="sale_price_error"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="gst_percentage">Enter GST %</label>
                                            {!! Form::number('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control price-input input-error' , 'id' => 'item_gst_percentage')) !!}
                                            <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                            <div class="gst-amount" id="gst_amount"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            @endif
        @endif
    </div>
    @if ($isshow == false)
        <div class="col-md-4 mt-1">
            @if ($item)
            <form class="erp-item-submit" id="item_form1" data-url="{{route('items-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label for="item_status" class="">Item status:</label>
                            <div class="ul-form__radio-inline">
                                <label class=" ul-radio__position radio radio-primary form-check-inline">
                                    <input type="radio" name="status" value="1" <?php if($item->status == 1){echo 'checked="checked"';} ?>>
                                    <span class="ul-form__radio-font">Active</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="ul-radio__position radio radio-primary">
                                    <input type="radio" name="status" value="0" <?php if($item->status == 0){echo 'checked="checked"';} ?>>
                                    <span class="ul-form__radio-font">Inactive</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="error" style="color:red;" id="status_error"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0px;">
                        <h5 for="item_type" class="">Item Type Selection</h5>
                        <div class="row">
                            <div class="col-lg-5 col-12">
                                <select class="form-control select2" id="item_type" name="item_type" required>
                                    <option value="one-time" {{$type=='one-time' ? 'selected' : ''}}>One-Time Payment</option>
                                    <option value="recurring" {{$type=='recurring' ? 'selected' : ''}}>Recurring Payment</option>
                                </select>
                            </div>
                            <div d-none d-lg-flex>
                                <div class="vr" style="height: 79%; width:0.1%; background-color: #ddd; position: absolute;"></div>
                            </div>
                            <div class="col-lg-7 col-12">
                                    <h5>Need Help Selecting an Item Type?</h5>
                                    <p><span style="font-weight: bold;">One-Time Payment:</span> If you choose One-Time Payment, the user will pay a single amount to purchase the item. The item will have lifetime validity or the validity period you have set.</p>
                                    <p><span style="font-weight: bold;">Recurring Payment:</span> If you choose Recurring Payment, the user will be required to pay a fixed amount at regular intervals. If the user fails to make the payment, the item will automatically expire.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 mb-2">
                        <div class="row p-4">
                            <div class="col-md-12 form-group">
                                <label for="category_label">Category</label>
                                {!! Form::select('category_id', ['' => 'Select category'] + $categories, $item->categorySubcategory->category_id, ['class' => 'form-control select-input category-select', 'id' => 'category_id']) !!}
                                <div class="error" style="color:red;" id="category_error"></div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="subcategory_label">Sub category</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control subcategory-select select-input">
                                    <option value="">Select sub category</option>
                                    @foreach($subcategories as $subcategory)
                                        @if($subcategory->category_id == $item->categorySubcategory->category_id)
                                            <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}" {{ $item->categorySubcategory->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @else
                                            <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}" class="d-none">{{ $subcategory->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="error" style="color:red;" id="subcategories_error"></div>
                            </div>
                        </div>
                </div>
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <div class="col-md-12 form-group">
                            <label for="tags_label">Tags</label>
                            <div data-no-duplicate="true" data-pre-tags-separator="\n" data-no-duplicate-text="Duplicate tags" data-type-zone-class="type-zone" data-tag-box-class="tagging" data-edit-on-delete="false" class="tag_input">
                                @foreach($item->tags as $index => $tag)
                                @if($index > 0) \n @endif{{ $tag->tag_name }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <div class="col-md-12 form-group">
                            <label for="trial_label">Trial Days</label>
                            <input type="number" class="form-control" id="trial_days" name="trial_days" placeholder="Enter number of trial days" value="{{ old('trial_days', $item->trial_days) }}">
                        </div>
                    </div>
                </div>
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <div class="col-md-12 form-group">
                            <label for="currency_label">Currency</label>
                            <input type="text" class="form-control" id="currency" name="currency" placeholder="Enter currency" value="{{ old('currency', $item->currency) }}">
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0px;">
                        <h5 for="item_type" class="form-label">Item Type Selection</h5>
                        <div class="row">
                            <div class="col-lg-5 col-12">
                                <select class="form-control select2" id="item_type" name="item_type" required>
                                    <option value="one-time" {{$type=='one-time' ? 'selected' : ''}}>One-Time Payment</option>
                                    <option value="recurring" {{$type=='recurring' ? 'selected' : ''}}>Recurring Payment</option>
                                </select>
                            </div>
                            <div d-none d-lg-flex>
                                <div class="vr" style="height: 79%; width:0.1%; background-color: #ddd; position: absolute;"></div>
                            </div>
                            <div class="col-lg-7 col-12">
                                    <h5>Need Help Selecting an Item Type?</h5>
                                    <p><span style="font-weight: bold;">One-Time Payment:</span> If you choose One-Time Payment, the user will pay a single amount to purchase the item. The item will have lifetime validity or the validity period you have set.</p>
                                    <p><span style="font-weight: bold;">Recurring Payment:</span> If you choose Recurring Payment, the user will be required to pay a fixed amount at regular intervals. If the user fails to make the payment, the item will automatically expire.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="erp-item-submit" id="item_form1" data-url="{{route('items-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="row p-4">
                                <div class="col-md-12 form-group">
                                    <label for="category_label">Category</label>
                                    {!! Form::select('category_id', ['' => 'Select category'] + $categories, null, ['class' => 'form-control select-input category-select', 'id' => 'category_id']) !!}
                                    <div class="error" style="color:red;" id="category_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="subcategory_label">Sub category</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control subcategory-select select-input">
                                        <option value="">Select sub category</option>
                                    <!--  @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}" class="d-none">{{ $subcategory->name }}</option>
                                        @endforeach -->
                                    </select>
                                    <div class="error" style="color:red;" id="subcategories_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label for="tags_label">Tags</label>
                                <div data-no-duplicate="true" data-pre-tags-separator="\n" data-no-duplicate-text="Duplicate tags" data-type-zone-class="type-zone" data-tag-box-class="tagging" data-edit-on-delete="false" class="tag_input"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label for="trial_label">Trial Days</label>
                                <input type="number" class="form-control" id="trial_days" name="trial_days" placeholder="Enter number of trial days" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label for="currency_label">Currency</label>
                                <input type="text" class="form-control" id="currency" name="currency" placeholder="Enter currency" required>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    @endif

    @php
    use App\Models\ItemsPricing;
    use App\Models\ItemsFeature;
    use App\Models\ItemsImage;
    $subItem = ItemsPricing::where('item_id', $itemid)->where('pricing_type','recurring')->get();
    $subfeature = ItemsFeature::where('item_id',$itemid)->where('sub_id','!=',null)->get();
    $subimage = ItemsImage::where('item_id',$itemid)->where('sub_id','!=',null)->get();
@endphp

@if ($isshow == false && $type == 'recurring')
<div class="row mt-2 w-100">
    <div class="col-md-12 form-group text-right" style="display: flex; justify-content:end; align-items:center;">
        <button type="button" class="btn btn-outline-primary addrecurringcardbtn" id="addrecurringcardbtn">Add Billing Card</button>
    </div>
</div>

<div class="col-lg-12 col-12">
<div class="addrecurringcardoption row" id="addrecurringcardoption" style="display: none;">
    <div class="col-lg-4 col-12">
        <form class="erp-item-submit" id="item_form2" data-url="{{route('items-store')}}" data-id="item_id">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="col-md-12 form-group add-more-input">
                        <div class="row">
                            <div class="col-6">
                                <h5>Features</h5>
                            </div>
                            <div class="col-6 text-right">
                            <button type="button" class="btn btn-outline-primary mb-3" id="add-feature" data-value="recurring">Add Feature</button>
                            </div>
                        </div>

                        <div class="add-more-wrapper feature-input-wrapper">
                            @if (!empty($item) && count($item->features ?? []) != 0)
                                @foreach($item->features as $feature)
                                    @if ($feature->sub_id == null)
                                        <div class="row input-row feature-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                            <div class="col-10">
                                                <input placeholder="Enter key feature" class="form-control mb-3" id="key_feature" name="key_feature[]" type="text" value="{{ $feature->key_feature }}">
                                            </div>
                                            <div class="col-2"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="row input-row feature-input-row mt-3" data-order='1'>
                                    <div class="col-12">
                                        {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="error" style="color:red;" id="feature_error"></div>
                    </div>
                    <div class="col-md-12 form-group input-file-col add-more-input">
                        <div class="row">
                            <div class="col-6">
                                <h5>Images</h5>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-outline-primary mb-3" id="add-image" data-id="recurring" data-value="recurring">Add Image</button>
                            </div>
                        </div>
                        <div class="add-more-wrapper image-input-wrapper">
                            @if (!empty($item) && count($item->images ?? []) != 0)
                                @foreach($item->images as $image)
                                    @if ($image->sub_id == null)
                                        <?php $showImagePrev = (!empty($image->image_path)) ? 'display:inline-block' : ''; ?>
                                        <div class="row input-row image-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                            <div class="col-10">
                                                <label class="form-control filelabel mb-3 image-input-label">
                                                    <input type="hidden" name="old_image[]" value="@if(!empty($image->image_path)){{$image->image_path}}@endif">
                                                    <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control">
                                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                    <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($image->image_path)){{asset('storage/items_files/'.$image->image_path)}}@endif" data-title="previewImgCls" style="{{$showImagePrev}}">
                                                    <span class="title" id="item_images_title" data-title="title">{{ $image->image_path ??  ''}}</span>
                                                </label>
                                            </div>
                                            <div class="col-2"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="error" style="color:red;" id="image_error"></div>
                            @else
                                <div class="row input-row image-input-row mt-3" data-order='1'>
                                    <div class="col-12">
                                        <label class="form-control filelabel mb-3 image-input-label">
                                            <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                            <span class="title" id="item_images_title" data-title="title"></span>
                                        </label>
                                        <div class="error" style="color:red;" id="image_error"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 form-group billingcyclecontainer" id="billingcyclecontainer" style="display: none;">
                        <h5>Billing Cycle</h5>
                        <select name="itembillingcycle" id="itembillingcycle" class="form-control itembillingcycle select2" style="width: 100%;">
                            <option value="monthly" {{ isset($item->pricing->billing_cycle) && $item->pricing->billing_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ isset($item->pricing->billing_cycle) && $item->pricing->billing_cycle == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="yearly" {{ isset($item->pricing->billing_cycle) && $item->pricing->billing_cycle == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            <option value="custom" {{ isset($item->pricing->billing_cycle) && $item->pricing->billing_cycle == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    @if (!empty($item) && !empty($item->pricing) && $item->pricing->billing_cycle == 'custom')
                        <div class="col-md-12 form-group customBillingCycleContainer" id="customBillingCycleContainer">
                            <h5>Custom Billing Cycle</h5>
                            <input type="text" name="custombillingcycle" id="custombillingcycle" placeholder="Enter Custom Billing Cycle" class="form-control" value="{{$item->pricing->custom_cycle_days ?? ''}}">
                        </div>
                    @else
                        <div class="col-md-12 form-group customBillingCycleContainer" id="customBillingCycleContainer" style="display: none;">
                            <h5>Custom Billing Cycle</h5>
                            <input type="text" name="custombillingcycle" id="custombillingcycle" placeholder="Enter Custom Billing Cycle" class="form-control">
                        </div>
                    @endif
                    <div class="col-md-12 col-12 form-group autorenewalcontainer" id="autorenewalcontainer" style="display: none;">
                        <h5>Auto Renewal</h5>
                        <label class="switch switch-primary me-3">
                            <input type="checkbox" {{ isset($item->pricing->auto_renew) && $item->pricing->auto_renew == 1 ? 'checked' : '' }} name="autorenewalcheckbox" id="autorenewalcheckbox" style="display: none;">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="col-md-12 col-12 form-group graceperiodcontianer" id="graceperiodcontianer">
                        <h5>Grace Period</h5>
                        <input type="text" name="graceperiod" id="graceperiod" class="form-control" value="{{$item->pricing->grace_period ?? ''}}">
                    </div>
                    <div class="col-md-12 form-group" id="testcontainer">
                        <h5>Pricing</h5>
                        @if (!empty($item) && !empty($item->pricing) && $item->pricing->fixed_price)
                            <div class="row">
                                @php
                                $fixed_price = isset($item->pricing->fixed_price) ? floatval($item->pricing->fixed_price) : 0;
                                $sale_price = isset($item->pricing->sale_price) ? floatval($item->pricing->sale_price) : 0;
                                $gst_percentage = isset($item->pricing->gst_percentage) ? floatval($item->pricing->gst_percentage) : 0;

                                $gst_amount = ($sale_price * $gst_percentage) / 100;

                                $gst_amount_formatted = number_format($gst_amount, 2);
                                @endphp
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('fixed_price', $item->pricing->fixed_price, array('placeholder' => 'Enter fixed price','class' => 'form-control input-error price-input' , 'id' => 'item_fixed_price')) !!}
                                    <div class="error" style="color:red;" id="fixed_price_error"></div>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('sale_price', $item->pricing->sale_price, array('placeholder' => 'Enter sale price','class' => 'form-control input-error price-input' , 'id' => 'item_sale_price')) !!}
                                    <div class="error" style="color:red;" id="sale_price_error"></div>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('gst_percentage', $item->pricing->gst_percentage, array('placeholder' => 'Enter GST %','class' => 'form-control input-error price-input' , 'id' => 'item_gst_percentage')) !!}
                                    <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                    <div class="gst-amount" id="gst_amount">GST Amount: <strong><span>{{ $gst_amount_formatted }}</span></strong></div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control price-input input-error' , 'id' => 'item_fixed_price')) !!}
                                    <div class="error" style="color:red;" id="fixed_price_error"></div>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control price-input input-error' , 'id' => 'item_sale_price')) !!}
                                    <div class="error" style="color:red;" id="sale_price_error"></div>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    {!! Form::number('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control price-input input-error' , 'id' => 'item_gst_percentage')) !!}
                                    <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                    <div class="gst-amount" id="gst_amount"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
    @foreach ($subItem as $subproduct)
        @if ($subproduct->sub_id !==null)
        <div class="col-lg-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="erp-item-submit" id="item_form" data-url="{{route('items-subitem-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                        <input type="hidden" name="sub_id" id="sub_id" value="{{$subproduct->sub_id}}">
                        <div class="col-md-12 form-group add-more-input">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Features</h5>
                                </div>
                                <div class="col-6 text-right">
                                <button type="button" class="btn btn-outline-primary mb-3" id="add-feature" data-value="recurring">Add Feature</button>
                                </div>
                            </div>
                            <div class="add-more-wrapper feature-input-wrapper">
                                @if ($subfeature->count()!=0)
                                    @foreach($subfeature as $feature)
                                        @if ($feature->sub_id == $subproduct->sub_id)
                                            <div class="row input-row feature-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                                <div class="col-10">
                                                    <input placeholder="Enter key feature" class="form-control mb-3" id="key_feature" name="key_feature[]" type="text" value="{{ $feature->key_feature }}">
                                                </div>
                                                <div class="col-2"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="row input-row feature-input-row" data-order='1'>
                                        <div class="col-12">
                                            {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="error" style="color:red;" id="feature_error"></div>
                        </div>
                        <div class="col-md-12 form-group input-file-col add-more-input">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Images</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-outline-primary mb-3" id="add-image" data-value="recurring">Add Image</button>
                                </div>
                            </div>
                            <div class="add-more-wrapper image-input-wrapper">
                                @if ($subimage->count()!=0)
                                    @foreach($subimage as $image)
                                        @if ($image->sub_id == $subproduct->sub_id)
                                            <?php $showImagePrev = (!empty($image->image_path)) ? 'display:inline-block' : ''; ?>
                                            <div class="row input-row image-input-row {{ $loop->first ? 'mt-3' : '' }}">
                                                <div class="col-10">
                                                    <label class="form-control filelabel mb-3 image-input-label">
                                                        <input type="hidden" name="old_image[]" value="@if(!empty($image->image_path)){{$image->image_path}}@endif">
                                                        <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control">
                                                        <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                        <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($image->image_path)){{asset('storage/items_files/'.$image->image_path)}}@endif" data-title="previewImgCls" style="{{$showImagePrev}}">
                                                        <span class="title" id="item_images_title" data-title="title">{{ $image->image_path ??  ''}}</span>
                                                    </label>
                                                </div>
                                                <div class="col-2"><div class="btn btn-outline-primary remove-btn">Delete</div></div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="row input-row image-input-row mt-3" data-order='1'>
                                        <div class="col-12">
                                            <label class="form-control filelabel mb-3 image-input-label">
                                                <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error">
                                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                                <span class="title" id="item_images_title" data-title="title"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group billingcyclecontainer" id="billingcyclecontainer" style="display: none;">
                            <h5>Billing Cycle</h5>
                            <select name="itembillingcycle" id="itembillingcycle" class="form-control itembillingcycle select2" style="width: 100%;">
                                <option value="monthly" {{ isset($subproduct->billing_cycle) && $subproduct->billing_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ isset($subproduct->billing_cycle) && $subproduct->billing_cycle == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="yearly" {{ isset($subproduct->billing_cycle) && $subproduct->billing_cycle == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="custom" {{ isset($subproduct->billing_cycle) && $subproduct->billing_cycle == 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>
                        @if ($subproduct->billing_cycle == 'custom')
                            <div class="col-md-12 form-group customBillingCycleContainer" id="customBillingCycleContainer">
                                <h5>Custom Billing Cycle</h5>
                                <input type="text" name="custombillingcycle" id="custombillingcycle" placeholder="Enter Custom Billing Cycle" class="form-control" value="{{$subproduct->custom_cycle_days ?? ''}}">
                            </div>
                        @else
                            <div class="col-md-12 form-group customBillingCycleContainer" id="customBillingCycleContainer" style="display: none;">
                                <h5>Custom Billing Cycle</h5>
                                <input type="text" name="custombillingcycle" id="custombillingcycle" placeholder="Enter Custom Billing Cycle" class="form-control">
                            </div>
                        @endif
                        <div class="col-md-12 col-12 form-group autorenewalcontainer" id="autorenewalcontainer" style="display: none;">
                            <h5 for="price_label">Auto Renewal</h5>
                            <label class="switch switch-primary me-3">
                                <input type="checkbox" {{ isset($subproduct->auto_renew) && $subproduct->auto_renew == 1 ? 'checked' : '' }} name="autorenewalcheckbox" id="autorenewalcheckbox" style="display: none;">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="col-md-12 col-12 form-group graceperiodcontianer" id="graceperiodcontianer">
                            <h5>Grace Period</h5>
                            <input type="text" name="graceperiod" id="graceperiod" class="form-control" value="{{$subproduct->grace_period ?? ''}}">
                        </div>
                        <div class="col-md-12 form-group">
                            <h5>Pricing</h5>
                            @if ($subproduct->fixed_price)
                                <div class="row">
                                    @php
                                    $fixed_price = isset($subproduct->fixed_price) ? floatval($subproduct->fixed_price) : 0;
                                    $sale_price = isset($subproduct->sale_price) ? floatval($subproduct->sale_price) : 0;
                                    $gst_percentage = isset($subproduct->gst_percentage) ? floatval($subproduct->gst_percentage) : 0;
                                    $gst_amount = ($sale_price * $gst_percentage) / 100;
                                    $gst_amount_formatted = number_format($gst_amount, 2);
                                    @endphp
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('fixed_price', $subproduct->fixed_price, array('placeholder' => 'Enter fixed price','class' => 'form-control input-error price-input' , 'id' => 'item_fixed_price')) !!}
                                        <div class="error" style="color:red;" id="fixed_price_error"></div>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('sale_price', $subproduct->sale_price, array('placeholder' => 'Enter sale price','class' => 'form-control input-error price-input' , 'id' => 'item_sale_price')) !!}
                                        <div class="error" style="color:red;" id="sale_price_error"></div>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('gst_percentage', $subproduct->gst_percentage, array('placeholder' => 'Enter GST %','class' => 'form-control input-error price-input' , 'id' => 'item_gst_percentage')) !!}
                                        <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                        <div class="gst-amount" id="gst_amount">GST Amount: <strong><span>{{ $gst_amount_formatted }}</span></strong></div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control price-input input-error' , 'id' => 'item_fixed_price')) !!}
                                        <div class="error" style="color:red;" id="fixed_price_error"></div>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control price-input input-error' , 'id' => 'item_sale_price')) !!}
                                        <div class="error" style="color:red;" id="sale_price_error"></div>
                                    </div>
                                    <div class="col-md-12 mt-2 mb-2">
                                        {!! Form::number('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control price-input input-error' , 'id' => 'item_gst_percentage')) !!}
                                        <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                        <div class="gst-amount" id="gst_amount"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group text-right">
                            <button type="button" class="btn btn-outline-primary removerecurringmaincardbtn" id="removerecurringmaincardbtn" data-subId="{{$subproduct->sub_id}}">Remove card</button>
                            <button type="submit" class="btn btn-outline-primary saverecurringcardbtn" id="saverecurringcardbtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>
</div>
@endif
</div>
@if ($isshow == false)
    <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
    <div class="btn-group dropdown float-right">
        <button type="submit" class="btn btn-outline-primary erp-item-form">
            Save
        </button>
    </div>
@endif
@endsection
@section('page-js')
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tagging.min.js') }}"></script>
<script src="{{ asset('assets/js/tagging.script.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    $(document).find('.tag_input').tagging();
    $(document).ready(function () {
        var quill = new Quill('#quill_editor', {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function () {
            $('#html_description').val(quill.root.innerHTML);
        });
    });

    $(document).ready(function() {
        $('.select2').select2();
        $('.itembillingcycle').select2();
    });
    $(document).on('change','#itembillingcycle',function() {
        if ($(this).val() === 'custom') {
            $(this).closest('.card').find('#customBillingCycleContainer').show();
        } else {
            $(this).closest('.card').find('#customBillingCycleContainer').hide();
        }
    }).trigger('change');

    $('#item_type').change(function(){
        $val = $(this).val();
        if($val == 'recurring'){
            $('.billingcyclecontainer').show();
            $('.autorenewalcontainer').show();
            $('.graceperiodcontianer').show();
            $('.licensevaliditycontainer').hide();
            $('.addrecurringcardoption').show();
        }else{
            $('.billingcyclecontainer').hide();
            $('.autorenewalcontainer').hide();
            $('.graceperiodcontianer').hide();
            $('.licensevaliditycontainer').show();
            $('.addrecurringcardoption').hide();
        }
    }).trigger('change');

    $(document).ready(function(){
        $('input[id="licensevalidityradio"]').on('change',function(){
            let selectedValue = $(this).val();
            $('.licensevaluetext').html(selectedValue);
            if (selectedValue === 'expirydate') {
                $('#expirydatecontainer').show();
            } else {
                $('#expirydatecontainer').hide();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var expiryDateInput = document.getElementById("expiryDate");
        var today = new Date().toISOString().split("T")[0];
        expiryDateInput.setAttribute("min", today);
    });
</script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
    @include('pages.items.items-script')
@endsection
