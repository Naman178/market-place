@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ $coupon ? 'Edit: ' . $coupon->id : 'New' }}</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('page-css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .image-input,
        .file-input {
            display: none;
        }

        .filelabel {
            height: auto;
            margin-bottom: 0;
        }

        .previewImgCls {
            width: 50px;
            height: 50px;
            margin: 0 20px;
            object-fit: scale-down !important;
            transition: transform .2s;
            position: relative;
        }

        .previewImgCls:hover {
            transform: scale(5.0);
            border-radius: 2px;
            z-index: 1;
        }

        .previewImgCls {
            display: none;
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
            <h4> <a href="{{ route('dashboard') }}"
                    class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | <a
                    href="{{ route('coupon-index') }}">Coupon</a> | Coupon
                {{ $coupon ? 'Edit: ' . $coupon->coupon_code : 'New' }} </a>
                <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
                <div class="btn-group dropdown float-right">
                    <button type="submit" class="btn btn-outline-primary erp-coupon-form">
                        Save
                    </button>
                </div>
        </div>
    </div>
    <div class="row">
        @if ($coupon == null)
            <form action="" id="coupon_form">
                <input type="hidden" name="id" value="new">
                <div class="col-lg-12 col-12">
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input placeholder="Enter Coupon Code" class="form-control input-error" id="coupon_code"
                                        name="coupon_code" type="text">
                                    <div class="error" style="color:red;" id="coupon_code_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select class="form-control select2 input-error" id="discount_type"
                                        name="discount_type">
                                        <option value="">Select Discount Type</option>
                                        <option value="flat">Flat</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                    <div class="error" style="color:red;" id="discount_type_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="discount_value">Discount Value</label>
                                    <input placeholder="Enter Discount Value" class="form-control input-error"
                                        id="discount_value" name="discount_value" type="number" min="0"
                                        step="0.01">
                                    <div class="error" style="color:red;" id="discount_value_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="max_discount">Max Discount</label>
                                    <input placeholder="Enter Max Discount" class="form-control input-error"
                                        id="max_discount" name="max_discount" type="number" min="0" step="1">
                                    <div class="error" style="color:red;" id="max_discount_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="valid_from">Discount Valid From</label>
                                    <input placeholder="Select Start Date" class="form-control input-error" id="valid_from"
                                        name="valid_from" type="date">
                                    <div class="error" style="color:red;" id="valid_from_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="valid_until">Discount Valid Until</label>
                                    <input placeholder="Select Expiry Date" class="form-control input-error"
                                        id="valid_until" name="valid_until" type="date">
                                    <div class="error" style="color:red;" id="valid_until_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="min_cart_amount">Minimum Purchase Amount</label>
                                    <input placeholder="Enter Minimum Purchase Amount" class="form-control input-error"
                                        id="min_cart_amount" name="min_cart_amount" type="number" min="0"
                                        step="0.01">
                                    <div class="error" style="color:red;" id="min_cart_amount_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="applicable_type">Applicable Products</label>
                                    <select class="form-control select2 input-error" id="applicable_type"
                                        name="applicable_type">
                                        <option value="">Select Applicable Products</option>
                                        <option value="all">All</option>
                                        <option value="category">Specific Categories</option>
                                        <option value="sub-category">Specific Sub-Categories</option>
                                        <option value="product">Specific Products</option>
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_type_error"></div>
                                </div>

                                <div class="col-md-12 form-group applicable_selection_container"
                                    id="applicable_selection_container" style="display: none">
                                    <label for="applicable_selection">Application Selection</label>
                                    <select class="form-control select2 input-error" id="applicable_selection"
                                        name="applicable_selection[]" multiple>
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_selection_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="applicable_for">Applicable For</label>
                                    <select class="form-control select2 input-error" id="applicable_for"
                                        name="applicable_for">
                                        <option value="">Select Applicable For</option>
                                        <option value="one-time">One-Time</option>
                                        <option value="recurring">Recurring</option>
                                        <option value="both">Both</option>
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_for_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="limit_per_user">Limit Usage Per User</label>
                                    <input placeholder="Enter Limit Per User" class="form-control input-error"
                                        id="limit_per_user" name="limit_per_user" type="number" min="1"
                                        step="1">
                                    <div class="error" style="color:red;" id="limit_per_user_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="total_redemptions">Limit Total Redemptions</label>
                                    <input placeholder="Enter Total Redemptions Limit" class="form-control input-error"
                                        id="total_redemptions" name="total_redemptions" type="number" min="1"
                                        step="1">
                                    <div class="error" style="color:red;" id="total_redemptions_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="status">Status</label>
                                    <div>
                                        <div class="ul-form__radio-inline">
                                            <label class=" ul-radio__position radio radio-primary form-check-inline">
                                                <input type="radio" name="status" value="active" checked="checked">
                                                <span class="ul-form__radio-font">Active</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="ul-radio__position radio radio-primary">
                                                <input type="radio" name="status" value="inactive">
                                                <span class="ul-form__radio-font">Inactive</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="error" style="color:red;" id="status_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="auto_apply">Auto-Apply</label>
                                    <div>
                                        <label class="switch switch-primary me-3">
                                            <input type="checkbox" checked="" name="auto_applycheckbox"
                                                id="auto_applycheckbox" style="display: none;">
                                            <span class="slider"></span>
                                        </label>
                                        <div class="error" style="color:red;" id="auto_apply_error"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12 text-righ">
                    <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
                    <div class="btn-group dropdown float-right">
                        <button type="submit" class="btn btn-outline-primary erp-coupon-form">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        @else
            <form action="" id="coupon_form">
                <input type="hidden" name="id" value="{{ $coupon->id }}">
                <div class="col-lg-12 col-12">
                    <div class="card mt-2 mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input placeholder="Enter Coupon Code" class="form-control input-error"
                                        id="coupon_code" name="coupon_code" type="text"
                                        value="{{ $coupon->coupon_code }}" readonly>
                                    <div class="error" style="color:red;" id="coupon_code_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select class="form-control select2 input-error" id="discount_type"
                                        name="discount_type">
                                        <option value="">Select Discount Type</option>
                                        <option value="flat" {{ $coupon->discount_type == 'flat' ? 'selected' : '' }}>
                                            Flat</option>
                                        <option value="percentage"
                                            {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage
                                        </option>
                                    </select>
                                    <div class="error" style="color:red;" id="discount_type_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="discount_value">Discount Value</label>
                                    <input placeholder="Enter Discount Value" class="form-control input-error"
                                        id="discount_value" name="discount_value" type="number" min="0"
                                        step="0.01" value="{{ $coupon->discount_value ?? '' }}">
                                    <div class="error" style="color:red;" id="discount_value_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="max_discount">Max Discount</label>
                                    <input placeholder="Enter Max Discount" class="form-control input-error"
                                        id="max_discount" name="max_discount" type="number" min="0"
                                        step="1" value="{{ $coupon->max_discount ?? '' }}">
                                    <div class="error" style="color:red;" id="max_discount_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="valid_from">Discount Valid From</label>
                                    <input placeholder="Select Start Date" class="form-control input-error"
                                        id="valid_from" name="valid_from" type="date"
                                        value="{{ isset($coupon->valid_from) ? date('Y-m-d', strtotime($coupon->valid_from)) : '' }}">
                                    <div class="error" style="color:red;" id="valid_from_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="valid_until">Discount Valid Until</label>
                                    <input placeholder="Select Expiry Date" class="form-control input-error"
                                        id="valid_until" name="valid_until" type="date"
                                        value="{{ isset($coupon->valid_until) ? date('Y-m-d', strtotime($coupon->valid_until)) : '' }}">
                                    <div class="error" style="color:red;" id="valid_until_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="min_cart_amount">Minimum Purchase Amount</label>
                                    <input placeholder="Enter Minimum Purchase Amount" class="form-control input-error"
                                        id="min_cart_amount" name="min_cart_amount" type="number" min="0"
                                        step="0.01" value="{{ $coupon->min_cart_amount ?? '' }}">
                                    <div class="error" style="color:red;" id="min_cart_amount_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="applicable_type">Applicable Products</label>
                                    <select class="form-control select2 input-error" id="applicable_type"
                                        name="applicable_type">
                                        <option value="">Select Applicable Products</option>
                                        <option value="all" {{ $coupon->applicable_type == 'all' ? 'selected' : '' }}>
                                            All</option>
                                        <option value="category"
                                            {{ $coupon->applicable_type == 'category' ? 'selected' : '' }}>Specific
                                            Categories</option>
                                        <option value="sub-category"
                                            {{ $coupon->applicable_type == 'sub-category' ? 'selected' : '' }}>Specific
                                            Sub-Categories</option>
                                        <option value="product"
                                            {{ $coupon->applicable_type == 'product' ? 'selected' : '' }}>Specific Products
                                        </option>
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_type_error"></div>
                                </div>

                                <div class="col-md-12 form-group applicable_selection_container"
                                    id="applicable_selection_container"
                                    @if ($coupon->applicable_type == 'all') style="display: none" @endif>
                                    <label for="applicable_selection">Application Selection</label>
                                    <select class="form-control select2 input-error" id="applicable_selection"
                                        name="applicable_selection[]" multiple>
                                        @foreach ($applicableSelections as $id => $name)
                                            <option value="{{ $id }}" selected>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_selection_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="applicable_for">Applicable For</label>
                                    <select class="form-control select2 input-error" id="applicable_for"
                                        name="applicable_for">
                                        <option value="">Select Applicable For</option>
                                        <option value="one-time"
                                            {{ $coupon->applicable_for == 'one-time' ? 'selected' : '' }}>One-Time</option>
                                        <option value="recurring"
                                            {{ $coupon->applicable_for == 'recurring' ? 'selected' : '' }}>Recurring
                                        </option>
                                        <option value="both" {{ $coupon->applicable_for == 'both' ? 'selected' : '' }}>
                                            Both</option>
                                    </select>
                                    <div class="error" style="color:red;" id="applicable_for_error"></div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="limit_per_user">Limit Usage Per User</label>
                                    <input placeholder="Enter Limit Per User" class="form-control input-error"
                                        id="limit_per_user" name="limit_per_user" type="number" min="1"
                                        step="1" value="{{ $coupon->limit_per_user ?? '' }}">
                                    <div class="error" style="color:red;" id="limit_per_user_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="total_redemptions">Limit Total Redemptions</label>
                                    <input placeholder="Enter Total Redemptions Limit" class="form-control input-error"
                                        id="total_redemptions" name="total_redemptions" type="number" min="1"
                                        step="1" value="{{ $coupon->total_redemptions ?? '' }}">
                                    <div class="error" style="color:red;" id="total_redemptions_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="status">Status</label>
                                    <div>
                                        <div class="ul-form__radio-inline">
                                            <label class=" ul-radio__position radio radio-primary form-check-inline">
                                                <input type="radio" name="status" value="active"
                                                    {{ $coupon->status == 'active' ? 'checked="checked"' : '' }}>
                                                <span class="ul-form__radio-font">Active</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="ul-radio__position radio radio-primary">
                                                <input type="radio" name="status" value="inactive"
                                                    {{ $coupon->status == 'inactive' ? 'checked="checked"' : '' }}>
                                                <span class="ul-form__radio-font">Inactive</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="error" style="color:red;" id="status_error"></div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="auto_apply">Auto-Apply</label>
                                    <div>
                                        <label class="switch switch-primary me-3">
                                            <input type="checkbox" {{ $coupon->auto_apply == 'yes' ? 'checked=""' : '' }}
                                                name="auto_applycheckbox" id="auto_applycheckbox" style="display: none;">
                                            <span class="slider"></span>
                                        </label>
                                        <div class="error" style="color:red;" id="auto_apply_error"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12 text-righ">
                    <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
                    <div class="btn-group dropdown float-right">
                        <button type="submit" class="btn btn-outline-primary erp-coupon-form">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tagging.min.js') }}"></script>
    <script src="{{ asset('assets/js/tagging.script.js') }}"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#discount_type').select2({
                placeholder: "Select Discount Type",
                allowClear: true
            });

            $('#applicable_type').select2({
                placeholder: "Select Applicable Products",
                allowClear: true
            });

            $('#applicable_for').select2({
                placeholder: "Select Applicable For",
                allowClear: true
            });
        });

        $(document).ready(function() {
            let today = new Date().toISOString().split('T')[0];

            $("#valid_from").attr("min", today);
            $("#valid_until").attr("min", today);

            $("#valid_from").on("change", function() {
                $("#valid_until").attr("min", $(this).val());
            });
        });
    </script>
@endsection
@section('bottom-js')
    @include('pages.coupon.coupon-script');
@endsection
