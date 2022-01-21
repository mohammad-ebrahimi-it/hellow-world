<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/bootstraprtl-v4.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @yield('links')
    <script src="{{asset('js/app.js')}}"></script>
    <title>@yield('title')</title>
</head>

<body>
<!-- Nav Menu -->
@include('partials.navbar')
@if(session('mustVerifyEmail'))
    <div class="alert alert-danger text-center">

        @lang('auth.you must verify your email', ['link' => route('auth.email.send.verification')])
    </div>
@endif
@if(session('verificationEmailSend'))
    <div class="alert alert-success text-center">
        @lang('auth.verification email sent')
    </div>
@endif
<div class="container">
    @yield('content')
</div>
</body>

</html>
