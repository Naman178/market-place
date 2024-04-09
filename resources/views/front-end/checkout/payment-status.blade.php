@extends('front-end.common.master')
@section('title', 'Payment Status')

@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');

        /* *{
            margin: 0 auto;
        } */
        .payment-status{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        .img-fluid{
            width: 100%;
            font-family:
        }

        .payment-status > span{
            font-family: "Lobster", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 60px
        }

        .payment-status > div {
            display: flex;
            justify-content: center;
            align-content: center;
            width: 80%;
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="payment-status">
            <div>
                <img class="img-fluid" src="{{ asset('assets/images/payment/payment-success.jpg') }}" alt="payment-success"/>
            </div>
            {{-- <span class="">Payment Successfull</span> --}}
        </div>
    </section>
@endsection
