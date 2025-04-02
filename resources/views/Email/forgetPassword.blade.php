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
                    <h1>Password Reset</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="discription">
                <p class="content">
                    You can reset password from bellow link: <a href="{{ route('reset-password-get', $token) }}">Reset Password</a>
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
    Reset your password
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td bgcolor="#f4f4f4" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                <tr>
                    <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
                        @if ($setting && $setting['value']['logo_image'])
                            <img src="{{ asset('storage/Logo_Settings/' . $setting['value']['logo_image']) }}" alt="logo" class="logo">
                        @else
                            <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="logo" class="logo">
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- HERO -->
   <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#007AC1" align="center" valign="top" style="padding: 20px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                        <h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px; color: #ffffff;">Reset your password</h1>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- COPY BLOCK -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                  <p style="margin: 0;">We're excited to have you get started. First, you need to confirm your account. Just press the button below.</p>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td align="center" style="border-radius: 3px;" bgcolor="#007AC1"><a href="{{ route('reset-password-get', $token) }}" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #007AC1; display: inline-block;">Reset Password</a></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                  <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy to help out.</p>
                </td>
              </tr>
              <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                  <p style="margin: 0;">Thanks,<br>The Support Team</p>
                </td>
              </tr>
            </table>
        </td>
    </tr>
    <!-- FOOTER -->
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
           <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #007AC1;">
    <tr>
        <td align="center" style="padding: 30px; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/facebook.png') }}" alt="facebook" width="30"></a>
                    </td>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/whatsapp.png') }}" alt="whatsapp" width="30"></a>
                    </td>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="instagram" width="30"></a>
                    </td>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter" width="30"></a>
                    </td>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/linkedin.png') }}" alt="linkedin" width="30"></a>
                    </td>
                    <td style="padding: 0 10px;">
                        <a href="#"><img src="{{ asset('storage/Logo_Settings/youtube.png') }}" alt="youtube" width="30"></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        </td>
    </tr>
</table>
</body>
</html> 