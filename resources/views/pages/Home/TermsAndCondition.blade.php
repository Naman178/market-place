@extends('front-end.common.master')@section('title')
    <title>Market Place | Terms and Conditions</title>
    <style>
        .cust-page-padding {
            padding: 2rem 58px 5rem;
        }
        h1.feature_heading {
            margin-top: 0;
        }
        .terms-and-condition h1, .privacy-policy h1, .cancellation-and-refund-policy h1, .about-us h1 {
            margin-bottom: 50px;
        }
        .feature_heading {
            font-style: normal;
            font-weight: 600;
            font-size: 40px;
            line-height: 52px;
            color: #182433;
            margin: 80px 0 85px;
        }
    </style>
@endsection
@section('content')
    <div class="cust-page-padding">
        <div class="container">  
            <div class="row justify-content-center"> 
                <div class="terms-and-condition cust-page-padding">          
                    <h1 class="text-center feature_heading">Terms and Conditions</h1>
                    @foreach ($term_conditions as  $term_condition)
                        <h4>{{ $term_condition->title ?? '' }}</h4>        
                        <p>{{ $term_condition->description ?? '' }}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts') 
@endsection