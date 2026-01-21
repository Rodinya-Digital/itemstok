
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>@yield('title') - {{env('APP_NAME')}}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{asset('assets_connect/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets_connect/plugins/font-awesome/css/all.min.css')}}" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="{{asset('assets_connect/css/connect.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets_connect/css/dark_theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets_connect/css/custom.css')}}" rel="stylesheet">
    <!-- SEO Group Buy Modern Theme -->
    <link href="{{asset('assets_connect/css/seo-groupbuy-theme.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="auth-page sign-in">

<div class='loader'>
    <div class='spinner-grow text-primary' role='status'>
        <span class='sr-only'>Yükleniyor...</span>
    </div>
</div>
<div class="connect-container align-content-stretch d-flex flex-wrap">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<!-- Javascripts -->
<script src="{{asset('assets_connect/plugins/jquery/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets_connect/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets_connect/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets_connect/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets_connect/js/connect.min.js')}}"></script>
@yield('scripts')
</body>
</html>