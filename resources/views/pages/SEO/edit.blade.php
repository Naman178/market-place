@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $SEO ? 'Edit: '.$SEO->id : 'New'}}</title>
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('SEO-index')}}">{{ trans('custom.SEO_title') }}</a> | {{ trans('custom.SEO_title') }} {{ $SEO ? 'Edit: '.$SEO->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-SEO-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.SEO_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($SEO)
                    <form class="erp-SEO-submit" id="SEO_form" data-url="{{route('SEO-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$SEO->id}}" name="scid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Page Name</label>
                                <input placeholder="Enter Page Name" class="form-control input-error" id="page" name="page" type="text" value="{{ $SEO->page }}">
                                <div class="error" style="color:red;" id="page_name_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="title_label">Title</label>
                                <input placeholder="Enter Title" class="form-control input-error" id="SEO_title" name="title" type="text" value="{{ $SEO->title }}">
                                <div class="error" style="color:red;" id="title_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Description</label>
                                <textarea name="description"  class="form-control custom-textarea" id="description">{{ $SEO->description }}</textarea>
                                <div class="error" style="color:red;" id="description_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="title_label">Keyword</label>
                                <input placeholder="Enter Keyword" class="form-control input-error" id="keyword" name="keyword" type="text" value="{{ $SEO->keyword }}">
                                <div class="error" style="color:red;" id="keyword_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-SEO-submit" id="SEO_form" data-url="{{route('SEO-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Page Name</label>
                            {!! Form::text('page', null, array('placeholder' => 'Enter Page Name','class' => 'form-control input-error' , 'id' => 'page')) !!}
                            <div class="error" style="color:red;" id="page_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="title_label">Title</label>
                            {!! Form::text('title', null, array('placeholder' => 'Enter Title','class' => 'form-control input-error' , 'id' => 'SEO_title')) !!}
                            <div class="error" style="color:red;" id="title_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control custom-textarea" id="description"></textarea>
                            <div class="error" style="color:red;" id="description_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="title_label">Keyword</label>
                            {!! Form::text('keyword', null, array('placeholder' => 'Enter Keyword','class' => 'form-control input-error' , 'id' => 'keyword')) !!}
                            <div class="error" style="color:red;" id="keyword_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-SEO-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')  
    @include('pages.SEO.SEO-script')
@endsection