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
    <section>
        <div class="container">
            <div class="image">
                <img src="{{ asset('front-end/images/header_logo.png') }}" alt="logo">
            </div>
            <div class="header">                                                    
                <div class="title">
                    <h1>Registration Successful!</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="description">
                <p class="content">
                    Thank you for registering with Skyfinity Quick Checkout!
                    <br>
                    Please use the credentials below to log in to your account:
                    <br><br>
                    Email: {{ $user->email }} <!-- Now using the user object passed in the email -->
                    <br>
                    Password: {{ $generatedPassword }} <!-- Use the generated password -->
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
    </section>
</body>
</html> 