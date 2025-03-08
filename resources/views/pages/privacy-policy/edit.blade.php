@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $privacy_policy ? 'Edit: '.$privacy_policy->id : 'New'}}</title>
@endsection
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .custom-textarea {
        height: auto !important;
    }
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('privacy-policy-index')}}">{{ trans('custom.privacy_policy_title') }}</a> | {{ trans('custom.privacy_policy_title') }} {{ $privacy_policy ? 'Edit: '.$privacy_policy->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-privacy-policy-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.privacy_policy_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($privacy_policy)
                    <form class="erp-privacy-policy-submit" id="privacy_policy_form" data-url="{{route('privacy-policy-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$privacy_policy->id}}" name="scid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Title</label>
                                <input placeholder="Enterterm & condition Title" class="form-control input-error" id="privacy_policy_title" name="title" type="text" value="{{ $privacy_policy->title }}">
                                <div class="error" style="color:red;" id="title_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Description</label>
                                <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$privacy_policy->description!!}</div>
                                <input type="hidden" name="description" id="description" value="{{$privacy_policy->description}}">
                                <div class="error" style="color:red;" id="description_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-privacy-policy-submit" id="privacy_policy_form" data-url="{{route('privacy-policy-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Title</label>
                            {!! Form::text('title', null, array('placeholder' => 'Enterterm & condition Title','class' => 'form-control input-error' , 'id' => 'privacy_policy_title')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                            <input type="hidden" name="description" id="description">
                            <div class="error" style="color:red;" id="description_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-privacy-policy-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')  
    @include('pages.privacy-policy.privacy-policy-script')
@endsection