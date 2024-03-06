@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $item ? 'Edit: '.$item->id : 'New'}}</title>
    <script src="https://cdn.tiny.cloud/1/o7h5fdpvwna0iulbykb99xeh6i53zmtdyswqphxutmkecio6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
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
    </script>
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
    .remove-btn {
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
    }

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
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-item-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">Item</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($item)
                    <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                        <input type="hidden" id="item_id" class="erp-id" value="{{$item->id}}" name="item_id" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Name</label>
                                <input placeholder="Enter Item Name" class="form-control input-error" id="item_name" name="name" type="text" value="{{ $item->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="col-6 form-group">
                                <label for="preview_url_label">Preview URL</label>
                                <input placeholder="Include http:// or https:// in the URL" class="form-control" id="item_preview_url" name="preview_url" type="url" value="{{ $item->preview_url }}" pattern= 'https?://.*'>
                                <div class="error" style="color:red;" id="preview_url_error"></div>
                            </div>
                            <div class="col-6 form-group input-file-col">
                                <label for="item_thumbnail_label">Item Thumbnail</label>
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
                                <label for="item_main_file_label">Main file</label>
                                <label id="item_main_file_label" class="form-control filelabel file-input-label">
                                    <input type="hidden" name="old_main_file" value="@if(!empty($item->main_file_zip)){{$item->main_file_zip}}@endif">
                                    <input type="file" name="item_main_file" id="item_main_file"  accept=".zip"  class="form-control file-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <span class="title" id="item_files_title"  data-title="title">{{ $item->main_file_zip ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="zip_file_error"></div>
                            </div>
                            <div class="col-md-12 form-group mb-4">
                                <label for="html_description_label">Description</label>
                                <textarea name="html_description"  id="html_description">{{ $item->html_description }}</textarea>
                                <div class="error" style="color:red;" id="description_error"></div>
                            </div>
                            <div class="col-md-12 form-group add-more-input">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="key_feature_label">Features</label>
                                    </div>
                                    <div class="col-6 text-right">
                                    <button type="button" class="btn btn-info" id="add-feature">Add more</button>
                                    </div>
                                </div>
                                <div class="feature-input-wrapper">
                                    @foreach($item->features as $feature)
                                        <div class="row input-row feature-input-row">
                                            <div class="col-9"> 
                                                <input placeholder="Enter key feature" class="form-control mb-3" id="key_feature" name="key_feature[]" type="text" value="{{ $feature->key_feature }}">
                                            </div>
                                            <!-- <div class="col-3"><div class="remove-btn"><span class="close-icon" aria-hidden="true">&times;</span></div></div> -->
                                        </div>
                                    @endforeach
                                </div>
                                <div class="error" style="color:red;" id="feature_error"></div>
                            </div>
                            <div class="col-md-12 form-group input-file-col">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="item_images_label">Images</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-info" id="add-image">Add more</button>
                                    </div>
                                </div>
                                <div class="image-input-wrapper">
                                    @foreach($item->images as $image)
                                        <?php $showImagePrev = (!empty($image->image_path)) ? 'display:inline-block' : ''; ?>
                                        <div class="row input-row image-input-row">
                                            <div class="col-9">
                                                <label class="form-control filelabel mb-3 image-input-label">
                                                    <input type="hidden" name="old_image[]" value="@if(!empty($image->image_path)){{$image->image_path}}@endif">
                                                    <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control">
                                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                    <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($image->image_path)){{asset('storage/items_files/'.$image->image_path)}}@endif" data-title="previewImgCls" style="{{$showImagePrev}}">
                                                    <span class="title" id="item_images_title" data-title="title">{{ $image->image_path ??  ''}}</span>
                                                </label>
                                            </div>
                                            <!-- <div class="col-3"><div class="remove-btn"><span class="close-icon" aria-hidden="true">&times;</span></div></div> -->
                                        </div>
                                    @endforeach
                                </div>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="tags_label">Tags</label>
                                <div data-no-duplicate="true" data-pre-tags-separator="\n" data-no-duplicate-text="Duplicate tags" data-type-zone-class="type-zone" data-tag-box-class="tagging" data-edit-on-delete="false" class="tag_input">
                                    @foreach($item->tags as $index => $tag)
                                    @if($index > 0) \n @endif{{ $tag->tag_name }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="category_label">Category</label>
                                {!! Form::select('category_id', ['' => 'Select category'] + $categories, $item->categorySubcategory->category_id, ['class' => 'form-control select-input', 'id' => 'category_id']) !!}
                                <div class="error" style="color:red;" id="category_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
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
                        
                            <div class="col-md-12 form-group">
                                <label for="pricing_label">Pricing</label>
                                <div class="row">
                                    @php 
                                    $fixed_price = isset($item->pricing->fixed_price) ? floatval($item->pricing->fixed_price) : 0;
                                    $sale_price = isset($item->pricing->sale_price) ? floatval($item->pricing->sale_price) : 0;
                                    $gst_percentage = isset($item->pricing->gst_percentage) ? floatval($item->pricing->gst_percentage) : 0;

                                    if ($sale_price == 0) {
                                        $gst_amount = ($fixed_price * $gst_percentage) / 100;
                                    } else {
                                        $gst_amount = ($fixed_price - $sale_price) * ($gst_percentage / (100 + $gst_percentage));
                                    }

                                    $gst_amount_formatted = number_format($gst_amount, 2);
                                    @endphp
                                    <div class="col-md-4">
                                        {!! Form::text('fixed_price', $item->pricing->fixed_price, array('placeholder' => 'Enter fixed price','class' => 'form-control input-error price-input' , 'id' => 'item_fixed_price')) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('sale_price', $item->pricing->sale_price, array('placeholder' => 'Enter sale price','class' => 'form-control input-error price-input' , 'id' => 'item_sale_price')) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('gst_percentage', $item->pricing->gst_percentage, array('placeholder' => 'Enter GST %','class' => 'form-control input-error price-input' , 'id' => 'item_gst_percentage')) !!}
                                        <div class="gst-amount" id="gst_amount">GST Amount: <strong><span>{{ $gst_amount_formatted }}</span></strong></div>
                                    </div>
                                </div>
                                <div class="error" style="color:red;" id="fixed_price_error"></div>
                            </div>
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
                    </form>
                @else
                <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="item_id">
                    <input type="hidden" id="item_id" class="erp-id" name="item_id" value="0" />
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
                            <textarea name="html_description"  id="html_description"></textarea>
                            <div class="error" style="color:red;" id="description_error"></div>
                        </div>
                        <div class="col-md-12 form-group add-more-input">
                            <div class="row">
                                <div class="col-6">
                                    <label for="key_feature_label">Features</label>
                                </div>
                                <div class="col-6 text-right">
                                <button type="button" class="btn btn-info" id="add-feature">Add more</button>
                                </div>
                            </div>
                            <div class="feature-input-wrapper">
                                <div class="row input-row feature-input-row" data-order='1'>
                                    <div class="col-9"> 
                                        {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="error" style="color:red;" id="feature_error"></div>
                        </div>
                        <div class="col-md-12 form-group input-file-col">
                            <div class="row">
                                <div class="col-6">
                                    <label for="item_images_label">Images</label>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-info" id="add-image">Add more</button>
                                </div>
                            </div>
                            <div class="image-input-wrapper">
                                <div class="row input-row image-input-row">
                                    <div class="col-9">
                                        <label class="form-control filelabel mb-3 image-input-label">
                                            <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error">
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                            <span class="title" id="item_images_title" data-title="title"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="tags_label">Tags</label>
                            <div data-no-duplicate="true" data-pre-tags-separator="\n" data-no-duplicate-text="Duplicate tags" data-type-zone-class="type-zone" data-tag-box-class="tagging" data-edit-on-delete="false" class="tag_input"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category_label">Category</label>
                            {!! Form::select('category_id', ['' => 'Select category'] + $categories, null, ['class' => 'form-control select-input', 'id' => 'category_id']) !!}
                            <div class="error" style="color:red;" id="category_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="subcategory_label">Sub category</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control subcategory-select select-input">
                                <option value="">Select sub category</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}" class="d-none">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            <div class="error" style="color:red;" id="subcategories_error"></div>
                        </div>
                       
                        <div class="col-md-12 form-group">
                            <label for="pricing_label">Pricing</label>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::text('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control price-input input-error' , 'id' => 'item_fixed_price')) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control price-input input-error' , 'id' => 'item_sale_price')) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control price-input input-error' , 'id' => 'item_gst_percentage')) !!}
                                    <div class="gst-amount" id="gst_amount"></div>
                                </div>
                            </div>
                            
                            <div class="error" style="color:red;" id="fixed_price_error"></div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
<a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
<div class="btn-group dropdown float-right">
    <button type="submit" class="btn btn-outline-primary erp-item-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tagging.min.js') }}"></script>
<script src="{{ asset('assets/js/tagging.script.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
    @include('pages.items.items-script')
@endsection