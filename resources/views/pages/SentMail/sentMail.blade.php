@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ trans('custom.Blog_title') }}</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css " rel="stylesheet">
@endsection
@section('main-content')
    <style>
        .mail_template_img {
            width: 50px;
            height: auto;
            margin: 0 20px;
            object-fit: scale-down !important;
            transition: transform .2s;
            position: relative;
            z-index: 1;
        }

        .mail_template_img:hover {
            transform: scale(8.0);
            border-radius: 2px;
            z-index: 10;
        }
    </style>
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-6">
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | Send Email  </h4>
        </div>
    </div>
    @can('email-list')
    <h4 class="heading-color">Send Email</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label><input type="radio" name="emailOption" value="user" checked> User</label>
                            <label class="ms-3"><input type="radio" name="emailOption" value="manual"> Manual</label>
                        </div>                     
                        <div id="emailDropdown">
                            <label for="emailSelect">Select Email:</label>
                            <select id="emailSelect" class="form-control js-example-basic-multiple" name="email">
                                @foreach($newsletters as $newsletter)
                                    <option value="{{ $newsletter->email }}">{{ $newsletter->email }} (subscriber)</option>
                                @endforeach
                                @foreach($users as $user)
                                    <option value="{{ $user->email }}">{{ $user->email }} (user)</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="manualEmailInput" style="display: none;">
                            <label for="manualEmail">Enter Email:</label>
                            <input type="email" id="manualEmail" class="form-control" placeholder="Enter email">
                        </div>
                        <div id="mailSubjects">
                            <label for="mailSubject">Enter Subject:</label>
                            <input type="text" id="mailSubject" class="form-control" placeholder="Enter subject">
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea name="desc" id="desc" class="form-control" style="height:150px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="mb-3">Select Template Layout</label>
                            <label class="radio radio-primary mb-4">
                                <input type="radio" name="template" value="template_v1"
                                    formcontrolname="radio" checked>
                                <span>Template V1</span>
                                <img src="{{ asset('storage/sub_category_images/674e8e6cb7830_banner-1544x500.jpg') }}" alt="Template V1"
                                    class="mail_template_img">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio radio-primary mb-4">
                                <input type="radio" name="template" value="template_v2"
                                    formcontrolname="radio">
                                <span>Template V2</span>
                                <img src="{{ asset('storage/sub_category_images/674e8e6cb7830_banner-1544x500.jpg') }}" alt="Template V2"
                                    class="mail_template_img">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio radio-primary mb-4">
                                <input type="radio" name="template" value="template_v3"
                                    formcontrolname="radio">
                                <span>Template V3</span>
                                <img src="{{ asset('storage/sub_category_images/674e8e6cb7830_banner-1544x500.jpg') }}" alt="Template V3"
                                    class="mail_template_img">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="modal fade bd-Delete-modal-xl" id="preview-modal" tabindex="-1" role="dialog"
                            aria-labelledby="delete-spec" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete-spec">Preview Email</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="preview-container"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @can('email-sent')
            <div class="btn-group dropdown float-right">
                <button type="submit" class="btn btn-outline-primary email-form-preview"> Preview </button>
                <button type="button" class="btn btn-outline-primary email-form-btn"> Send Email </button>
            </div>
            @endcan
        </div>
    </div>
    @else
        <h1><b>You don't have permission to view this page</b></h1>
    @endcan
   
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Toggle email input fields
            $('input[name="emailOption"]').change(function() {
                if ($(this).val() === "user") {
                    $("#emailDropdown").show();
                    $("#manualEmailInput").hide();
                    $('#manualEmail').val('');
                } else {
                    $("#emailDropdown").hide();
                    $("#manualEmailInput").show();
                }
            });

            // Prevent form submission & log emails
            $("#getSelectedEmails").click(function(e) {
                e.preventDefault();

                let selectedEmails = $("#emailSelect").val() || [];
                let manualEmail = $("#manualEmail").val().trim(); 
                let template = $("input[name='template']:checked").val();
                var descEditor = tinymce.get('desc');

                if (manualEmail) {
                    selectedEmails  = manualEmail
                }
               
            });
        });
    </script>
@endsection
@section('bottom-js')
    @include('pages.SentMail.sentmailScript')
@endsection
