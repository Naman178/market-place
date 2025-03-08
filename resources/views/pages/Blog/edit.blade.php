<!DOCTYPE html>
@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ $Blog ? 'Edit: ' . $Blog->id : 'New' }}</title>
@endsection
@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .custom-textarea {
            height: auto !important;
        }

        .form-group label {
            font-size: 16px !important;
        }
    </style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-12">
            <h4> <a href="{{ route('dashboard') }}"
                    class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | <a
                    href="{{ route('Blog-index') }}">{{ trans('custom.Blog_title') }}</a> | {{ trans('custom.Blog_title') }}
                {{ $Blog ? 'Edit: ' . $Blog->id : 'New' }} </a>
                <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
                <div class="btn-group dropdown float-right">
                    <button type="submit" class="btn btn-outline-primary erp-Blog-form">
                        Save
                    </button>
                </div>
        </div>
    </div>
    <h4 class="heading-color">{{ trans('custom.Blog_title') }}</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    @if ($Blog)
                        <form class="erp-Blog-submit" id="Blog_form" enctype="multipart/form-data"
                            data-url="{{ route('Blog-store') }}" data-id="scid" data-name="name">
                            <input type="hidden" id="scid" class="erp-id" value="{{ $Blog->blog_id }}"
                                name="scid" />
                            <input type="hidden" id="old_image" name="old_image" value="{{ $Blog->image }}">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="title_label">Title</label>
                                    <input placeholder="Enter Title" class="form-control input-error" id="title"
                                        name="title" type="text" value="{{ $Blog->title }}">
                                    <div class="error" style="color:red;" id="title_error"></div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="category_label">Category</label>
                                    <select name="category" id="category" class="form-control select-input"
                                        required="required">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}"
                                                {{ $Blog->category == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="image">Upload Image</label>
                                    <input type="file" class="form-control-file" id="image" name="blog_image">
                                    <img class="mt-2" src="{{ asset('storage/images/' . $Blog->image) }}" width="100px"
                                        alt="not found">
                                    <div class="error" style="color:red;" id="image_error"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="short_description">Short Description</label>
                                    <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$Blog->short_description!!}</div>
                                    <input type="hidden" name="short_description" id="short_description" value="{{$Blog->short_description}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="long-description">Long Description</label>
                                    <div id="long_quill_editor" class="long_quill_editor" style="height: 200px; width:100%;">{!!$Blog->long_description!!}</div>
                                    <input type="hidden" name="long_description" id="long_description" value="{{$Blog->long_description}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="related_blog">Related Blogs</label>
                                    <select name="related_blog[]" id="related_blog" class="form-control select-input" multiple="multiple" required="required">
                                        <option value="">Select Related Blogs</option>
                                        @php
                                            // Decode the related blogs JSON into an array
                                            $selectedBlogs = json_decode($Blog->related_blogs, true) ?? [];
                                        @endphp
                                        @foreach ($Blog_list as $list)
                                            <option value="{{ $list->blog_id }}"
                                                {{ in_array($list->blog_id, $selectedBlogs) ? 'selected' : '' }}>
                                                {{ $list->title }}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>

                            </div>
                            <h5>Blog Content Section</h5>
                            <button type="button" class="btn btn-primary mt-2" id="add-section">Add Section</button>
                            {{-- @foreach ($BlogContents as $index => $BlogContent)
                                <input type="hidden" id="old_content_image_{{ $index }}" name="old_content_image_{{ $index }}" value="{{ $BlogContent->content_image }}">
                                <input type="hidden" id="content_id_{{$index}}" name="content_id_{{$index}}" value="{{ $BlogContent->id }}">
                                <input type="hidden" id="old_select_type_{{ $index }}" name="old_select_type_{{ $index }}" value="{{ $BlogContent->content_type }}">
                                
                                <div id="blog-sections">
                                    <div class="row mt-2 blog-section" id="section-{{ $index }}">
                                        <div class="col-md-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="col-md-12 mb-3 section-container" id="section-{{ $index }}">
                                                        <div class="form-group">
                                                            <label for="select-type-{{ $index }}">Select Type</label>
                                                            <select name="select_type[]" id="select-type-{{ $index }}" class="form-control select_type" data-section-index="{{ $index }}">
                                                                <option value="heading-description-image" {{ old('select_type.' . $index) == 'heading-description-image'}}  {{($BlogContent->content_type == 'heading-description-image' ? 'selected' : '')}} >Heading - Description - Image</option>
                                                                <option value="heading-image-description" {{ old('select_type.' . $index) == 'heading-image-description' }}{{ ($BlogContent->content_type == 'heading-image-description' ? 'selected' : '') }}>Heading - Image - Description</option>
                                                                <option value="image-description-heading" {{ old('select_type.' . $index) == 'image-description-heading' }}{{  ($BlogContent->content_type == 'image-description-heading' ? 'selected' : '') }}>Image - Description - Heading</option>
                                                                <option value="heading-description-image-description" {{ old('select_type.' . $index) == 'heading-description-image-description' }}{{  ($BlogContent->content_type == 'heading-description-image-description' ? 'selected' : '') }}>Heading - Description - Image - Description</option>
                                                            </select>
                                                        </div>
                                                        <div class="dynamic-content">
                                                            <!-- Heading - Description - Image -->
                                                            <div class="content-option" id="content-option-1" style="{{ (old('select_type.' . $index) == 'heading-description-image' || $BlogContent->content_type == 'heading-description-image') ? 'display:block;' : 'display:none;' }}">
                                                                <div class="form-group heading-field">
                                                                    <label for="heading-{{ $index }}">Heading</label>
                                                                    <input type="text" class="form-control" id="heading-{{ $index }}"  name="heading_{{ $index }}" value="{{ isset($BlogContent->content_heading) ? $BlogContent->content_heading : old('heading_' . $index) }}">
                                                                </div>
                                                                <div class="form-group description-field">
                                                                    <label for="description-{{ $index }}">Description</label>
                                                                    <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea>
                                                                </div>
                                                                <div class="form-group image-field">
                                                                    <label for="image-{{ $index }}">Image</label>
                                                                    <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                    <img src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="not found" width="100px">
                                                                </div>
                                                            </div>
                                                            <!-- Heading - Image - Description -->
                                                            <div class="content-option" id="content-option-2" style="{{ (old('select_type.' . $index) == 'heading-image-description' || $BlogContent->content_type == 'heading-image-description') ? 'display:block;' : 'display:none;' }}">
                                                                <div class="form-group heading-field">
                                                                    <label for="heading-{{ $index }}">Heading</label>
                                                                    <input type="text" class="form-control" id="heading-{{ $index }}"  name="heading_{{ $index }}" value="{{ isset($BlogContent->content_heading) ? $BlogContent->content_heading : old('heading_' . $index) }}">
                                                                </div>
                                                                <div class="form-group image-field">
                                                                    <label for="image-{{ $index }}">Image</label>
                                                                    <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                    <img src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="not found" width="100px">
                                                                </div>
                                                                <div class="form-group description-field">
                                                                    <label for="description-{{ $index }}">Description</label>
                                                                    <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea>
                                                                </div>
                                                            </div>
                                                            <!-- Image - Description - Heading -->
                                                            <div class="content-option" id="content-option-3" style="{{ (old('select_type.' . $index) == 'image-description-heading' || $BlogContent->content_type == 'image-description-heading') ? 'display:block;' : 'display:none;' }}">
                                                                <div class="form-group image-field">
                                                                    <label for="image-{{ $index }}">Image</label>
                                                                    <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                    <img src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="not found" width="100px">
                                                                </div>
                                                                <div class="form-group description-field">
                                                                    <label for="description-{{ $index }}">Description</label>
                                                                    <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea>
                                                                </div>
                                                                <div class="form-group heading-field">
                                                                    <label for="heading-{{ $index }}">Heading</label>
                                                                    <input type="text" class="form-control" id="heading-{{ $index }}"  name="heading_{{ $index }}" value="{{ isset($BlogContent->content_heading) ? $BlogContent->content_heading : old('heading_' . $index) }}">
                                                                </div>
                                                            </div>
                                                            <!-- Heading - Description - Image - Description -->
                                                            <div class="content-option" id="content-option-4" style="{{ (old('select_type.' . $index) == 'heading-description-image-description' || $BlogContent->content_type == 'heading-description-image-description') ? 'display:block;' : 'display:none;' }}">
                                                                <div class="form-group heading-field">
                                                                    <label for="heading-{{ $index }}">Heading</label>
                                                                    <input type="text" class="form-control" id="heading-{{ $index }}"  name="heading_{{ $index }}" value="{{ isset($BlogContent->content_heading) ? $BlogContent->content_heading : old('heading_' . $index) }}">
                                                                </div>
                                                                <div class="form-group description-field">
                                                                    <label for="description-{{ $index }}">Description</label>
                                                                    <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">
                                                                        {{ old('description_' . $index, isset($BlogContent->content_descriptipn_1) ? $BlogContent->content_descriptipn_1 : '') }}
                                                                    </textarea>
                                                                </div>
                                                                
                                                                <div class="form-group image-field">
                                                                    <label for="image-{{ $index }}">Image</label>
                                                                    <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                    @if(isset($BlogContent->content_image))
                                                                        <img src="{{ asset('storage/images/' . $BlogContent->content_image) }}" alt="Image not found" width="100px">
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="form-group description-field">
                                                                    <label for="description2-{{ $index }}">Description</label>
                                                                    <textarea class="form-control tinymce-textarea" id="description2-{{ $index }}" name="description2_{{ $index }}">
                                                                        {{ old('description2_' . $index, isset($BlogContent->content_descriptipn_2) ? $BlogContent->content_descriptipn_2 : '') }}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach --}}
                            @foreach ($BlogContents as $index => $BlogContent)
                                <input type="hidden" id="old_content_image_{{ $index }}" name="old_content_image_{{ $index }}" value="{{ $BlogContent->content_image }}">
                                <input type="hidden" id="content_id_{{$index}}" name="content_id_{{$index}}" value="{{ $BlogContent->id }}">
                                <input type="hidden" id="old_select_type_{{ $index }}" name="old_select_type_{{ $index }}" value="{{ $BlogContent->content_type }}">
                                
                                <div id="blog-sections">
                                    <div class="row mt-2 blog-section" id="section-{{ $index }}">
                                        <div class="col-md-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="col-md-12 mb-3 section-container" id="section-{{ $index }}">
                                                        <div class="form-group">
                                                            <label for="select-type-{{ $index }}">Select Type</label>
                                                            <select name="select_type[]" id="select-type-{{ $index }}" class="form-control select_type" data-section-index="{{ $index }}">
                                                                <option value="heading-description-image" {{ old('select_type.' . $index) == 'heading-description-image' || $BlogContent->content_type == 'heading-description-image' ? 'selected' : '' }}>Heading - Description - Image</option>
                                                                <option value="heading-image-description" {{ old('select_type.' . $index) == 'heading-image-description' || $BlogContent->content_type == 'heading-image-description' ? 'selected' : '' }}>Heading - Image - Description</option>
                                                                <option value="image-description-heading" {{ old('select_type.' . $index) == 'image-description-heading' || $BlogContent->content_type == 'image-description-heading' ? 'selected' : '' }}>Image - Description - Heading</option>
                                                                <option value="heading-description-image-description" {{ old('select_type.' . $index) == 'heading-description-image-description' || $BlogContent->content_type == 'heading-description-image-description' ? 'selected' : '' }}>Heading - Description - Image - Description</option>
                                                            </select>
                                                        </div>
                                                        <div class="dynamic-content">
                                                            @if( $BlogContent->content_type == 'heading-description-image')
                                                                <!-- Heading - Description - Image -->
                                                                <div class="content-option" id="content-option-heading-description-image" style="{{ (old('select_type.' . $index) == 'heading-description-image' || $BlogContent->content_type == 'heading-description-image') ? 'display:block;' : 'display:none;' }}">
                                                                    <div class="form-group heading-field">
                                                                        <label for="heading-{{ $index }}">Heading</label>
                                                                        <input type="text" class="form-control" id="heading-{{ $index }}" name="heading_{{ $index }}" value="{{ old('heading_' . $index, $BlogContent->content_heading) }}">
                                                                    </div>
                                                                    <div class="form-group description-field">
                                                                        <label for="description-{{ $index }}">Description</label>
                                                                        <div id="description-{{ $index }}" class="quill-editor" style="height: 200px; width:100%;">{!! old('description_' . $index, $BlogContent->content_descriptipn_1)!!}</div>
                                                                        <input type="hidden" name="description-{{ $index }}" id="description_{{ $index }}" value="{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}">
                                                                        {{-- <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea> --}}
                                                                    </div>
                                                                    <div class="form-group image-field">
                                                                        <label for="image-{{ $index }}">Image</label>
                                                                        <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                        <img id="image-url-{{ $index }}" src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="Image not found" width="100px">
                                                                    </div>
                                                                    @if($BlogContent->content_descriptipn_2)
                                                                        <div class="form-group description-field">
                                                                            <label for="description2-{{ $index }}">Description</label>
                                                                            <div id="description2-{{ $index }}"  class="quill-editor" style="height: 200px; width:100%;">{!! old('description2_' . $index, $BlogContent->content_descriptipn_2)!!}</div>
                                                                            <input type="hidden" name="description2-{{ $index }}" id="description2_{{ $index }}" value="{!! old('description2_' . $index, $BlogContent->content_descriptipn_2) !!}">
                                                                            {{-- <textarea class="form-control tinymce-textarea" id="description2-{{ $index }}" name="description2_{{ $index }}">{!! old('description2_' . $index, $BlogContent->content_descriptipn_2) !!}</textarea> --}}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @elseif( $BlogContent->content_type == 'heading-image-description')
                                                                <!-- Heading - Image - Description -->
                                                                <div class="content-option" id="content-option-heading-image-description" style="{{ (old('select_type.' . $index) == 'heading-image-description' || $BlogContent->content_type == 'heading-image-description') ? 'display:block;' : 'display:none;' }}">
                                                                    <div class="form-group heading-field">
                                                                        <label for="heading-{{ $index }}">Heading</label>
                                                                        <input type="text" class="form-control" id="heading-{{ $index }}" name="heading_{{ $index }}" value="{{ old('heading_' . $index, $BlogContent->content_heading) }}">
                                                                    </div>
                                                                    <div class="form-group image-field">
                                                                        <label for="image-{{ $index }}">Image</label>
                                                                        <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                        <img id="image-url-{{ $index }}" src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="Image not found" width="100px">
                                                                    </div>
                                                                    <div class="form-group description-field">
                                                                        <label for="description-{{ $index }}">Description</label>
                                                                        <div id="description-{{ $index }}" class="quill-editor" style="height: 200px; width:100%;">{!! old('description_' . $index, $BlogContent->content_descriptipn_1)!!}</div>
                                                                        <input type="hidden" name="description-{{ $index }}" id="description_{{ $index }}" value="{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}">
                                                                        {{-- <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea> --}}
                                                                    </div>
                                                                </div>
                                                            @elseif($BlogContent->content_type == 'image-description-heading')
                                                                <!-- Image - Description - Heading -->
                                                                <div class="content-option" id="content-option-image-description-heading" style="{{ (old('select_type.' . $index) == 'image-description-heading' || $BlogContent->content_type == 'image-description-heading') ? 'display:block;' : 'display:none;' }}">
                                                                    <div class="form-group image-field">
                                                                        <label for="image-{{ $index }}">Image</label>
                                                                        <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                        <img id="image-url-{{ $index }}" src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="Image not found" width="100px">
                                                                    </div>
                                                                    <div class="form-group description-field">
                                                                        <label for="description-{{ $index }}">Description</label>
                                                                        <div id="description-{{ $index }}" class="quill-editor" style="height: 200px; width:100%;">{!! old('description_' . $index, $BlogContent->content_descriptipn_1)!!}</div>
                                                                        <input type="hidden" name="description-{{ $index }}" id="description_{{ $index }}" value="{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}">
                                                                        {{-- <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea> --}}
                                                                    </div>
                                                                    <div class="form-group heading-field">
                                                                        <label for="heading-{{ $index }}">Heading</label>
                                                                        <input type="text" class="form-control" id="heading-{{ $index }}" name="heading_{{ $index }}" value="{{ old('heading_' . $index, $BlogContent->content_heading) }}">
                                                                    </div>
                                                                </div>
                                                            @elseif($BlogContent->content_type == 'heading-description-image-description')
                                                                <!-- Heading - Description - Image - Description -->
                                                                <div class="content-option" id="content-option-heading-description-image-description" style="{{ (old('select_type.' . $index) == 'heading-description-image-description' || $BlogContent->content_type == 'heading-description-image-description') ? 'display:block;' : 'display:none;' }}">
                                                                    <div class="form-group heading-field">
                                                                        <label for="heading-{{ $index }}">Heading</label>
                                                                        <input type="text" class="form-control" id="heading-{{ $index }}" name="heading_{{ $index }}" value="{{ old('heading_' . $index, $BlogContent->content_heading) }}">
                                                                    </div>
                                                                    <div class="form-group description-field">
                                                                        <label for="description-{{ $index }}">Description</label>
                                                                        <div id="description-{{ $index }}" class="quill-editor" style="height: 200px; width:100%;">{!! old('description_' . $index, $BlogContent->content_descriptipn_1)!!}</div>
                                                                        <input type="hidden" name="description-{{ $index }}" id="description_{{ $index }}" value="{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}">
                                                                        {{-- <textarea class="form-control tinymce-textarea" id="description-{{ $index }}" name="description_{{ $index }}">{!! old('description_' . $index, $BlogContent->content_descriptipn_1) !!}</textarea> --}}
                                                                    </div>
                                                                    <div class="form-group image-field">
                                                                        <label for="image-{{ $index }}">Image</label>
                                                                        <input type="file" class="form-control" id="image-{{ $index }}" name="image_{{ $index }}">
                                                                        <img id="image-url-{{ $index }}" src="{{ old('image_' . $index, asset('storage/images/' . $BlogContent->content_image)) }}" alt="Image not found" width="100px">
                                                                    </div>
                                                                    @if($BlogContent->content_descriptipn_2)
                                                                        <div class="form-group description-field">
                                                                            <label for="description2-{{ $index }}">Description</label>
                                                                            <div id="description2-{{ $index }}"  class="quill-editor" style="height: 200px; width:100%;">{!! old('description2_' . $index, $BlogContent->content_descriptipn_2)!!}</div>
                                                                            <input type="hidden" name="description2-{{ $index }}" id="description2_{{ $index }}" value="{!! old('description2_' . $index, $BlogContent->content_descriptipn_2) !!}">
                                                                            {{-- <textarea class="form-control tinymce-textarea" id="description2-{{ $index }}" name="description2_{{ $index }}">{!! old('description2_' . $index, $BlogContent->content_descriptipn_2) !!}</textarea> --}}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger edit-remove-section" data-blog-id="{{ $Blog->blog_id }}" data-section-id="section-{{ $index }}" data-section-index="{{ $BlogContent->id }}">Remove Section</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div id="blog-sections"></div>
                        </form>
                    @else
                        <form class="erp-Blog-submit" id="Blog_form" enctype="multipart/form-data"
                            data-url="{{ route('Blog-store') }}" data-id="scid">
                            <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="title_label">Title</label>
                                    {!! Form::text('title', null, [
                                        'placeholder' => 'Enter Title',
                                        'class' => 'form-control input-error',
                                        'id' => 'title',
                                    ]) !!}
                                    <div class="error" style="color:red;" id="title_error"></div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="title_label">Title</label>
                                    <select name="category" id="category" class="form-control select-input"
                                        required="required">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">
                                                {{ $category->name }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="image">Upload Image</label>
                                    <input type="file" class="form-control-file" id="image" name="blog_image">

                                    <div id="image-previews" class="mt-2">
                                    </div>

                                    <div class="error" style="color:red;" id="image_error"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="short-description">Short Description</label>
                                    <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                                    <input type="hidden" name="short_description" id="short_description">
                                    {{-- <textarea id="short_description" name="short_description"></textarea> --}}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="long-description">Long Description</label>
                                    <div id="long_quill_editor" class="long_quill_editor" style="height: 200px; width:100%;"></div>
                                    <input type="hidden" name="long_description" id="long_description">
                                    {{-- <textarea id="long-description" name="long_description"></textarea> --}}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="related_blog">Related Blogs</label>
                                    <select name="related_blog[]" id="related_blog" class="form-control select-input"
                                        multiple="multiple" required="required">
                                        <option value="">Select Related Blogs</option>
                                        @foreach ($Blog_list as $list)
                                            <option value="{{ $list->blog_id }}">
                                                {{ $list->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h5>Blog Content Section</h5>
                            <button type="button" class="btn btn-primary mt-2" id="add-section">Add Section</button>
                            <div id="blog-sections"></div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
    <div class="btn-group dropdown float-right">
        <button type="submit" class="btn btn-outline-primary erp-Blog-form">
            Save
        </button>
    </div>
@endsection
@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/8ohuouqsfj9dcnrapjxg1t1aqvftbsfowsu6tnil1fw8yk2i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
    @include('pages.Blog.Blog-script')
@endsection
