@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | Invoice</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}} | Create new invoice</a> </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="erp-invoice-submit" id="invoice_form" data-url="{{route('invoice-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
            <div class="card">
                <div class="card-body mb-3">
                    <h4 class="heading-color">Invoice</h4>
                    <label for="user_select">Select User:</label>
                    <select id="user_select" name="user" class="form-control select2">
                        <option value="0">Please select user</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name ?? ''}}</option>
                        @endforeach
                    </select>
                    <div id="user_error" class="text-danger"></div>
        
                    <label for="category" class="mt-3">Select Category</label>
                    <select name="category" id="category" class="form-control select2">
                        <option value="0">Select category</option>
                        @foreach ($category as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
        
                    <label for="sub_category" class="mt-3">Select Sub Category</label>
                    <select name="sub_category" id="sub_category" class="form-control select2">
                        <option value="0">Select sub category</option>
                    </select>
        
                    <label for="product" class="mt-3">Select Product</label>
                    <select name="product" id="product" class="form-control">
                        <option value="0">Select product</option>
                    </select>

                    <label for="coupon" class="mt-3">Available coupon</label>
                    <select name="coupon" id="coupon" class="form-control" onchange="dynamicCalculation()">
                        <option value="0">Select product first</option>
                    </select>
                    <div class="coupon_err" id="coupon_err"></div>
        
                    <!-- Row for Subtotal, GST, Discount, and Total -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <label for="subtotal">Subtotal</label>
                            <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="gst">GST (%)</label>
                            <input type="text" id="gst" name="gst" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="discount">Discount (%)</label>
                            <input type="text" id="discount" name="discount" class="form-control" oninput="dynamicCalculation()">
                        </div>
                        <div class="col-md-3">
                            <label for="total">Total</label>
                            <input type="text" id="total" name="total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="btn-group dropdown float-right mt-3">
            <button type="submit" class="btn btn-outline-primary erp-invoice-form">
                Save
            </button>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_select').select2();
    });
</script>

@endsection
@section('bottom-js')
    @include('pages.Invoice.invoiceScript')
@endsection
