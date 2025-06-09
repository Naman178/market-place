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
        body {
            margin: 0;
            padding: 0;
        }

        section {
            background: #EDF2F7;
            font-family: 'Poppins', sans-serif;
        }

        .header {
            background-color: rgb(0, 110, 255);
            padding: 1em 3em;
        }

        .discription {
            background-color: #fff;
            padding: 2em 3em;
        }

        .container {
            margin: 0 auto;
            width: 600px;
            padding: 0 8px;
            max-width: 96%;
        }

        .image {
            margin: 0px auto;
            width: 73%;
            text-align: center;
        }

        .title {
            color: white;
            padding: 0.7em 0 0;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .title h1 {
            margin: 0;
        }

        .content {
            margin: 0;
            padding: 10px 0;
        }

        .logo {
            width: 12em;
        }

        .footer {
            background-color: #131313;
            padding-top: 20px;
        }

        .footerContact {
            text-align: center;
            color: white;
        }

        .footerContact h4 {
            margin: 0 auto;
            padding: 14px 0;
        }

        ul.social {
            list-style: none;
            justify-content: center !important;
            padding: 0;
            margin: 0;
            padding-bottom: 25px;
        }

        li {
            margin: 0 5px;
            display: inline;
        }

        .footer-social-text {

            padding-top: 2px;
            padding-bottom: 5px;
            font-size: 10px;
        }

        .social img {
            width: 30px;
            padding: 8px;
            background-color: #000;
            border-radius: 10px;
        }

        .social img:hover {
            background-color: #ffffff1c;
        }

        .footerContactList {
            list-style: none;
        }

        .footerContactList li {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .footerContactList img {
            width: 20px;
            margin-right: 8px;
        }

        .footerContactList a {
            text-decoration: none;
            color: #fff;
            font-size: 5px;
        }

        .footer h4 {
            font-size: 5px;
        }
    </style>
</head>

<body>
    <?php
    $setting = \App\Models\Settings::where('key','site_setting')->first();
    ?>
    {{-- <section>
        <div class="container">
            <div class="header">
                <div class="image">
                    @if ($setting && $setting['value']['logo_image'])
                        <img src="{{ asset('storage/Logo_Settings/'.$setting['value']['logo_image']) }}" alt="logo"
                        style="width: 8rem;">
                    @else
                            <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="logo"
                            style="width: 8rem;">
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="discription">
                <p class="content">
                    {!! nl2br($mailData['desc']) !!}
                </p>
            </div>
        </div>
    </section>
    <section>
        <div class="footerContact container">
            <div class="footer">
                <p class="footer-social-text" style="font-size: 14px;">Connect With Us</p>
                <ul class="footerContactList">
                    <li><img src="{{ asset('storage/Logo_Settings/support.png') }}" alt="support"
                            style="width: 25px; margin-right: 10px;"> <a href="tel:04132331199"
                            style="font-size: 12px;">0413 - 2331199</a></li>
                    <li><img src="{{ asset('storage/Logo_Settings/pin.png') }}" alt="pin"
                            style="width: 25px; margin-right: 10px;"> <a href="#" style="font-size: 12px;">First
                            Floor, 32, Kamatchi Amman
                            Kovil Street,
                            White Town, Puducherry, 605001.</a></li>
                </ul>
                <p class="footer-social-text" style="font-size: 14px;">Stay Up To Date And Follow Us On Social Media</p>
                <ul class="social" style="justify-content: center !important;">
                    <li>
                        <a href="https://www.facebook.com/vnetindia"><img
                                src="{{ asset('storage/Logo_Settings/facebook.png') }}" alt="facebook"></a>
                    </li>
                    <li>
                        <a
                            href="https://api.whatsapp.com/send/?phone=%2B916374180749&text&type=phone_number&app_absent=0"><img
                                src="{{ asset('storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp"></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/vnetindia/"><img
                                src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="instagram"></a>
                    </li>
                    <li>
                        <a href="https://twitter.com/vnetindia"><img
                                src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter"></a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/vnetindia"><img
                                src="{{ asset('storage/Logo_Settings/linkedin.png') }}" alt="linkedin"></a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCCg8T7067jaGOcO11mfkRwQ"><img
                                src="{{ asset('storage/Logo_Settings/youtube.png') }}" alt="youtube"></a>
                    </li>
                </ul>
            </div>
        </div>
    </section> --}}

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
    <!-- Header Section -->
    <tr>
        <td align="center" style="padding: 20px;">
            @if ($setting && $setting['value']['logo_image'])
                <img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
            @else
                <img src="{{ url('https://market-place-main.infinty-stage.com/front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
            @endif
        </td>
    </tr>
    
    <!-- Description Section -->
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px; color: #666666; font-family: Arial, sans-serif; font-size: 18px; line-height: 25px;">
            <p style="margin: 0;">{!! nl2br($mailData['desc']) !!}</p>
        </td>
    </tr>
    
    <!-- Footer Contact Section -->
    <tr>
        <td bgcolor="#007AC1" align="center" style="padding: 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
            <p>Connect With Us</p>
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/support.png') }}" alt="support" width="25"></td>
                    <td><a href="tel:04132331199" style="color: #ffffff; text-decoration: none;">0413 - 2331199</a></td>
                </tr>
                <tr>
                    <td><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/pin.png') }}" alt="pin" width="25"></td>
                    <td><a href="#" style="color: #ffffff; text-decoration: none;">First Floor, 32, Kamatchi Amman Kovil Street, White Town, Puducherry, 605001.</a></td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!-- Social Media Section -->
    <tr>
        <td bgcolor="#007AC1" align="center" style="padding: 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
            <p>Stay Up To Date And Follow Us On Social Media</p>
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td><a href="https://www.facebook.com/vnetindia"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/facebook.png') }}" alt="facebook" width="30"></a></td>
                    <td><a href="https://api.whatsapp.com/send/?phone=%2B916374180749&text&type=phone_number&app_absent=0"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp" width="30"></a></td>
                    <td><a href="https://www.instagram.com/vnetindia/"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/instagram.png') }}" alt="instagram" width="30"></a></td>
                    <td><a href="https://twitter.com/vnetindia"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/twitter.png') }}" alt="twitter" width="30"></a></td>
                    <td><a href="https://www.linkedin.com/company/vnetindia"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/linkedin.png') }}" alt="linkedin" width="30"></a></td>
                    <td><a href="https://www.youtube.com/channel/UCCg8T7067jaGOcO11mfkRwQ"><img src="{{ url('https://market-place-main.infinty-stage.com/storage/Logo_Settings/youtube.png') }}" alt="youtube" width="30"></a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>

</html>
