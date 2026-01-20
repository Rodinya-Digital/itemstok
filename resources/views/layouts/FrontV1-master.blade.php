<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="layout-menu-fixed layout-compact " dir="ltr"
      data-theme="theme-default" data-assets-path="{{asset('FrontV1')}}/">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>@yield('title', 'Stokla.net') &mdash; {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('FrontV1/img/favicon/favicon.ico')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="{{asset('FrontV1/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap')}}"
          rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/tabler-icons.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/flag-icons.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/shepherd/shepherd.css')}}"/>

    <script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>

    <!-- Core CSS -->
    @if(\Illuminate\Support\Facades\Auth::user()->theme_mode=='dark')
        <link rel="stylesheet" href="{{asset('FrontV1/vendor/css/rtl/core-dark.css')}}"
              class="template-customizer-core-css">
        <link rel="stylesheet" href="{{asset('FrontV1/vendor/css/rtl/theme-default-dark.css')}}"
              class="template-customizer-theme-css">
        <link rel="stylesheet" href="{{asset('FrontV1/css/demo.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('FrontV1/vendor/css/rtl/core.css')}}" class="template-customizer-core-css">
        <link rel="stylesheet" href="{{asset('FrontV1/vendor/css/rtl/theme-default.css')}}"
              class="template-customizer-theme-css">
        <link rel="stylesheet" href="{{asset('FrontV1/css/demo-1.css')}}">
    @endif


    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet"
          href="{{asset('FrontV1/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/node-waves/node-waves.css')}}">

    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/libs/typeahead-js/typeahead.css')}}">


    <!-- Page CSS -->

    <link rel="stylesheet" href="{{asset('FrontV1/vendor/css/pages/page-icons.css')}}">


    <!-- Helpers -->
    <script src="{{asset('FrontV1/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('FrontV1/js/config.js')}}"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SL4K84LMJB"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-SL4K84LMJB');
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        Tawk_API.visitor = {
            name: '{{auth()->user()->name.' '.auth()->user()->surname}}',
            email: '{{auth()->user()->email}}'
        };
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6712a9414304e3196ad3e229/1iagea9ub';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "3ef08bd4-96d8-424c-a6a4-706409218de1",
            });
        });
    </script>

</head>

<body>
{{--<script src="{{asset('snow.js')}}" type="text/javascript"></script>--}}

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">


        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">


            <div class="app-brand demo ">
                <a href="/" class="app-brand-link">
          <span class="app-brand-logo demo">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="500.000000pt" height="500.000000pt"
     viewBox="0 0 500.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g
            transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#3498db" stroke="none"> <path
                d="M1055 4959 c-154 -22 -356 -101 -496 -194 -93 -63 -216 -180 -290 -277 -111 -149 -203 -370 -228 -552 -15 -107 -15 -2765 0 -2872 33 -237 148 -475 316 -654 184 -196 447 -333 707 -369 107 -15 2765 -15 2872 0 182 25 403 117 552 228 97 74 214 197 277 290 96 146 171 340 194 505 15 107 15 2765 0 2872 -25 182 -117 403 -228 552 -74 97 -197 214 -290 277 -146 96 -340 171 -505 194 -95 13 -2790 13 -2881 0z m2648 -1200 c140 -47 268 -142 337 -249 102 -158 109 -435 16 -594 -121 -207 -326 -319 -562 -308 -26 2 -34 9 -50 44 -31 69 -129 194 -235 300 -55 55 -99 101 -99 103 0 3 105 5 234 5 225 0 234 1 267 23 47 31 73 86 64 138 -8 49 -59 103 -105 113 -54 10 -999 7 -1070 -4 -84 -14 -196 -67 -255 -121 -88 -81 -144 -243 -130 -372 15 -137 56 -200 243 -368 189 -170 215 -202 220 -278 10 -138 -96 -251 -234 -251 -80 0 -130 36 -341 246 -179 179 -204 207 -240 279 -67 132 -85 201 -90 357 -8 216 25 383 104 517 50 85 188 230 274 286 87 59 202 111 292 135 67 17 118 19 685 19 595 1 614 0 675 -20z m-968 -728 c79 -37 368 -316 461 -447 92 -128 137 -295 137 -499 0 -156 -20 -244 -88 -381 -113 -230 -306 -386 -565 -456 -84 -23 -89 -23 -715 -23 -719 0 -686 -4 -823 88 -119 80 -212 209 -247 344 -20 76 -19 225 1 294 42 143 172 309 291 372 70 37 192 67 273 67 l66 0 60 -96 c58 -96 187 -239 284 -317 l45 -36 -250 -1 c-233 0 -252 -1 -283 -20 -83 -51 -86 -181 -5 -236 26 -18 58 -19 568 -22 565 -3 608 -1 689 40 65 33 178 155 217 233 32 65 34 76 33 165 -1 168 -47 248 -248 427 -188 168 -209 196 -214 282 -4 74 9 117 52 167 58 70 175 95 261 55z"/> </g> </svg>
</span>
                    <span class="app-brand-text demo menu-text fw-bold">Stokla.net</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                    <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>


            <ul class="menu-inner py-1">

                @if(auth()->user()->hasRole('Admin'))
                    <li class="menu-item {{ Request::route()->getName() == 'VOLT_API.EnvatoElementsCheckerList' ? ' active' : '' }}">
                        <a href="{{ route('VOLT_API.EnvatoElementsCheckerList') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-list"></i>
                            <div>{{__("Envato ACC. Checker")}}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::route()->getName() == 'VOLT_API.EnvatoElements' ? ' active' : '' }}">
                        <a href="{{ route('VOLT_API.EnvatoElements') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-server"></i>
                            <div>{{__("Envato C. Server")}}</div>
                        </a>
                    </li>
                    <li class="menu-item @if(in_array(Request::route()->getName(),['panel.admin.dashboard','panel.cookie.mnt','panel.users','panel.managekeys.index','panel.services.index','panel.getFeedBacks'])) active open @endif"
                        style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-settings"></i>
                            <div>Yönetim</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::route()->getName() == 'panel.admin.dashboard' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.admin.dashboard') }}">
                                    <div>{{__("Dashboard")}}</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::route()->getName() == 'panel.cookie.mnt' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.cookie.mnt') }}">
                                    <div>{{__("Cookie Management")}}</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::route()->getName() == 'panel.users' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.users') }}">
                                    <div>{{__("Users")}}</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::route()->getName() == 'panel.managekeys.index' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.managekeys.index') }}">
                                    <div>{{__("Keys")}}</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::route()->getName() == 'panel.services.index' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.services.index') }}">
                                    <div>{{__("Services")}}</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::route()->getName() == 'panel.getFeedBacks' ? ' active' : '' }}">
                                <a class="menu-link" href="{{ route('panel.getFeedBacks') }}">
                                    <div>{{__("Feedbacks")}}</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small">
                        <span class="menu-header-text">Customer</span>
                    </li>
                @endif
                <li class="menu-item">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#AddBalanceModal"
                       class="menu-link" style="background-color: #000;color:#fff">
                        <i class="menu-icon tf-icons ti ti-cash"></i>
                        <div>{{__("Balance")}} : <b>{{number_format(auth()->user()->balance,2)}} ₺</b> &nbsp;&nbsp;<span
                                    class="badge bg-label-success"><i class="fa fa-plus"></i></span></div>
                    </a>

                </li>
                @if(auth()->user()->dealer=='1')
                    <li class="menu-item {{ Request::route()->getName() == 'panel.dealerKeys' ? ' active' : '' }}">
                        <a href="{{ route('panel.dealerKeys') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-home"></i>
                            <div>{{__("Dealer Keys")}}</div>
                        </a>
                    </li>
                @endif

                <li class="menu-item {{ Request::route()->getName() == 'panel.user.dashboard' ? ' active' : '' }}">
                    <a href="{{ route('panel.user.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-home"></i>
                        <div>{{__("Dashboard")}}</div>
                    </a>
                </li>
                @if(env('FEEDBACK_SYSTEM_STATUS')=='1')
                    <li class="menu-item {{ Request::route()->getName() == 'panel.getFeedBacksUser' ? ' active' : '' }}">
                        <a class="menu-link " href="{{ route('panel.getFeedBacksUser') }}">
                            <i class="menu-icon tf-icons ti ti-rss"></i>
                            <div>{{__("Feedbacks")}}</div>
                        </a>
                    </li>
                @endif
                <li class="menu-item {{ Request::route()->getName() == 'panel.service.licenseCenter' ? ' active' : '' }}">
                    <a href="{{ route('panel.service.licenseCenter') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-certificate"></i>
                        <div>{{__("Lisans İndir")}}</div>
                    </a>
                </li>
                @if(auth()->user()->ref==null)
                        <li class="menu-item">
                            <a href="https://forms.gle/nMXXF6dTBT2LK4qt7"  style="background-color: #000;color:#fff" target="_blank" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-certificate"></i>
                                <div>{{__("Bayimiz olun")}}</div>
                            </a>
                        </li>
                @endif


                <li class="menu-header small">
                    <span class="menu-header-text">{{__('Store')}}</span>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.shop' ? ' active' : '' }}">
                    <a href="{{ route('panel.shop') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shopping-bag"></i>
                        <div>{{__("Store")}}
                            <span class="badge bg-label-success"><i
                                        class="fa fa-check"></i> {{__('Instant Delivery')}}</span>
                        </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#usingKeyModal" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-square-key"></i>
                        <div>{{__("Using Key")}}</div>
                    </a>
                </li>
                <li class="menu-header small">
                    <span class="menu-header-text">{{__('Whatsapp Support')}}</span>
                </li>
                @if(auth()->user()->ref=='7728')
                    <li class="menu-item">
                        <a href="https://wa.me/261349977393" style="background-color: #09a61b" class="menu-link"
                           target="_blank">
                            <i class="text-white menu-icon fa-brands fa-whatsapp"></i>
                            <div class="text-white">{{__("Whatsapp Support")}}</div>
                        </a>
                    </li>
                @else
                    <li class="menu-item">
                        <a href="https://wa.me/908503094032" style="background-color: #09a61b" class="menu-link"
                           target="_blank">
                            <i class="text-white menu-icon fa-brands fa-whatsapp"></i>
                            <div class="text-white">{{__("Whatsapp Support")}}</div>
                        </a>
                    </li>
                @endif

                <li class="menu-header small">
                    <span class="menu-header-text">{{__('Services')}}</span>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.service.otherServices' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-download"></i>
                        <div>{{__("Other Services")}}</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.service.envatoelements' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.envatoelements') }}" class="menu-link">
                        <svg style="width: 24px;height: 24px;margin-right: 5px;" id="Layer_1"
                             data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 107.65 122.88">
                            <defs>
                                <style>.cls-1 {
                                        fill: #82b541;
                                    }</style>
                            </defs>
                            <title>envato</title>
                            <path class="cls-1"
                                  d="M91.76,1C88.16-1,77.83.18,65.44,4c-21.7,14.83-40,36.69-41.29,71.78-.24.83-2.38-.12-2.8-.38-5.86-11.23-8.18-23.06-3.29-40.12.91-1.51-2.07-3.38-2.61-2.85a61.75,61.75,0,0,0-8.52,11C-7.81,69,1.83,101.78,27.62,116.12a53.44,53.44,0,0,0,72.69-20.69C116.92,65.66,101.5,6.38,91.76,1Z"></path>
                        </svg>
                        <div>Envato Elements</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.service.freepik' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.freepik') }}" class="menu-link">
                        <svg style="width: 24px;height: 24px;margin-right: 5px;" id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 266 223.5" width="2500"
                             height="2101">
                            <style>.st0 {
                                    fill: #1e61c6
                                }

                                .st1 {
                                    fill: #1e60c6
                                }

                                .st2 {
                                    fill: #2163c7
                                }

                                .st3 {
                                    fill: #2162c6
                                }</style>
                            <title>freepik</title>
                            <g id="Cwb6Ph.tif">
                                <path class="st0"
                                      d="M46.3 157.8c-1-5.4-2.3-10.7-3-16.1-2.8-21.1 1.7-40.6 14.2-58C67.3 70 80.7 60.5 96.1 53.9c18.5-7.9 38.4-12.2 58.5-12.6 17.9-.5 33.5 6.1 47.1 17.3 14 11.6 24.8 25.9 33.1 42 4 7.8 7.7 15.8 11.5 23.8.4.9.7 1.9.9 2.9-5.3 3.2-10.4 6.5-15.8 9.4-20 11-41.6 18.5-64.1 22.4-12.3 2.1-24.7 3.3-37.1 4.1-11.8.8-23.6 1.2-35.4.9-16.1-.4-32.1-2.9-48.5-6.3zm25.4-53.6c-.3 17.6 14 31.8 31.4 32 16.8.2 32.5-12.7 32.5-31.6 0-19.6-15.1-32-32-32-17.5 0-31.8 14.1-31.9 31.6zm122.9 9.2c9.5.7 20.1-7.2 20.2-20.2.1-10.8-8.6-19.6-19.4-19.7h-.4c-11-.2-20 8.6-20.2 19.5v.3c0 11.4 8.5 20.1 19.8 20.1z"></path>
                                <path class="st1"
                                      d="M247.8 131.8c1.4 16.8-2.8 31.6-11.2 45.2-11.4 18.4-28.4 30-48.4 37.3-20.4 7.4-42.1 10.3-63.7 8.7-12.9-.9-25.9-2.8-37.5-8.9-20-10.6-32.4-27.5-38.9-49-.3-1.3-.4-2.7-.5-4 70.5 16.3 137.4 9.1 200.2-29.3z"></path>
                                <path class="st2"
                                      d="M244.5 70.7c5.2-1.9 5.2-2 4.7-6.9-.3-2.8-.4-5.6 1-8.3.6-1.1.5-2.5.6-3.8.2-4 3.5-7.1 7.5-7.1s7.4 3.2 7.6 7.2c0 4-3.2 7.3-7.2 7.5-1.3.1-2.6 0-4.4 0-.2 2-.6 3.8-.4 5.5.6 4.9-.2 9-5.8 11.1l11.4 20.2-17.1 10.6C235.2 90 224.2 76.2 211 63.6l10.2-12.4c9.5 4.5 16.6 11.7 23.3 19.5zM38.7 132.6L22.1 127c-.8-10 1.3-19.3 5-28.4l-5.8-9.2c-2.1 0-4.2.4-6-.1-4-.9-7.9-2.1-11.6-3.6C.8 84.5-.5 80.5.3 77.6c1.1-3.5 4.4-5.7 8-5.4 3.4.3 6.2 2.9 6.7 6.3.2 1.6 0 3.3 0 5.3h8.8c3.7 1.5 3.5 6 6.3 8.9 5.5-7.2 10.9-14.4 19.1-19.5l7.6 5.9c-5.8 8-12 15.5-14.1 24.8-2.1 9.4-2.7 18.8-4 28.7z"></path>
                                <path class="st3"
                                      d="M106.7 48.2l-3.4-8.4c9.4-7.5 20.1-10.6 31.4-12.1.2-3-1.3-4.3-3.6-5.5-7.8-4-9.1-13.4-2.9-19.1 3.7-3.4 8.1-3.9 12.5-2.2 4 1.4 6.8 5.1 7.1 9.4.7 4.6-1.5 9.1-5.5 11.4-1.1.6-2.3 1.1-3.4 1.6l1.2 3.8c10.1-.2 20-.1 29.8 3.8l-1.4 8.3c-20.7.1-41.7-1-61.8 9z"></path>
                            </g>
                        </svg>
                        <div>Freepik Premium {{--&nbsp;&nbsp;<span class="badge bg-label-success">{{__('V8')}}&nbsp;<i
                                        class="fa fa-check"></i></span>--}}</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.service.motionarray' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.motionarray') }}" class="menu-link">
                        <svg style="background: purple; width: 24px;height: 24px;margin-right: 5px;"
                             version="1.0" xmlns="http://www.w3.org/2000/svg" width="28.000000pt"
                             height="28.000000pt" viewBox="0 0 128.000000 128.000000"
                             preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
                               fill="#ffffff" stroke="none">
                                <path d="M0 640 l0 -640 640 0 640 0 0 640 0 640 -640 0 -640 0 0 -640z m415 73 c26 -71 51 -132 55 -136 4 -4 29 53 56 127 l49 136 58 0 57 0 0 -201 0 -200 -42 3 -43 3 -5 113 -5 112 -44 -115 -43 -115 -37 0 -37 0 -44 117 -45 117 -5 -114 -5 -115 -42 -3 -43 -3 0 200 0 201 59 0 58 0 48 -127z m530 13 c45 -19 55 -42 55 -129 0 -57 4 -76 15 -81 9 -3 15 -19 15 -41 0 -33 -2 -35 -34 -35 -19 0 -42 7 -50 15 -14 14 -18 14 -45 0 -97 -50 -207 29 -161 116 17 30 64 49 125 49 56 0 65 8 46 39 -13 20 -71 18 -86 -2 -18 -25 -85 -23 -85 1 0 19 29 51 65 70 28 16 99 15 140 -2z"></path>
                                <path d="M838 559 c-35 -20 -17 -59 28 -59 19 0 54 36 54 55 0 18 -55 20 -82 4z"></path>
                            </g>
                        </svg>
                        <div>{{__("Motion Array")}} {{--&nbsp;&nbsp;<span class="badge bg-label-success">{{__('New Ver.')}}</span>--}}</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::route()->getName() == 'panel.service.epidemicsound' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.epidemicsound') }}" class="menu-link">
                        <svg style="margin-right: 5px;" fill="#000"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px"
                             height="24px">
                            <path d="M 14.275391 2.0019531 C 11.365107 2.045791 8.5075 3.1841406 6.359375 5.3066406 C 4.192375 7.4496406 3 10.296125 3 13.328125 C 3 16.358125 4.192375 19.207609 6.359375 21.349609 L 6.7265625 21.710938 C 6.9135625 21.895938 7.1656875 22 7.4296875 22 L 13.345703 22 C 13.750703 22 14.115531 21.755859 14.269531 21.380859 C 14.423531 21.005859 14.336828 20.574063 14.048828 20.289062 L 10.724609 17.003906 C 9.7306094 16.020906 9.1835938 14.716125 9.1835938 13.328125 C 9.1835937 11.941125 9.7306094 10.635344 10.724609 9.6523438 C 12.571532 7.8287205 15.450849 7.646168 17.509766 9.0898438 L 11.40625 15.298828 C 11.12425 15.585828 11.041266 16.014719 11.197266 16.386719 C 11.352266 16.757719 11.716141 16.998047 12.119141 16.998047 L 19 16.998047 C 19.553 16.998047 20 16.551047 20 15.998047 L 20 9.046875 L 20 4.03125 C 20 3.64625 19.777687 3.2949062 19.429688 3.1289062 C 17.786438 2.3440313 16.021561 1.9756504 14.275391 2.0019531 z"/>
                        </svg>
                        <div>{{__("Epidemic Sound")}}</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::route()->getName() == 'panel.service.shutterstock' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.shutterstock') }}" class="menu-link">
                        <svg style="width: 24px;height: 24px;enable-background:new 0 0 396.918 396.918;margin-right: 5px;"
                             version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 396.918 396.918" xml:space="preserve"> <path
                                    style="fill:#FF1A03;"
                                    d="M0,22.652v351.614c0,12.51,10.141,22.652,22.652,22.652h351.614c12.51,0,22.652-10.141,22.652-22.652 V22.652C396.917,10.141,386.776,0,374.266,0H22.652C10.141,0,0,10.141,0,22.652z M180.96,108.222h-62.29 c-6.256,0-11.344,5.088-11.344,11.344v59.92H55.353v-59.92c0-34.912,28.405-63.317,63.317-63.317h62.291L180.96,108.222 L180.96,108.222z M341.565,277.352c0,34.912-28.405,63.317-63.317,63.317h-62.291v-51.973h62.291 c6.256,0,11.344-5.088,11.344-11.344v-59.92h51.973L341.565,277.352L341.565,277.352z"></path> </svg>
                        <div>{{__("ShutterStock")}}</div>
                    </a>
                </li>
                {{--<li class="menu-item {{ Request::route()->getName() == 'panel.service.adobestock' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.adobestock') }}" class="menu-link">
                        <svg style="width: 29px;height: 30px;margin-right: 1px;" version="1.1"
                             id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 190 190" xml:space="preserve"> <path class="st0"
                                                                               d="M0 122V27.4c0-1.8.1-3.6.5-5.3s.9-3.5 1.6-5.1 1.5-3.2 2.5-4.8S6.8 9.3 8 8c1.3-1.3 2.7-2.4 4.2-3.4s3.1-1.9 4.8-2.5c1.7-.7 3.4-1.2 5.1-1.6 1.8-.4 3.5-.5 5.3-.5h100.2c1.8 0 3.6.1 5.3.5 1.8.4 3.5.9 5.1 1.6s3.2 1.5 4.8 2.5 2.9 2.2 4.2 3.4c1.3 1.3 2.4 2.7 3.4 4.2s1.9 3.1 2.5 4.8c.7 1.7 1.2 3.4 1.6 5.1.4 1.8.5 3.5.5 5.3V122c0 1.8-.1 3.6-.5 5.3-.4 1.8-.9 3.5-1.6 5.1-.7 1.7-1.5 3.2-2.5 4.8s-2.2 2.9-3.4 4.2c-1.3 1.3-2.7 2.4-4.2 3.4s-3.1 1.9-4.8 2.5c-1.7.7-3.4 1.2-5.1 1.6-1.8.4-3.5.5-5.3.5H27.5c-1.8 0-3.6-.1-5.3-.5-1.8-.4-3.5-.9-5.1-1.6-1.7-.7-3.2-1.5-4.8-2.5s-2.9-2.2-4.2-3.4c-1.3-1.3-2.4-2.7-3.4-4.2s-1.9-3.1-2.5-4.8c-.7-1.7-1.2-3.4-1.6-5.1-.4-1.6-.6-3.4-.6-5.3z"/>
                            <path d="M54.9 109.6c-3.8 0-7.3-.4-10.4-1-3.1-.6-5.7-1.5-7.9-2.5-.6-.3-.8-.9-.8-1.7V92.2c0-.3.1-.4.3-.6.1-.1.4-.1.6.1 2.9 1.8 5.9 3.1 9.1 4 3.2.9 6.3 1.3 9.4 1.3 3.9 0 6.7-.6 8.4-1.8 1.7-1.2 2.5-2.7 2.5-4.5 0-1.2-.3-2.2-.8-3.1-.6-.9-1.5-1.8-2.9-2.7-1.4-.9-3.2-1.8-5.6-2.7L51.7 80c-4.2-1.8-7.4-3.7-9.8-5.7-2.4-2-4-4.2-4.8-6.5-.9-2.3-1.4-4.8-1.4-7.5 0-3.7.9-7.1 2.7-10 1.9-3 4.5-5.4 8.2-7.1 3.6-1.7 8.2-2.6 13.6-2.6 3.2 0 6.3.2 9.2.6 2.8.4 5.1 1.1 6.8 1.9.5.3.7.7.7 1.3V56c0 .1-.1.3-.3.4-.1.1-.4.1-.6-.1-2-1.1-4.5-1.9-7.1-2.6-2.7-.4-5.6-.7-8.5-.7-1.9 0-3.7.1-5 .5-1.4.4-2.5.8-3.3 1.3s-1.5 1.2-1.9 1.9c-.4.8-.6 1.6-.6 2.4 0 1.1.3 2.1.9 2.9.6.9 1.7 1.7 3.1 2.6 1.4.9 3.4 1.9 5.9 3l3.8 1.4c4.5 1.9 8 3.8 10.5 5.9 2.5 2.1 4.3 4.3 5.3 6.8s1.5 5 1.5 7.9c0 4-1.1 7.6-3.2 10.6-2.2 3-5.1 5.4-8.9 7s-8.4 2.4-13.6 2.4zm60.3-11.1v8.4c0 .7-.3 1.2-.8 1.3-1.3.4-2.7.7-4.1 1s-3.1.4-4.9.4c-4.5 0-7.9-1.2-10.5-3.5-2.5-2.3-3.8-6.1-3.8-11.2V69.6H85c-.6 0-.8-.3-.8-.9V58.5c0-.6.3-.8.9-.8h6.1c.1-1.2.1-2.5.3-4 .1-1.5.2-3.1.4-4.6.1-1.5.3-2.8.4-3.8.1-.2.1-.4.3-.6.1-.1.3-.3.5-.4l12.2-1.5c.2-.1.4-.1.5 0 .1.1.2.3.2.6-.1 1.6-.2 3.7-.3 6.4-.1 2.7-.1 5.3-.2 7.9h9.5c.4 0 .6.3.6.8v10.4c0 .4-.1.6-.5.7h-9.7v21.9c0 2.3.4 4 1.2 5 .8 1 2.2 1.5 4.3 1.5.6 0 1.2 0 1.7-.1.6 0 1.1-.1 1.7-.1.2-.1.4-.1.6.1.2.1.3.3.3.6z"
                                  fill="#fff"/> </svg>
                        <div>{{__("Adobe Stock")}}</span></div>
                    </a>
                </li>--}}
                <li class="menu-item {{ Request::route()->getName() == 'panel.service.flaticon' ? 'active' : '' }}">
                    <a href="{{ route('panel.service.flaticon') }}" class="menu-link">
                        <svg style="width: 24px;height: 24px;" version="1.1" id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 24 24" xml:space="preserve"> <path style="fill:#16D298;"
                                                                             d="M13.462 7.626H7.816L6.05 4.606h9.178L17.902 0H2.732a2.73 2.73 0 0 0-2.36 1.354 2.652 2.652 0 0 0 0 2.707l9.673 16.606c.76 1.288 2.443 1.717 3.747.958a2.86 2.86 0 0 0 .974-.958l.313-.545-4.44-7.659 2.823-4.837Z"></path>
                            <path fill="#16D298"
                                  d="M24.473 1.354A2.71 2.71 0 0 0 22.112 0h-.66l-7.264 12.463 2.675 4.606 7.61-13.041a2.67 2.67 0 0 0 0-2.674Z"></path></svg>
                        <div>
                            &nbsp;{{__("Flaticon")}}{{-- &nbsp;&nbsp;<span class="badge bg-label-success">{{__('NEW')}}</span>--}}</div>
                    </a>
                </li>

                {{-- <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>AdobeStock</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>DepositPhoto</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>DreamsTime</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>iStockPhoto</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>iStock</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>ArtGrid</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>ArtList</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Deezy</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Designi</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>FootageCrate</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>CraftWork</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>ArtGrid</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>IconScout</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>PixelSquid</span>
                         </div>
                     </a>
                 </li>


                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>RawPixel</span>
                         </div>
                     </a>
                 </li>


                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>UI8</span>
                         </div>
                     </a>
                 </li>


                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Vecteezy</span>
                         </div>
                     </a>
                 </li>


                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Uplabs</span>
                         </div>
                     </a>
                 </li>


                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Mockupcloud</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Pixelbuddha</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>VectorStock</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Shutter Music</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>Shutter Video</span>
                         </div>
                     </a>
                 </li>

                 <li class="menu-item">
                     <a href="{{ route('panel.service.otherServices') }}" class="menu-link">
                         --}}{{-- <i class="menu-icon tf-icons ti ti-download"></i>--}}{{--

                         <div class="icon">
                             <i class="menu-icon tf-icons ti ti-brand-juejin"></i>
                         </div>
                         <div>StoryBlocks</span>
                         </div>
                     </a>
                 </li>--}}


            </ul>


        </aside>
        <!-- / Menu -->


        <!-- Layout container -->
        <div class="layout-page">


            <!-- Navbar -->

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                 id="layout-navbar">


                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ti ti-menu-2 ti-md"></i>
                    </a>
                </div>


                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


                    <ul class="navbar-nav flex-row align-items-center ms-auto">


                        <!-- Language -->
                        <li class="nav-item dropdown-language dropdown">
                            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                               href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class='ti ti-language rounded-circle ti-md'></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="?setLang=tr" data-language="tr"
                                       data-text-direction="ltr">
                                        <span>Türkçe</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="?setLang=en" data-language="en"
                                       data-text-direction="ltr">
                                        <span>English</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="?setLang=es" data-language="es"
                                       data-text-direction="rtl">
                                        <span>Spanish</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="?setLang=bd" data-language="bd"
                                       data-text-direction="rtl">
                                        <span>বাংলা</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ Language -->

                        <!-- Style Switcher -->
                        <li class="nav-item dropdown-style-switcher dropdown">
                            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill"
                               href="{{route('setThemeMode')}}">
                                @if(\Illuminate\Support\Facades\Auth::user()->theme_mode=='light')
                                    <i class='ti ti-moon-stars'></i>
                                @else
                                    <i class='ti ti-sun'></i>
                                @endif
                            </a>
                        </li>
                        <!-- / Style Switcher-->


                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                               href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                               aria-expanded="false">
              <span class="position-relative">
                <i class="ti ti-bell ti-md"></i>
                <span class="badge rounded-pill bg-danger badge-dot badge-notifications border">2</span>
              </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-0">
                                <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h6 class="mb-0 me-auto">{{__('Notifications')}}</h6>
                                        <div class="d-flex align-items-center h6 mb-0">
                                            <span class="badge bg-label-primary me-2">2</span>
                                            <a href="javascript:void(0)"
                                               class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all"
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Mark all as read"><i
                                                        class="ti ti-mail-opened text-heading"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="{{asset('FrontV1/img/avatars/1.png')}}" alt=""
                                                             class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="small mb-1">
                                                        @if(auth()->user()->locale=='tr')
                                                            Sol menüde "Geri Bildirimler" adlı bir menü eklenmiştir. Bu
                                                            menüden, geri bildirimlerinizle ilgili dönüşleri ve
                                                            durumlarını görüntüleyebilirsiniz.
                                                        @else
                                                            A menu called "Feedback" has been added to the left menu.
                                                            From this menu, you can view the responses and status of
                                                            your feedback.
                                                        @endif🎉</h6>
                                                    <small class="text-muted">{{\Carbon\Carbon::create('2024-05-27')->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                       class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="{{asset('FrontV1/img/avatars/1.png')}}" alt=""
                                                             class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="small mb-1">
                                                        @if(auth()->user()->locale=='tr')
                                                            📢 Merhaba! Görüşlerinizi önemsiyoruz! 💬 Sağ alttaki kırmızı
                                                            yuvarlak
                                                            butona tıklayarak geri bildirimde bulunun. 🌟
                                                        @else
                                                            📢 Hello! We value your feedback! 💬 Click the red round
                                                            button at the
                                                            bottom right to share your thoughts. 🌟
                                                        @endif🎉</h6>
                                                    <small class="text-muted">{{\Carbon\Carbon::create('2024-05-27')->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                       class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                                class="ti ti-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                                {{--<li class="border-top">
                                <div class="d-grid p-4">
                                    <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                        <small class="align-middle">View all notifications</small>
                                    </a>
                                </div>
                            </li>--}}
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                               data-bs-toggle="dropdown">
                                <div class="avatar avatar-online d-flex align-content-center justify-content-center bg-warning rounded-circle">
                                    <div class="text-white fw-bold"
                                         style="line-height: 3">{{Str::substr(auth()->user()->name,0,1).Str::substr(auth()->user()->surname,0,1)}}</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item mt-0" href="{{ Auth::user()->profilelink }}">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <img src="{{asset('FrontV1/img/avatars/1.png')}}" alt=""
                                                         class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1 mx-n2"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ Auth::user()->profilelink }}">
                                        <i class="ti ti-user me-3 ti-md"></i><span
                                                class="align-middle">{{__("Profile Settings")}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('panel.orders') }}">
                                        <i class="ti ti-settings me-3 ti-md"></i><span
                                                class="align-middle">{{__("Order History")}}</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1 mx-n2"></div>
                                </li>
                                {{--<li>
                                <a class="dropdown-item" href="pages-faq.html">
                                    <i class="ti ti-question-mark me-3 ti-md"></i><span
                                        class="align-middle">FAQ</span>
                                </a>
                            </li>--}}
                                <li>
                                    <div class="d-grid px-2 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}">
                                            <small class="align-middle">{{__("Logout")}}</small>
                                            <i class="ti ti-logout ms-2 ti-14px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->


                    </ul>
                </div>


            </nav>

            <!-- / Navbar -->


            <!-- Content wrapper -->
            <div class="content-wrapper">

                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">

                    @if(false)
                        <div class="alert alert-info " role="alert">
                            <div class="card-title mb-0">
                                <a href="?setLang=tr"
                                   class="btn btn-secondary badge bg-label-secondary rounded p-2 mb-2">
                                    <i class='ti flag-icon flag-icon-tr'></i> Türkçe
                                </a>
                                <a href="?setLang=en"
                                   class="btn btn-secondary badge bg-label-secondary rounded p-2 mb-2">
                                    <i class='ti flag-icon flag-icon-us'></i> English
                                </a>
                            </div>
                            @if(auth()->user()->locale=='tr')
                                <div class="alert alert-success fw-bold">
                                    Yeni yayınlanan "Tüm Servisler" hizmetimize sol menüden ulaşabilirsiniz<br>
                                    ShutterStock 27 ₺<br>
                                    ShutterStock Video 298 ₺<br>
                                    AdobeStock 9 ₺<br>
                                    bir çok hizmeti uygun fiyata kullanabilirsiniz, hemen <a
                                            href="../panel/service/otherServices"
                                            class="btn btn-success badge bg-label-success rounded p-2 mb-2">
                                        {{__('Other Services')}}
                                    </a> tıklayın ve hemen kullanmaya başlayın.
                                </div>

                                Haydi, hemen sol menüden <strong>"Tüm Servisler"</strong> sayfasına gidin ve yeni
                                içeriklerimizi keşfedin! 🌟

                                <hr>
                                <b>Görseller</b>: Shutterstock, Adobe Stock, iStock, Freepik, Depositphotos, RawPixel
                                <br>
                                <b>Videolar</b>: Shutterstock Video, Artgrid, Storyblocks, Motion Array<br>
                                <b>Müzik</b>: Artlist, Epidemic Sound, Shutter Music<br>
                                <b>İkon ve Grafik Şablonları</b>: Flaticon, Vecteezy, IconScout, CraftWork<br>
                                <b>Fiyatlarını öğrenmek için indirmek istediğiniz içeriği "Tüm Servisler" sayfamıza
                                    giderek gönderin. Sorgulama yapmak ücretsizdir.</b>
                            @else
                                <div class="alert alert-success fw-bold">
                                    You can access our newly released "All Services" from the left menu.<br>
                                    ShutterStock for 27 ₺<br>
                                    ShutterStock Video for 298 ₺<br>
                                    AdobeStock for 9 ₺<br>
                                    Take advantage of many services at affordable prices, click
                                    <a href="../panel/service/otherServices"
                                       class="btn btn-success badge bg-label-success rounded p-2 mb-2">
                                        {{__('Other Services')}}
                                    </a> and start using it right away.
                                </div>

                                So, head over to the <strong>"All Services"</strong> page in the left menu and explore
                                our new content now! 🌟

                                <hr>
                                <b>Images</b>: Shutterstock, Adobe Stock, iStock, Freepik, Depositphotos, RawPixel<br>
                                <b>Video</b>: Shutterstock Video, Artgrid, Storyblocks, Motion Array<br>
                                <b>Music</b>: Artlist, Epidemic Sound, Shutter Music<br>
                                <b>Icon & Template</b>: Flaticon, Vecteezy, IconScout, CraftWork<br>
                                <b>To learn the prices, please go to our "All Services" page and submit the content you
                                    wish to download. Inquiry is free of charge.</b>
                            @endif
                            <div class="card-title mb-0">
                                <a href="?setLang=tr"
                                   class="btn btn-secondary badge bg-label-secondary rounded p-2 mb-2">
                                    <i class='ti flag-icon flag-icon-tr'></i> Türkçe
                                </a>
                                <a href="?setLang=en"
                                   class="btn btn-secondary badge bg-label-secondary rounded p-2 mb-2">
                                    <i class='ti flag-icon flag-icon-us'></i> English
                                </a>
                            </div>
                        </div>
                    @endif
                    @if(env('FEEDBACK_SYSTEM_STATUS')=='1')
                        @include('kustomer::kustomer')
                    @endif


                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        @yield('topbuttons')
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('result_post'))
                        <div class="alert alert-{{ json_decode(session('result_post'))->status }}">
                            {!! json_decode(session('result_post'))->message !!}
                        </div>
                    @endif


                    @yield('content')

                    <div class="modal fade" id="usingKeyModal" tabindex="-1" role="dialog"
                         aria-labelledby="usingKeyModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form class="modal-content" method="post" action="{{route('panel.usingkey')}}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="usingKeyModalLabel">{{__("Using Key")}}</h5>
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)"
      fill="currentColor"></rect>
<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
</svg>

</span>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <label for="usingkeyinput">{{__("Using Key")}}</label>
                                        <input type="text" class="form-control" name="key">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{__("Cancel")}}</button>
                                    <button type="submit" class="btn btn-primary">{{__("Save")}}</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- / Content -->


                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                            <div class="text-body">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())

                                </script>
                                , made with ❤️ by <a href="/" target="_blank" class="footer-link">Stokla.net</a>

                                &nbsp;
                                &nbsp;
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#kullanimSozlesmesi">
                                    @if(auth()->user()->locale=='tr')
                                        Kullanım Sözleşmesi
                                    @else
                                        Usage Agreement
                                    @endif
                                </button>
                            </div>
                            <div class="d-none d-lg-inline-block">

                                @if(auth()->user()->ref==null)
                                    <a href="https://t.me/travexa" target="_blank"
                                       class="footer-link d-none d-sm-inline-block">Powered
                                        by VOLT
                                        SOFTWARE</a>

                                @endif

                                {{-- <a href="https://" class="footer-link me-4"
                                        target="_blank">License</a>
                                <a href="https://" target="_blank"
                                   class="footer-link me-4">More Themes</a>

                                <a href="https:///"
                                   target="_blank" class="footer-link me-4">Documentation</a>


                                <a href="https://" target="_blank"
                                   class="footer-link d-none d-sm-inline-block">Support</a>--}}

                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="modal fade" id="kullanimSozlesmesi" tabindex="-1" aria-labelledby="kullanimSozlesmesiLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        @if(auth()->user()->locale=='tr')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kullanimSozlesmesiLabel">Stokla.net Kullanım
                                        Sözleşmesi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2 class="mb-4">Stokla.net Kullanım Sözleşmesi</h2>
                                    <h3>1. Genel Şartlar ve Koşullar</h3>
                                    <ul>
                                        <li>Bu kullanım sözleşmesi ("Sözleşme"), stokla.net web sitesi ("Site")
                                            üzerinden sunulan hizmetlerin kullanımıyla ilgili şartları ve koşulları
                                            belirlemektedir.
                                        </li>
                                        <li>Siteyi kullanarak, bu Sözleşme'yi okuduğunuzu, anladığınızı ve kabul
                                            ettiğinizi beyan etmektesiniz.
                                        </li>
                                        <li>Site, stok görsel, video, müzik ve benzeri içeriklerin ücretli abonelik
                                            ve/veya kredili sistemle indirilmesine imkan tanımaktadır.
                                        </li>
                                        <li>İçerikler lisanslı veya lisanssız olabilir.</li>
                                    </ul>

                                    <h3>2. Abonelik ve Kredi Sistemleri</h3>
                                    <ul>
                                        <li>Site üzerinden sunulan hizmetler, kullanıcıların belirli bir ücret
                                            karşılığında abone olmalarını veya kredi satın almalarını gerektirebilir.
                                        </li>
                                        <li>Kullanıcı, abone veya kredi satın alırken iade imkanı olmadığını kabul
                                            eder.
                                        </li>
                                        <li>Satın alınan hiçbir servisin iadesi söz konusu değildir.</li>
                                    </ul>

                                    <h3>3. Bakiye Yükleme ve Kullanımı</h3>
                                    <ul>
                                        <li>Kullanıcı, Siteye bakiye yüklediğinde, bu bakiyeyi Site içerisinde kullanmak
                                            zorundadır.
                                        </li>
                                        <li>Yüklenen bakiyenin nakit olarak iade alınması, paraya çevrilmesi veya başka
                                            bir kullanıcıya aktarılması mümkün değildir.
                                        </li>
                                    </ul>

                                    <h3>4. İçerik Kullanım Hakları</h3>
                                    <ul>
                                        <li>Kullanıcı, Site üzerinden indirilen içerikleri yalnızca kişisel veya ticari
                                            olmayan amaçlarla kullanabilir.
                                        </li>
                                        <li>Lisanslı içeriklerin ticari kullanımı, ilgili lisans şartlarına tabidir.
                                        </li>
                                        <li>Site üzerinden indirilen içeriklerin yeniden satılması, dağıtılması veya
                                            ticari amaçlarla kullanılması yasaktır.
                                        </li>
                                    </ul>

                                    <h3>5. Sorumluluk Reddi</h3>
                                    <ul>
                                        <li>Site, kullanıcıların indirdiği içeriklerin doğruluğu, kalitesi veya
                                            güvenliği konusunda herhangi bir sorumluluk kabul etmez.
                                        </li>
                                        <li>Kullanıcı, Site'yi kullanarak doğabilecek herhangi bir zarardan tamamen
                                            kendi sorumluluğunda olduğunu kabul eder.
                                        </li>
                                    </ul>

                                    <h3>6. Gizlilik Politikası</h3>
                                    <ul>
                                        <li>Kullanıcıların kişisel bilgileri, Site'nin gizlilik politikası çerçevesinde
                                            korunmaktadır.
                                        </li>
                                        <li>Gizlilik politikası hakkında detaylı bilgiye Site üzerinden
                                            ulaşabilirsiniz.
                                        </li>
                                    </ul>

                                    <h3>7. Sözleşme Değişiklikleri</h3>
                                    <ul>
                                        <li>Site, bu Sözleşme'yi herhangi bir zamanda değiştirme hakkını saklı tutar.
                                        </li>
                                        <li>Değişiklikler, Site üzerinden yayınlandığında geçerli olur ve kullanıcıların
                                            bu değişiklikleri kabul etmiş sayılacağını belirtir.
                                        </li>
                                    </ul>

                                    <h3>8. Hesap Kullanımı</h3>
                                    <ul>
                                        <li>Bir hesap yalnızca hesap sahibinin kullanımına özeldir.</li>
                                        <li>Hesabın ikinci veya üçüncü kişiler tarafından kullanılması kesinlikle
                                            yasaktır.
                                        </li>
                                        <li>Hesap bilgilerinin başkalarıyla paylaşılması veya hesabın birden fazla kişi
                                            tarafından kullanılması durumunda, hesap derhal kapatılacaktır.
                                        </li>
                                        <li>Bu durumlarda, kapatılan hesap için herhangi bir iade yapılmayacaktır.</li>
                                        <li>Bir hesabın birden fazla kullanımı kesinlikle yasaktır.</li>
                                    </ul>

                                </div>
                            </div>
                        @else
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kullanimSozlesmesiLabel">Stokla.net Usage
                                        Agreement</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2 class="mb-4">Stokla.net Usage Agreement</h2>
                                    <h3>1. General Terms and Conditions</h3>
                                    <ul>
                                        <li>This usage agreement ("Agreement") sets forth the terms and conditions
                                            regarding the use of the services provided through the stokla.net website
                                            ("Site").
                                        </li>
                                        <li>By using the Site, you declare that you have read, understood, and accepted
                                            this Agreement.
                                        </li>
                                        <li>The Site allows the download of stock images, videos, music, and similar
                                            content through a paid subscription and/or credit system.
                                        </li>
                                        <li>The contents may be licensed or unlicensed.</li>
                                    </ul>

                                    <h3>2. Subscription and Credit Systems</h3>
                                    <ul>
                                        <li>Services offered through the Site may require users to subscribe or purchase
                                            credits for a fee.
                                        </li>
                                        <li>The user accepts that there is no refund possibility when subscribing or
                                            purchasing credits.
                                        </li>
                                        <li>No refund is possible for any purchased service.</li>
                                    </ul>

                                    <h3>3. Balance Loading and Usage</h3>
                                    <ul>
                                        <li>When the user loads a balance to the Site, it must be used within the
                                            Site.
                                        </li>
                                        <li>The loaded balance cannot be refunded in cash, converted to money, or
                                            transferred to another user.
                                        </li>
                                    </ul>

                                    <h3>4. Content Usage Rights</h3>
                                    <ul>
                                        <li>The user can use the content downloaded from the Site only for personal or
                                            non-commercial purposes.
                                        </li>
                                        <li>The commercial use of licensed content is subject to the relevant license
                                            terms.
                                        </li>
                                        <li>The resale, distribution, or use of content downloaded from the Site for
                                            commercial purposes is prohibited.
                                        </li>
                                    </ul>

                                    <h3>5. Disclaimer of Liability</h3>
                                    <ul>
                                        <li>The Site accepts no responsibility for the accuracy, quality, or safety of
                                            the content downloaded by users.
                                        </li>
                                        <li>By using the Site, the user accepts full responsibility for any damage that
                                            may arise.
                                        </li>
                                    </ul>

                                    <h3>6. Privacy Policy</h3>
                                    <ul>
                                        <li>Users' personal information is protected under the Site's privacy policy.
                                        </li>
                                        <li>Detailed information about the privacy policy can be accessed through the
                                            Site.
                                        </li>
                                    </ul>

                                    <h3>7. Agreement Amendments</h3>
                                    <ul>
                                        <li>The Site reserves the right to change this Agreement at any time.</li>
                                        <li>Changes become effective upon being posted on the Site, and users will be
                                            deemed to have accepted these changes.
                                        </li>
                                    </ul>

                                    <h3>8. Account Usage</h3>
                                    <ul>
                                        <li>An account is only for the use of the account owner.</li>
                                        <li>It is strictly forbidden to use the account by second or third parties.</li>
                                        <li>If account information is shared with others or used by multiple people, the
                                            account will be immediately closed.
                                        </li>
                                        <li>In such cases, no refund will be given for the closed account.</li>
                                        <li>The use of an account by more than one person is strictly prohibited.</li>
                                    </ul>
                                </div>
                            </div>

                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{__('Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
</div>


<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>


<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<div class="modal fade" id="AddBalanceModal" tabindex="-1" role="dialog"
     aria-labelledby="AddBalanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="get" action="{{route('paytrpay')}}">
            <div class="modal-header">
                <h5 class="modal-title" id="usingKeyModalLabel">{{__("Balance Add")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Minimum 50 ₺</small>
                <div class="input-group">
                    <span class="input-group-text">₺</span>
                    <input type="number" min="50" placeholder="{{__('Please enter the amount you want to upload')}}"
                           name="add_balance" id="addBalancePrice" class="form-control">
                    <button class="btn btn-success">{{__('Pay with Card')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{asset('FrontV1/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('FrontV1/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('FrontV1/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('FrontV1/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('FrontV1/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('FrontV1/vendor/libs/hammer/hammer.js')}}"></script>
{{--
<script src="{{asset('FrontV1/vendor/libs/i18n/i18n.js')}}"></script>
--}}
<script src="{{asset('FrontV1/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('FrontV1/vendor/js/menu.js')}}"></script>

<script src="{{asset('FrontV1/vendor/libs/shepherd/shepherd.js')}}"></script>
<script src="{{asset('FrontV1/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->


<!-- Main JS -->
<script src="{{asset('FrontV1/js/main.js')}}"></script>

<script>
    $('button#item_delete').click(function () {
        Swal.fire({
            title: '{{__("Are you sure?")}}',
            text: "{{__("This action will permanently delete the selected item!")}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{__("Yes, delete it permanently!")}}',
            cancelButtonText: '{{__("Cancel")}}'
        }).then((result) => {
            if (result.isConfirmed) {
                $('form#item_delete_' + $(this).data().item).submit();
            }
        });
    });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

@yield('scripts')
<script>
    let dtJsLangUrl = '{{\Auth::user()->locale=='tr'?'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json':'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json'}}'
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script src="{{ asset('js/voldi.js') }}"></script>


<!-- Page JS -->


</body>

</html>

<!-- beautify ignore:end -->

