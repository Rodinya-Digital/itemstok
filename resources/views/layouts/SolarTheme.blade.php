<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" type="image/png" href="{{asset('FrontV1/img/favicon/favicon.ico')}}">

    <!-- Title -->
    <title>@yield('title', 'Stokla.net') &mdash; {{ env('APP_NAME') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{ asset('assets_connect/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/fontawesome.css')}}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('assets_connect/css/connect.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_connect/css/dark_theme.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_connect/css/custom.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/tabler-icons.css')}}">
    <link rel="stylesheet" href="{{asset('FrontV1/vendor/fonts/flag-icons.css')}}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .ios-blur {
            position: relative;
            overflow: hidden;
            z-index: 1;
            border-radius: 1rem; /* isteğe bağlı */
        }

        .ios-blur::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 30%, rgba(255, 0, 150, 0.4), transparent 50%),
            radial-gradient(circle at 70% 60%, rgba(0, 200, 255, 0.4), transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(0, 255, 150, 0.4), transparent 50%);
            filter: blur(60px);
            z-index: 0;
            animation: hueRotate 5s linear infinite;
            pointer-events: none;
        }

        @keyframes hueRotate {
            from {
                filter: hue-rotate(0deg) blur(60px);
            }
            to {
                filter: hue-rotate(360deg) blur(60px);
            }
        }

        .ios-blur > * {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>

<div class='loader'>
    <div class='spinner-grow text-primary' role='status'>
        <span class='sr-only'>Loading...</span>
    </div>
</div>
<div class="connect-container align-content-stretch d-flex flex-wrap">
    <div class="page-sidebar">
        <div class="logo-box"><a href="#" class="logo-text">{{env('APP_NAME')}}</a><a href="#" id="sidebar-close"><i class="material-icons">close</i></a> <a href="#" id="sidebar-state"><i class="material-icons">adjust</i><i class="material-icons compact-sidebar-icon">panorama_fish_eye</i></a></div>
        <div class="page-sidebar-inner slimscroll">
            <ul class="accordion-menu">
                @if(auth()->user()->hasRole('Admin'))
                    <li class="sidebar-title">
                        Admin Area
                    </li>

                    <li class="@if(in_array(Request::route()->getName(),['panel.admin.dashboard','panel.cookie.mnt','panel.users','panel.managekeys.index','panel.services.index','panel.getFeedBacks'])) active-page @endif">
                        <a href="#"><i class="material-icons">admin_panel_settings</i>{{__('Yönetim')}}<i class="material-icons has-sub-menu">add</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('panel.admin.dashboard') }}" class="{{ Request::route()->getName() == 'panel.admin.dashboard' ? 'active' : '' }}">{{__("Dashboard")}}</a>
                            </li>
                            <li>
                                <a href="{{ route('panel.cookie.mnt') }}" class="{{ Request::route()->getName() == 'panel.cookie.mnt' ? 'active' : '' }}">{{__("Cookie Management")}}</a>
                            </li>
                            <li>
                                <a href="{{ route('panel.users') }}" class="{{ Request::route()->getName() == 'panel.users' ? 'active' : '' }}">{{__("Users")}}</a>
                            </li>
                            <li>
                                <a href="{{ route('panel.managekeys.index') }}" class="{{ Request::route()->getName() == 'panel.managekeys.index' ? 'active' : '' }}">{{__("Keys")}}</a>
                            </li>
                            <li>
                                <a href="{{ route('panel.services.index') }}" class="{{ Request::route()->getName() == 'panel.services.index' ? 'active' : '' }}">{{__("Services")}}</a>
                            </li>
                            <li>
                                <a href="{{ route('panel.getFeedBacks') }}" class="{{ Request::route()->getName() == 'panel.getFeedBacks' ? 'active' : '' }}">{{__("Feedbacks")}}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-title">
                        Customer Area
                    </li>
                @endif

                @if(auth()->user()->dealer=='1')
                    <li class="{{ Request::route()->getName() == 'panel.dealerKeys' ? 'active-page' : '' }}">
                        <a href="{{ route('panel.dealerKeys') }}" class="{{ Request::route()->getName() == 'panel.dealerKeys' ? 'active' : '' }}">
                            <i class="material-icons">vpn_key</i>{{__("Dealer Keys")}}
                        </a>
                    </li>
                @endif

                <li class="{{ Request::route()->getName() == 'panel.user.dashboard' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.user.dashboard') }}" class="{{ Request::route()->getName() == 'panel.user.dashboard' ? 'active' : '' }}">
                        <i class="material-icons-outlined">dashboard</i>{{__("Dashboard")}}
                    </a>
                </li>

                @if(env('FEEDBACK_SYSTEM_STATUS')=='1')
                    <li class="{{ Request::route()->getName() == 'panel.getFeedBacksUser' ? 'active-page' : '' }}">
                        <a href="{{ route('panel.getFeedBacksUser') }}" class="{{ Request::route()->getName() == 'panel.getFeedBacksUser' ? 'active' : '' }}">
                            <i class="material-icons">feedback</i>{{__("Feedbacks")}}
                        </a>
                    </li>
                @endif

                <li class="{{ Request::route()->getName() == 'panel.service.licenseCenter' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.licenseCenter') }}" class="{{ Request::route()->getName() == 'panel.service.licenseCenter' ? 'active' : '' }}">
                        <i class="material-icons">card_membership</i>{{__("Lisans İndir")}}
                    </a>
                </li>

                <li class="sidebar-title">
                    {{__('Store')}}
                </li>

               {{-- <li class="{{ Request::route()->getName() == 'panel.shop' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.shop') }}" class="special-link store-link {{ Request::route()->getName() == 'panel.shop' ? 'active' : '' }}">
                        <i class="material-icons">shopping_bag</i>{{__("Store")}}
                    </a>
                </li>--}}

                <li>
                    <a href="#" class="special-link key-link" onclick="$('#usingKeyModal').modal('show');">
                        <i class="material-icons">vpn_key</i>{{__("Using Key")}}
                    </a>
                </li>

                <!-- Balance Card Area -->
                <li class="balance-area" style="padding: 15px; margin: 10px 0; border-top: 1px solid rgba(0,0,0,0.1);">
                    <div class="balance-card" onclick="$('#AddBalanceModal').modal('show');" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div style="display: flex ; justify-content: space-around; align-items: center; flex-wrap: nowrap;">
                            <div>
                                <h6 style="margin: 0 0 5px 0; font-size: 14px; opacity: 0.9;">{{__("Balance")}}</h6>
                                <span style="font-size: 18px; font-weight: bold;">{{number_format(auth()->user()->balance, 2)}} ₺</span>
                            </div>
                            <a href="javascript:void(0)" onclick="$('#AddBalanceModal').modal('show');"
                               style="background: rgba(255,255,255,0.2); color: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease;"
                               onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                <i class="material-icons" style="font-size: 18px;">add</i>
                            </a>
                        </div>
                    </div>

                   {{-- @if(auth()->user()->ref==null)
                        <div style="margin-top: 15px;">
                            <a href="https://forms.gle/nMXXF6dTBT2LK4qt7" target="_blank"
                               style="background: linear-gradient(135deg, #4CAF50, #81C784); color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; justify-content: center; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);"
                               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(76, 175, 80, 0.4)'"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(76, 175, 80, 0.3)'">
                                {{__("Bayimiz olun")}} &nbsp;
                                <i class="material-icons" style="font-size: 18px;">star</i>
                            </a>
                        </div>
                    @endif--}}
                </li>

                <li class="sidebar-title">
                    {{__('Services')}}
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.otherServices' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.otherServices') }}" class="{{ Request::route()->getName() == 'panel.service.otherServices' ? 'active' : '' }}">
                        <i class="material-icons">get_app</i>{{__("Other Services")}}
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.envatoelements' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.envatoelements') }}" class="{{ Request::route()->getName() == 'panel.service.envatoelements' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: currentColor;" viewBox="0 0 107.65 122.88">
                            <path d="M91.76,1C88.16-1,77.83.18,65.44,4c-21.7,14.83-40,36.69-41.29,71.78-.24.83-2.38-.12-2.8-.38-5.86-11.23-8.18-23.06-3.29-40.12.91-1.51-2.07-3.38-2.61-2.85a61.75,61.75,0,0,0-8.52,11C-7.81,69,1.83,101.78,27.62,116.12a53.44,53.44,0,0,0,72.69-20.69C116.92,65.66,101.5,6.38,91.76,1Z"/>
                        </svg>
                        Envato Elements
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.freepik' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.freepik') }}" class="{{ Request::route()->getName() == 'panel.service.freepik' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: #2470D8;" viewBox="0 0 266 223.5">
                            <path d="M46.3 157.8c-1-5.4-2.3-10.7-3-16.1-2.8-21.1 1.7-40.6 14.2-58C67.3 70 80.7 60.5 96.1 53.9c18.5-7.9 38.4-12.2 58.5-12.6 17.9-.5 33.5 6.1 47.1 17.3 14 11.6 24.8 25.9 33.1 42 4 7.8 7.7 15.8 11.5 23.8.4.9.7 1.9.9 2.9-5.3 3.2-10.4 6.5-15.8 9.4-20 11-41.6 18.5-64.1 22.4-12.3 2.1-24.7 3.3-37.1 4.1-11.8.8-23.6 1.2-35.4.9-16.1-.4-32.1-2.9-48.5-6.3zm25.4-53.6c-.3 17.6 14 31.8 31.4 32 16.8.2 32.5-12.7 32.5-31.6 0-19.6-15.1-32-32-32-17.5 0-31.8 14.1-31.9 31.6zm122.9 9.2c9.5.7 20.1-7.2 20.2-20.2.1-10.8-8.6-19.6-19.4-19.7h-.4c-11-.2-20 8.6-20.2 19.5v.3c0 11.4 8.5 20.1 19.8 20.1z"/>
                        </svg>
                        Freepik Premium
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.motionarray' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.motionarray') }}" class="{{ Request::route()->getName() == 'panel.service.motionarray' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: #800080;" viewBox="0 0 128 128">
                            <path d="M0 640 l0 -640 640 0 640 0 0 640 0 640 -640 0 -640 0 0 -640z m415 73 c26 -71 51 -132 55 -136 4 -4 29 53 56 127 l49 136 58 0 57 0 0 -201 0 -200 -42 3 -43 3 -5 113 -5 112 -44 -115 -43 -115 -37 0 -37 0 -44 117 -45 117 -5 -114 -5 -115 -42 -3 -43 -3 0 200 0 201 59 0 58 0 48 -127z m530 13 c45 -19 55 -42 55 -129 0 -57 4 -76 15 -81 9 -3 15 -19 15 -41 0 -33 -2 -35 -34 -35 -19 0 -42 7 -50 15 -14 14 -18 14 -45 0 -97 -50 -207 29 -161 116 17 30 64 49 125 49 56 0 65 8 46 39 -13 20 -71 18 -86 -2 -18 -25 -85 -23 -85 1 0 19 29 51 65 70 28 16 99 15 140 -2z" transform="scale(0.1,-0.1) translate(0,128)"/>
                        </svg>
                        {{__("Motion Array")}}
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.epidemicsound' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.epidemicsound') }}" class="{{ Request::route()->getName() == 'panel.service.epidemicsound' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: #222222;" viewBox="0 0 24 24">
                            <path d="M 14.275391 2.0019531 C 11.365107 2.045791 8.5075 3.1841406 6.359375 5.3066406 C 4.192375 7.4496406 3 10.296125 3 13.328125 C 3 16.358125 4.192375 19.207609 6.359375 21.349609 L 6.7265625 21.710938 C 6.9135625 21.895938 7.1656875 22 7.4296875 22 L 13.345703 22 C 13.750703 22 14.115531 21.755859 14.269531 21.380859 C 14.423531 21.005859 14.336828 20.574063 14.048828 20.289062 L 10.724609 17.003906 C 9.7306094 16.020906 9.1835938 14.716125 9.1835938 13.328125 C 9.1835937 11.941125 9.7306094 10.635344 10.724609 9.6523438 C 12.571532 7.8287205 15.450849 7.646168 17.509766 9.0898438 L 11.40625 15.298828 C 11.12425 15.585828 11.041266 16.014719 11.197266 16.386719 C 11.352266 16.757719 11.716141 16.998047 12.119141 16.998047 L 19 16.998047 C 19.553 16.998047 20 16.551047 20 15.998047 L 20 9.046875 L 20 4.03125 C 20 3.64625 19.777687 3.2949062 19.429688 3.1289062 C 17.786438 2.3440313 16.021561 1.9756504 14.275391 2.0019531 z"/>
                        </svg>
                        {{__("Epidemic Sound")}}
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.shutterstock' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.shutterstock') }}" class="{{ Request::route()->getName() == 'panel.service.shutterstock' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: #ee2b24;" viewBox="0 0 396.918 396.918">
                            <path d="M0,22.652v351.614c0,12.51,10.141,22.652,22.652,22.652h351.614c12.51,0,22.652-10.141,22.652-22.652 V22.652C396.917,10.141,386.776,0,374.266,0H22.652C10.141,0,0,10.141,0,22.652z M180.96,108.222h-62.29 c-6.256,0-11.344,5.088-11.344,11.344v59.92H55.353v-59.92c0-34.912,28.405-63.317,63.317-63.317h62.291L180.96,108.222 L180.96,108.222z M341.565,277.352c0,34.912-28.405,63.317-63.317,63.317h-62.291v-51.973h62.291 c6.256,0,11.344-5.088,11.344-11.344v-59.92h51.973L341.565,277.352L341.565,277.352z"/>
                        </svg>
                        {{__("ShutterStock")}}
                    </a>
                </li>

                <li class="{{ Request::route()->getName() == 'panel.service.flaticon' ? 'active-page' : '' }}">
                    <a href="{{ route('panel.service.flaticon') }}" class="{{ Request::route()->getName() == 'panel.service.flaticon' ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-right: 8px;" viewBox="0 0 24 24">
                            <path style="fill:#0F4637;" d="M13.462 7.626H7.816L6.05 4.606h9.178L17.902 0H2.732a2.73 2.73 0 0 0-2.36 1.354 2.652 2.652 0 0 0 0 2.707l9.673 16.606c.76 1.288 2.443 1.717 3.747.958a2.86 2.86 0 0 0 .974-.958l.313-.545-4.44-7.659 2.823-4.837Z"/>
                            <path fill="#fff" d="M24.473 1.354A2.71 2.71 0 0 0 22.112 0h-.66l-7.264 12.463 2.675 4.606 7.61-13.041a2.67 2.67 0 0 0 0-2.674Z"/>
                        </svg>
                        {{__("Flaticon")}}
                    </a>
                </li>
            </ul>

            <style>
                /* Özel linkler için stil */
                .special-link {
                    border-radius: 8px !important;
                    font-weight: 500 !important;
                    margin: 4px 0 !important;
                    transition: all 0.3s ease !important;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
                }

                .special-link:hover {
                    transform: translateY(-1px) !important;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                }

                /* Store linki - Yeşil gradyan */
                .store-link {
                    background: linear-gradient(45deg, #4CAF50, #81C784) !important;
                    color: white !important;
                }

                .store-link:hover {
                    background: linear-gradient(45deg, #5cb85c, #91d093) !important;
                    color: white !important;
                }

                /* Key linki - Mavi */
                .key-link {
                    background-color: #1E88E5 !important;
                    color: white !important;
                }

                .key-link:hover {
                    background-color: #2994f2 !important;
                    color: white !important;
                }

                /* Balance area için özel stil */
                .balance-area {
                    list-style: none !important;
                }

                .balance-area .balance-card {
                    position: relative;
                    overflow: hidden;
                }

                .balance-area .balance-card::before {
                    content: '';
                    position: absolute;
                    top: -50%;
                    left: -50%;
                    width: 200%;
                    height: 200%;
                    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
                    transform: rotate(45deg);
                    transition: all 0.6s;
                    opacity: 0;
                }

                .balance-area .balance-card:hover::before {
                    animation: shine 0.6s ease-in-out;
                }

                @keyframes shine {
                    0% {
                        transform: translateX(-100%) translateY(-100%) rotate(45deg);
                        opacity: 0;
                    }
                    50% {
                        opacity: 1;
                    }
                    100% {
                        transform: translateX(100%) translateY(100%) rotate(45deg);
                        opacity: 0;
                    }
                }

                /* SVG ikonları için ortak stil */
                .accordion-menu li a svg {
                    vertical-align: middle;
                    display: inline-block;
                }

                /* Aktif sayfa stilleri */
                .accordion-menu .active-page > a {
                    background-color: #667eea !important;
                    color: white !important;
                }

                .accordion-menu .active {
                    color: #667eea !important;
                    font-weight: 600 !important;
                }
            </style>
        </div>
    </div>
    <div class="page-container">
        <div class="page-header">
            <nav class="navbar navbar-expand">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item small-screens-sidebar-link">
                        <a href="#" class="nav-link"><i class="material-icons-outlined">menu</i></a>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{asset('SolarTheme/images/profile/user-'.\Auth::user()->avatar.'.jpg')}}" alt="profile image">
                            <span>{{\Auth::user()->name.' '.\Auth::user()->surname}}</span><i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ Auth::user()->profilelink }}">{{__("Profile Settings")}}</a>
                            <a class="dropdown-item" href="{{ route('panel.orders') }}">{{__("Order History")}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">{{__("Logout")}}</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="drop23333" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fi fi-{{ Auth::user()->locale === 'en' ? 'us' : Auth::user()->locale }}" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop23333">
                            <a class="dropdown-item d-flex align-items-center py-2" href="?setLang=en">
                                <span class="fi fi-us mr-2" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                                <span>English</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-2" href="?setLang=tr">
                                <span class="fi fi-tr mr-2" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                                <span>Türkçe</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-2" href="?setLang=fr">
                                <span class="fi fi-fr mr-2" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                                <span>Français</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-2" href="?setLang=es">
                                <span class="fi fi-es mr-2" style="width: 20px; hei ght: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                                <span>Spanish</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-2" href="?setLang=bd">
                                <span class="fi fi-bd mr-2" style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-size: cover;"></span>
                                <span>বাংলা</span>
                            </a>
                        </div>
                    </li>
                    <!--  <li class="nav-item">
                          <a href="#" class="nav-link"><i class="material-icons-outlined">mail</i></a>
                      </li>
                      <li class="nav-item">
                          <a href="#" class="nav-link"><i class="material-icons-outlined">notifications</i></a>
                      </li>-->
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="dark-theme-toggle"><i class="material-icons-outlined">brightness_2</i><i class="material-icons">brightness_2</i></a>
                    </li>
                </ul>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- <ul class="navbar-nav">
                         <li class="nav-item">
                             <a href="#" class="nav-link">Projects</a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link">Tasks</a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link">Reports</a>
                         </li>
                     </ul>-->
                </div>

            </nav>
        </div>
        <div class="page-content">
            @if(env('FEEDBACK_SYSTEM_STATUS')=='1')
                @include('kustomer::kustomer')
            @endif
            <div class="page-info">
                @yield('topbuttons')
            </div>
            <div class="main-wrapper">
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
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-dismiss="modal">
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
                                            data-dismiss="modal">{{__("Cancel")}}</button>
                                    <button type="submit" class="btn btn-primary">{{__("Save")}}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="AddBalanceModal" tabindex="-1" role="dialog"
                         aria-labelledby="AddBalanceModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form class="modal-content" method="get" action="{{route('paytrpay')}}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="usingKeyModalLabel">{{__("Balance Add")}}</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <style>
                                        .custom-banner {
                                            background: linear-gradient(45deg, #007bff, #0056b3);
                                            color: white;
                                            padding: 20px;
                                            border-radius: 10px;
                                            text-align: center;
                                            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                            margin: 20px auto;
                                            max-width: 800px;
                                        }
                                    </style>
                                    <div class="custom-banner">
                                        <h4 class="mb-2">⚠️ Bakiye Yükleme</h4>
                                        <p class="mb-0">Bakiye yüklemek  için <strong>bayiniz ile iletişime geçiniz</strong>.</p>
                                    </div>

                                    {{--
                                    <small class="text-muted d-block mb-2">Minimum 50 ₺</small>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₺</span>
                                        </div>
                                        <input type="number"
                                               min="50"
                                               max="50000"
                                               placeholder="Yüklemek istediğiniz tutarı giriniz"
                                               name="add_balance"
                                               id="addBalancePrice"
                                               class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button">Kart ile Öde</button>
                                        </div>
                                    </div>--}}
                                </div>

                            </form>
                        </div>
                    </div>

            </div>
        </div>
        <div class="page-footer">
            <div class="row">
                <div class="col-md-12">
                            <span class="footer-text"><script>
                    document.write(new Date().getFullYear())

                </script> © {{env('APP_NAME')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascripts -->
<script src="{{ asset('assets_connect/plugins/jquery/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('assets_connect/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{ asset('assets_connect/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets_connect/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('assets_connect/js/connect.min.js')}}"></script>
<script src="{{asset('SolarTheme/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>


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
</body>
</html>