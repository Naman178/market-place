<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body{
            margin: 0;
            padding: 0;            
        }
        section{
            background: #EDF2F7;
            font-family: 'Poppins', sans-serif;
        }
        .header{
            background-color: #2A2742;
            padding: 1em 3em;
        }
        .discription{
            background-color: #fff;
            padding: 2em 3em;
        }
        .container{
            margin: 0 auto;
            width: 600px;
            padding: 0 8px;
            max-width: 96%;
        }
        .image{
            margin: 0px auto;
            width: 73%;
            text-align: center;
            padding: 30px 0;
        }
        .title h1{
            margin: 0;        
            color: white;
            padding: 0.7em 0 0;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .content{
            margin: 0;
            padding: 10px 0;
        }
        .logo{
            width: 12em;
        }
        .footer{
            background-color: #2A2742;
        }
        .footerContact{
            text-align: center;
            color: white;
        }
        .footerContact h4{
            margin: 0 auto;
            padding: 14px 0;
        }
        ul.social   {
            list-style: none;
            justify-content: center !important;
            padding: 0;
            margin: 0;
            padding-bottom: 25px;
        }
        li{
            margin: 0 5px;
            display: inline;
        }
        .footer-social-text{
            margin: 0;
            padding: 0;
            padding-top: 25px;
            padding-bottom: 15px;
            font-size: 18px;
        }
        .social img{
            width: 50px;
            padding: 10px;
            border-radius: 10px;
        }
        .social img:hover{
            background-color: #ffffff1c;
        }
        .footerContactList{
            list-style: none;
        }
        .footerContactList li{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .footerContactList img{
            width: 25px;
            margin-right: 10px;
        }
        .footerContactList a{
            text-decoration: none;
            color: #fff;
            font-size: 12px;
        }
        .footer h4{
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php
        $setting = \App\Models\Settings::where('key', 'site_setting')->first();
    ?>
    {{-- <section>
        <div class="container">
            <div class="image">
                @if ($setting && $setting['value']['logo_image'])
                    <img src="{{ url('https://market-place-main.infinty-stage.com/storage/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
                @else
                    <img src="{{ url('https://market-place-main.infinty-stage.com/front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
                @endif
            </div>
            <div class="header">                                                    
                <div class="title">
                    <h1>{{ $mailData['title'] ?? '' }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="discription">
                <p class="content">
                    Dear {{ $mailData['name'] ?? '' }} ,
                    <br>
                    Thank you for choosing our services and for topping up your wallet. We are delighted to inform you that your order has been successfully placed. We appreciate your trust in us and look forward to fulfilling your requirements.
                    <br>
                    Here are the details of your order:
                    <br>
                    Order ID: {{ $mailData['order_id'] ?? '' }}
                    <br>
                    Total Order: {{ $mailData['total_order'] ?? '' }}
                    <br>
                    Remaining Order: {{ $mailData['remaining_order'] ?? '' }}
                    <br>
                    Wallet Balance: {{ $mailData['wallet_amount'] ?? '' }}
                    <br>
                    By topping up your wallet, you have secured a convenient payment method for your current and future purchases. Your order is now in progress, and our dedicated team is working diligently to ensure a seamless experience for you.
                    <br>
                    Should you have any questions or require further assistance regarding your order or wallet balance, please don't hesitate to reach out to our customer support team. We are here to help you every step of the way.
                    <br>
                    Once again, thank you for your valued order and for choosing our services. We truly appreciate your business and look forward to serving you again in the future.
                    <br>
                    Best regards,
                    Skyfinity Quick Checkout
                </p>
            </div>
        </div>
    </section>
    <section>
        <div class="footerContact container">
            <div class="footer">                
                <p class="footer-social-text" style="color:#FFF;">Stay Up To Date And Follow Us On Social Media</p>
                <ul class="social" style="text-align: center !important;">
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/facebook.png') }}" alt="facebook"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/instagram.png') }}" alt="instagram"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/twitter.png') }}" alt="twitter"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/linkedin.png') }}" alt="linkedin"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/youtube.png') }}" alt="youtube"></a>
                    </li>
                </ul>
            </div>
        </div>
    </section> --}}

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
        <!-- Logo Section -->
        <tr>
            <td align="center" style="padding: 20px; background-color: #ffffff;">
                @if ($setting && $setting['value']['logo_image'])
                    <img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
                @else
                    <img src="{{ url('https://market-place-main.infinty-stage.com/front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
                @endif
            </td>
        </tr>
        
        <!-- Header Section -->
        <tr>
            <td align="center" bgcolor="#007AC1" style="padding: 20px; color: #ffffff; font-size: 24px; font-weight: bold;">
                {{ $mailData['title'] ?? '' }}
            </td>
        </tr>
        
        <!-- Description Section -->
        <tr>
            <td bgcolor="#ffffff" style="padding: 20px; font-size: 16px; color: #666666;">
                <p>Dear {{ $mailData['name'] ?? '' }},</p>
                <p>Thank you for choosing our services and for topping up your wallet. Your order has been successfully placed.</p>
                <p>Here are the details of your order:</p>
                <ul>
                    <li><strong>Order ID:</strong> {{ $mailData['order_id'] ?? '' }}</li>
                    <li><strong>Total Order:</strong> {{ $mailData['total_order'] ?? '' }}</li>
                    <li><strong>Remaining Order:</strong> {{ $mailData['remaining_order'] ?? '' }}</li>
                    <li><strong>Wallet Balance:</strong> {{ $mailData['wallet_amount'] ?? '' }}</li>
                </ul>
                <p>Your order is now in progress. If you need any assistance, please reach out to our customer support team.</p>
                <p>Thank you for your business!</p>
                <p><strong>Best regards,<br>Market Place Checkout</strong></p>
            </td>
        </tr>
        
        <!-- Social Media Section -->
        <tr>
            <td bgcolor="#007AC1" align="center" style="padding: 20px; color: #ffffff; font-size: 16px;">
                <p>Stay Up To Date And Follow Us On Social Media</p>
                <p>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/facebook.png') }}" alt="facebook" width="30"></a>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp" width="30"></a>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/instagram.png') }}" alt="instagram" width="30"></a>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/twitter.png') }}" alt="twitter" width="30"></a>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/linkedin.png') }}" alt="linkedin" width="30"></a>
                    <a href="#"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/youtube.png') }}" alt="youtube" width="30"></a>
                </p>
            </td>
        </tr>
    </table>
</body>
</html> 