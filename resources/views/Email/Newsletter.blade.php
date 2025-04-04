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
                <img src="{{ asset('storage/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
            @else
                <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
            @endif
            </div>
            <div class="header">                                                    
                <div class="title">
                    <h1>Successfully subscribe to newsletter</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="description">
                <p class="content">
                    <b>Hi {{$email}}</b>,  
                    <br>
                    Thank you for subscribing to {{$app_name}}! We're thrilled to have you on board🎉
                    <br><br>
                    You'll now be the first to receive exclusive updates, expert insights, and special offers straight to your inbox.
                    <br><br>
                    Stay tuned for exciting content coming your way soon! In the meantime, feel free to explore our <a href="https://market-place-main.infinty-stage.com/" target="_blank">website</a> and 
                    <a href="https://market-place-main.infinty-stage.com/" target="_blank">blogs</a>.
                    <br><br>
                    If you ever have any questions or feedback, don't hesitate to reach out to us at <a href="mailto:info@infinitysoftech.co">info@infinitysoftech.co</a>
                    Welcome to the community!
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
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/facebook.png') }}" alt="facebook"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="instagram"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/linkedin.png') }}" alt="linkedin"></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/youtube.png') }}" alt="youtube"></a>
                    </li>
                </ul>
            </div>
        </div>
    </section> --}}
    
    
<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    Successfully subscribe to newsletter
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
    <!-- LOGO -->
    <tr>
        <td align="center" style="padding: 20px;">
            @if ($setting && $setting['value']['logo_image'])
            <img src="{{ asset('storage/Logo_Settings/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
        @else
            <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
        @endif
        </td>
    </tr>
    
    <!-- HEADER -->
    <tr>
        <td align="center" bgcolor="#007AC1" style="padding: 20px; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 24px; font-weight: bold;">
            Successfully Subscribed to Newsletter
        </td>
    </tr>
    
    <!-- DESCRIPTION -->
    <tr>
        <td align="left" bgcolor="#ffffff" style="padding: 20px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px;">
            <p><b>Hi {{$email}}</b>,</p>
            <p>Thank you for subscribing to {{$app_name}}! We're thrilled to have you on board 🎉</p>
            <p>You'll now be the first to receive exclusive updates, expert insights, and special offers straight to your inbox.</p>
            <p>Stay tuned for exciting content coming your way soon! In the meantime, feel free to explore our 
                <a href="https://market-place-main.infinty-stage.com/" target="_blank">website</a> and 
                <a href="https://market-place-main.infinty-stage.com/" target="_blank">blogs</a>.
            </p>
            <p>If you ever have any questions or feedback, don't hesitate to reach out to us at 
                <a href="mailto:info@infinitysoftech.co">info@infinitysoftech.co</a>.
            </p>
            <p>Welcome to the community!</p>
        </td>
    </tr>
    
    <!-- FOOTER -->
    <tr>
        <td align="center" bgcolor="#007AC1" style="padding: 20px; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">
            Stay Up To Date And Follow Us On Social Media
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#007AC1" style="padding: 10px;">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/facebook.png') }}" alt="facebook" width="30"></a></td>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp" width="30"></a></td>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="instagram" width="30"></a></td>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter" width="30"></a></td>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/linkedin.png') }}" alt="linkedin" width="30"></a></td>
                    <td style="padding: 0 10px;"><a href="#"><img src="{{ asset('storage/Logo_Settings/youtube.png') }}" alt="youtube" width="30"></a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html> 