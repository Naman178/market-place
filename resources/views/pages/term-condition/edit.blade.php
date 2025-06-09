@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $term_condition ? 'Edit: '.$term_condition->id : 'New'}}</title>
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('term-condition-index')}}">{{ trans('custom.term_condition_title') }}</a> | {{ trans('custom.term_condition_title') }} {{ $term_condition ? 'Edit: '.$term_condition->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-term-condition-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.term_condition_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($term_condition)
                    <form class="erp-term-condition-submit" id="term_condition_form" data-url="{{route('term-condition-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$term_condition->id}}" name="scid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Title</label>
                                <input placeholder="Enterterm & condition Title" class="form-control input-error" id="term_condition_title" name="title" type="text" value="{{ $term_condition->title }}">
                                <div class="error" style="color:red;" id="title_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Description</label>
                                <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$term_condition->description!!}</div>
                                <input type="hidden" name="description" id="description" value="{{$term_condition->description}}">
                                <div class="error" style="color:red;" id="description_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-term-condition-submit" id="term_condition_form" data-url="{{route('term-condition-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Title</label>
                            {!! Form::text('title', null, array('placeholder' => 'Enterterm & condition Title','class' => 'form-control input-error' , 'id' => 'term_condition_title')) !!}
                            <div class="error" style="color:red;" id="title_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-term-condition-form">
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
    @include('pages.term-condition.term-condition-script')
@endsection