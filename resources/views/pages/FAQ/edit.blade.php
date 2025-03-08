@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $FAQ ? 'Edit: '.$FAQ->id : 'New'}}</title>
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('FAQ-index')}}">{{ trans('custom.FAQ_title') }}</a> | {{ trans('custom.FAQ_title') }} {{ $FAQ ? 'Edit: '.$FAQ->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-FAQ-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.FAQ_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($FAQ)
                    <form class="erp-FAQ-submit" id="FAQ_form" data-url="{{route('FAQ-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$FAQ->id}}" name="scid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Question</label>
                                <input placeholder="Enter Question" class="form-control input-error" id="question" name="question" type="text" value="{{ $FAQ->question }}">
                                <div class="error" style="color:red;" id="question_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="answer">Answer</label>
                                <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$FAQ->answer!!}</div>
                                <input type="hidden" name="answer" id="answer" value="{{$FAQ->answer}}">
                                <div class="error" style="color:red;" id="answer_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-FAQ-submit" id="FAQ_form" data-url="{{route('FAQ-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Question</label>
                            {!! Form::text('question', null, array('placeholder' => 'Enter Question','class' => 'form-control input-error' , 'id' => 'question')) !!}
                            <div class="error" style="color:red;" id="question_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="answer">Answer</label>
                            <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                            <input type="hidden" name="answer" id="answer">
                            <div class="error" style="color:red;" id="answer_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-FAQ-form">
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
    @include('pages.FAQ.FAQ-script')
@endsection