<ul class="accordion-menu">
    @if(Auth::user()->hasRole('Admin'))

       {{-- @php
            $stat = \App\Http\Controllers\DashboardController::getStatsServer();
        @endphp


        <div class="bg-secondary p-2 text-left text-dark">
            <span><i class="fa-solid fa-memory"></i> Toplam Ram : {{$stat->mem->total}}</span><br>
            <span><i class="fa-solid fa-memory"></i> Boş Ram : {{$stat->mem->free}}</span><br>
            <span><i class="fa-solid fa-memory"></i> Kullanılan Ram : {{$stat->mem->used}}</span><br>
            <span><i class="fa-solid fa-server"></i> Sistem Yükü : {{implode(' | ',$stat->load)}}</span>
        </div>--}}

        <li class="sidebar-title">
            {{__('Admin Area')}}
        </li>
        <li class="{{ Request::route()->getName() == 'panel.admin.dashboard' ? ' active-page' : '' }}">
            <a href="{{ route('panel.admin.dashboard') }}"><i
                        class="material-icons-two-tone">dashboard</i>{{__("Dashboard")}}</a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.cookie.mnt' ? ' active-page' : '' }}">
            <a href="{{ route('panel.cookie.mnt') }}"><i
                        class="material-icons-two-tone">cookie</i>{{__("Cookie Management")}}</a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.users' ? ' active-page' : '' }}">
            <a href="{{ route('panel.users') }}"><i class="material-icons-two-tone">person</i>{{__("Users")}}</a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.managekeys.index' ? ' active-page' : '' }}">
            <a href="{{ route('panel.managekeys.index') }}"><i
                        class="material-icons-two-tone">key</i>{{__("Keys")}}</a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.services.index' ? ' active-page' : '' }}">
            <a href="{{ route('panel.services.index') }}"><i
                        class="material-icons-two-tone">electrical_services</i>{{__("Services")}}</a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.getFeedBacks' ? ' active-page' : '' }}">
            <a href="{{ route('panel.getFeedBacks') }}"><i
                        class="material-icons-two-tone">notification_important</i>{{__("Feedbacks")}}</a>
        </li>
        <li class="sidebar-title">

        </li>
    @endif
    @if(Auth::user()->dealer==='1')
        <li class="sidebar-title">
            {{__('Bayi Paneli')}}
        </li>
        <li class="{{ Request::route()->getName() == 'panel.dealerKeys' ? ' active-page' : '' }}">
            <a href="{{ route('panel.dealerKeys') }}"><i
                        class="material-icons-two-tone">key</i>{{__("Keys")}}</a>
        </li>
        <li class="sidebar-title">
            {{__('Costumer Area')}}
        </li>
    @endif

    @if(auth()->user()->ref==null && auth()->id()==7810)

        <div class="py-2 px-4"><a href="#" data-bs-toggle="modal" data-bs-target="#AddBalanceModal"
                                  data-bs-backdrop="false"
                                  style="cursor: pointer"
                                  class="text-decoration-none cursor bg-dark text-white fw-bold py-2 px-3 rounded">{{__('Balance')}}
                : {{number_format(auth()->user()->balance,2)}} ₺
                &nbsp;&nbsp; <i class="fa fa-plus fs-3"></i></a>
        </div>
        <hr>
    @endif

    <li class="{{ Request::route()->getName() == 'panel.user.dashboard' ? ' active-page' : '' }}">
        <a href="{{ route('panel.user.dashboard') }}"><i
                    class="material-icons-two-tone">dashboard</i>{{__("Dashboard")}}</a>
    </li>
    <style>
        .rainbow-text-loop {
            display: inline-block;
            -webkit-animation: rainbow 5s infinite;
        }

        @-webkit-keyframes rainbow {
            0% {
                color: #00b2ff;
            }
            10% {
                color: #007580;
            }
            20% {
                color: #1984a4;
            }
            30% {
                color: #2e9ca6;
            }
            40% {
                color: #00d0ff;
            }
            50% {
                color: #138a91;
            }
            60% {
                color: #007c80;
            }
            70% {
                color: #229ea9;
            }
            80% {
                color: #0a8fad;
            }
            90% {
                color: DodgerBlue;
            }
            100% {
                color: #147585;
            }
        }
    </style>
    {{--<li>
        <a class="fw-bold" target="_blank"
           href="@if(auth()->user()->locale=='tr')https://forms.gle/t8P8j7nfXFur9U7q9 @else https://forms.gle/3pBuipMMEm3XzRvo8 @endif"><i
                    class="material-icons-two-tone">feedback</i><span class="rainbow-text-loop">{{__("Feedback")}}</span></a>
    </li>--}}
    <li class="{{ Request::route()->getName() == 'panel.service.licenseCenter' ? 'active-page' : '' }}">
        <a href="{{ route('panel.service.licenseCenter') }}"><i
                    class="material-icons-two-tone">downloading</i><b>{{__("Lisans İndir")}}</b> {{--<span class="btn btn-sm btn-success p-1 ml-4">(v2.1 Beta)</span>--}}
        </a>
    </li>
    <li class="sidebar-title">
        {{__('Services')}}
    </li>
    <li class="{{ Request::route()->getName() == 'panel.service.envatoelements' ? 'active-page' : '' }}">
        <a href="{{ route('panel.service.envatoelements') }}">
						<span class="menu-icon">
												<span class="svg-icon svg-icon-2">
<svg style="width: 24px;height: 24px;" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
     viewBox="0 0 107.65 122.88"><defs><style>.cls-1 {
                fill: #82b541;
            }</style></defs><title>envato</title><path class="cls-1"
                                                       d="M91.76,1C88.16-1,77.83.18,65.44,4c-21.7,14.83-40,36.69-41.29,71.78-.24.83-2.38-.12-2.8-.38-5.86-11.23-8.18-23.06-3.29-40.12.91-1.51-2.07-3.38-2.61-2.85a61.75,61.75,0,0,0-8.52,11C-7.81,69,1.83,101.78,27.62,116.12a53.44,53.44,0,0,0,72.69-20.69C116.92,65.66,101.5,6.38,91.76,1Z"></path></svg>
												</span></span>
            Envato Elements
        </a>
    </li>
    <li class="{{ Request::route()->getName() == 'panel.service.freepik' ? 'active-page' : '' }}">
        <a class="menu-link " href="{{ route('panel.service.freepik') }}">
						<span class="menu-icon">
												<span class="svg-icon svg-icon-2">

<svg style="width: 24px;height: 24px;" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 266 223.5"
     width="2500" height="2101"><style>.st0 {
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
        }</style><title>freepik</title><g id="Cwb6Ph.tif"><path class="st0"
                                                                d="M46.3 157.8c-1-5.4-2.3-10.7-3-16.1-2.8-21.1 1.7-40.6 14.2-58C67.3 70 80.7 60.5 96.1 53.9c18.5-7.9 38.4-12.2 58.5-12.6 17.9-.5 33.5 6.1 47.1 17.3 14 11.6 24.8 25.9 33.1 42 4 7.8 7.7 15.8 11.5 23.8.4.9.7 1.9.9 2.9-5.3 3.2-10.4 6.5-15.8 9.4-20 11-41.6 18.5-64.1 22.4-12.3 2.1-24.7 3.3-37.1 4.1-11.8.8-23.6 1.2-35.4.9-16.1-.4-32.1-2.9-48.5-6.3zm25.4-53.6c-.3 17.6 14 31.8 31.4 32 16.8.2 32.5-12.7 32.5-31.6 0-19.6-15.1-32-32-32-17.5 0-31.8 14.1-31.9 31.6zm122.9 9.2c9.5.7 20.1-7.2 20.2-20.2.1-10.8-8.6-19.6-19.4-19.7h-.4c-11-.2-20 8.6-20.2 19.5v.3c0 11.4 8.5 20.1 19.8 20.1z"></path><path
                class="st1"
                d="M247.8 131.8c1.4 16.8-2.8 31.6-11.2 45.2-11.4 18.4-28.4 30-48.4 37.3-20.4 7.4-42.1 10.3-63.7 8.7-12.9-.9-25.9-2.8-37.5-8.9-20-10.6-32.4-27.5-38.9-49-.3-1.3-.4-2.7-.5-4 70.5 16.3 137.4 9.1 200.2-29.3z"></path><path
                class="st2"
                d="M244.5 70.7c5.2-1.9 5.2-2 4.7-6.9-.3-2.8-.4-5.6 1-8.3.6-1.1.5-2.5.6-3.8.2-4 3.5-7.1 7.5-7.1s7.4 3.2 7.6 7.2c0 4-3.2 7.3-7.2 7.5-1.3.1-2.6 0-4.4 0-.2 2-.6 3.8-.4 5.5.6 4.9-.2 9-5.8 11.1l11.4 20.2-17.1 10.6C235.2 90 224.2 76.2 211 63.6l10.2-12.4c9.5 4.5 16.6 11.7 23.3 19.5zM38.7 132.6L22.1 127c-.8-10 1.3-19.3 5-28.4l-5.8-9.2c-2.1 0-4.2.4-6-.1-4-.9-7.9-2.1-11.6-3.6C.8 84.5-.5 80.5.3 77.6c1.1-3.5 4.4-5.7 8-5.4 3.4.3 6.2 2.9 6.7 6.3.2 1.6 0 3.3 0 5.3h8.8c3.7 1.5 3.5 6 6.3 8.9 5.5-7.2 10.9-14.4 19.1-19.5l7.6 5.9c-5.8 8-12 15.5-14.1 24.8-2.1 9.4-2.7 18.8-4 28.7z"></path><path
                class="st3"
                d="M106.7 48.2l-3.4-8.4c9.4-7.5 20.1-10.6 31.4-12.1.2-3-1.3-4.3-3.6-5.5-7.8-4-9.1-13.4-2.9-19.1 3.7-3.4 8.1-3.9 12.5-2.2 4 1.4 6.8 5.1 7.1 9.4.7 4.6-1.5 9.1-5.5 11.4-1.1.6-2.3 1.1-3.4 1.6l1.2 3.8c10.1-.2 20-.1 29.8 3.8l-1.4 8.3c-20.7.1-41.7-1-61.8 9z"></path></g></svg>

												</span>
                            <!--end::Svg Icon-->
											</span>
            Freepik {{--<span class="badge badge-primary">V7.1</span>--}}
        </a>
    </li>

        <li class="{{ Request::route()->getName() == 'panel.service.motionarray' ? 'active-page' : '' }}">
            <a class="menu-link {{ Request::route()->getName() == 'panel.service.motionarray' ? ' active' : '' }}"
               href="{{ route('panel.service.motionarray') }}">
						<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg')}-->
												<span class="svg-icon svg-icon-2 ">
													<svg style="background: purple; width: 24px;height: 24px;"
                                                         version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                         width="28.000000pt" height="28.000000pt"
                                                         viewBox="0 0 128.000000 128.000000"
                                                         preserveAspectRatio="xMidYMid meet">

            <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" fill="#ffffff" stroke="none">
                <path d="M0 640 l0 -640 640 0 640 0 0 640 0 640 -640 0 -640 0 0 -640z m415
73 c26 -71 51 -132 55 -136 4 -4 29 53 56 127 l49 136 58 0 57 0 0 -201 0
-200 -42 3 -43 3 -5 113 -5 112 -44 -115 -43 -115 -37 0 -37 0 -44 117 -45
117 -5 -114 -5 -115 -42 -3 -43 -3 0 200 0 201 59 0 58 0 48 -127z m530 13
c45 -19 55 -42 55 -129 0 -57 4 -76 15 -81 9 -3 15 -19 15 -41 0 -33 -2 -35
-34 -35 -19 0 -42 7 -50 15 -14 14 -18 14 -45 0 -97 -50 -207 29 -161 116 17
30 64 49 125 49 56 0 65 8 46 39 -13 20 -71 18 -86 -2 -18 -25 -85 -23 -85 1
0 19 29 51 65 70 28 16 99 15 140 -2z"></path>
                <path d="M838 559 c-35 -20 -17 -59 28 -59 19 0 54 36 54 55 0 18 -55 20 -82
4z"></path>
            </g>
        </svg>
												</span>
                            <!--end::Svg Icon-->
											</span>
                <span class="menu-title">{{__("Motion Array")}} &nbsp;&nbsp;<span class="badge badge-success">{{__('Updated')}}</span></span>
            </a>
        </li>
        <li class="{{ Request::route()->getName() == 'panel.service.epidemicsound' ? 'active-page' : '' }}">
            <a class="menu-link {{ Request::route()->getName() == 'panel.service.epidemicsound' ? ' active' : '' }}"
               href="{{ route('panel.service.epidemicsound') }}">
						<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg')}-->
												<span class="svg-icon svg-icon-2 ">

<svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px"><path d="M 14.275391 2.0019531 C 11.365107 2.045791 8.5075 3.1841406 6.359375 5.3066406 C 4.192375 7.4496406 3 10.296125 3 13.328125 C 3 16.358125 4.192375 19.207609 6.359375 21.349609 L 6.7265625 21.710938 C 6.9135625 21.895938 7.1656875 22 7.4296875 22 L 13.345703 22 C 13.750703 22 14.115531 21.755859 14.269531 21.380859 C 14.423531 21.005859 14.336828 20.574063 14.048828 20.289062 L 10.724609 17.003906 C 9.7306094 16.020906 9.1835938 14.716125 9.1835938 13.328125 C 9.1835937 11.941125 9.7306094 10.635344 10.724609 9.6523438 C 12.571532 7.8287205 15.450849 7.646168 17.509766 9.0898438 L 11.40625 15.298828 C 11.12425 15.585828 11.041266 16.014719 11.197266 16.386719 C 11.352266 16.757719 11.716141 16.998047 12.119141 16.998047 L 19 16.998047 C 19.553 16.998047 20 16.551047 20 15.998047 L 20 9.046875 L 20 4.03125 C 20 3.64625 19.777687 3.2949062 19.429688 3.1289062 C 17.786438 2.3440313 16.021561 1.9756504 14.275391 2.0019531 z"/></svg>
												</span>
                            <!--end::Svg Icon-->
											</span>
                <span class="menu-title">{{__("Epidemic Sound")}} &nbsp;&nbsp;<span class="badge badge-success">{{__('NEW')}}</span></span>
            </a>
        </li>
    <li class="{{ Request::route()->getName() == 'panel.service.shutterstock' ? 'active-page' : '' }}">
        <a href="{{ route('panel.service.shutterstock') }}">
						<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg')}-->
												<span class="svg-icon svg-icon-2">
													<svg style="width: 24px;height: 24px;" version="1.1" id="Layer_1"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 396.918 396.918"
                                                         style="enable-background:new 0 0 396.918 396.918;"
                                                         xml:space="preserve">
<path style="fill:#FF1A03;" d="M0,22.652v351.614c0,12.51,10.141,22.652,22.652,22.652h351.614c12.51,0,22.652-10.141,22.652-22.652
	V22.652C396.917,10.141,386.776,0,374.266,0H22.652C10.141,0,0,10.141,0,22.652z M180.96,108.222h-62.29
	c-6.256,0-11.344,5.088-11.344,11.344v59.92H55.353v-59.92c0-34.912,28.405-63.317,63.317-63.317h62.291L180.96,108.222
	L180.96,108.222z M341.565,277.352c0,34.912-28.405,63.317-63.317,63.317h-62.291v-51.973h62.291
	c6.256,0,11.344-5.088,11.344-11.344v-59.92h51.973L341.565,277.352L341.565,277.352z"></path>
</svg>
												</span>
                            <!--end::Svg Icon-->
											</span>
            &nbsp;ShutterStock {{--<span class="badge badge-danger">{{__('Bakımda')}}</span>--}}
        </a>
    </li>
    <li class="{{ Request::route()->getName() == 'panel.service.adobestock' ? 'active-page' : '' }}">
        <a href="{{ route('panel.service.adobestock') }}">
						<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg')}-->
												<span class="svg-icon svg-icon-2">
													<svg style="width: 29px;height: 30px;" version="1.1" id="Layer_1"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 190 190" xml:space="preserve">
  <path class="st0"
        d="M0 122V27.4c0-1.8.1-3.6.5-5.3s.9-3.5 1.6-5.1 1.5-3.2 2.5-4.8S6.8 9.3 8 8c1.3-1.3 2.7-2.4 4.2-3.4s3.1-1.9 4.8-2.5c1.7-.7 3.4-1.2 5.1-1.6 1.8-.4 3.5-.5 5.3-.5h100.2c1.8 0 3.6.1 5.3.5 1.8.4 3.5.9 5.1 1.6s3.2 1.5 4.8 2.5 2.9 2.2 4.2 3.4c1.3 1.3 2.4 2.7 3.4 4.2s1.9 3.1 2.5 4.8c.7 1.7 1.2 3.4 1.6 5.1.4 1.8.5 3.5.5 5.3V122c0 1.8-.1 3.6-.5 5.3-.4 1.8-.9 3.5-1.6 5.1-.7 1.7-1.5 3.2-2.5 4.8s-2.2 2.9-3.4 4.2c-1.3 1.3-2.7 2.4-4.2 3.4s-3.1 1.9-4.8 2.5c-1.7.7-3.4 1.2-5.1 1.6-1.8.4-3.5.5-5.3.5H27.5c-1.8 0-3.6-.1-5.3-.5-1.8-.4-3.5-.9-5.1-1.6-1.7-.7-3.2-1.5-4.8-2.5s-2.9-2.2-4.2-3.4c-1.3-1.3-2.4-2.7-3.4-4.2s-1.9-3.1-2.5-4.8c-.7-1.7-1.2-3.4-1.6-5.1-.4-1.6-.6-3.4-.6-5.3z"/>
            <path d="M54.9 109.6c-3.8 0-7.3-.4-10.4-1-3.1-.6-5.7-1.5-7.9-2.5-.6-.3-.8-.9-.8-1.7V92.2c0-.3.1-.4.3-.6.1-.1.4-.1.6.1 2.9 1.8 5.9 3.1 9.1 4 3.2.9 6.3 1.3 9.4 1.3 3.9 0 6.7-.6 8.4-1.8 1.7-1.2 2.5-2.7 2.5-4.5 0-1.2-.3-2.2-.8-3.1-.6-.9-1.5-1.8-2.9-2.7-1.4-.9-3.2-1.8-5.6-2.7L51.7 80c-4.2-1.8-7.4-3.7-9.8-5.7-2.4-2-4-4.2-4.8-6.5-.9-2.3-1.4-4.8-1.4-7.5 0-3.7.9-7.1 2.7-10 1.9-3 4.5-5.4 8.2-7.1 3.6-1.7 8.2-2.6 13.6-2.6 3.2 0 6.3.2 9.2.6 2.8.4 5.1 1.1 6.8 1.9.5.3.7.7.7 1.3V56c0 .1-.1.3-.3.4-.1.1-.4.1-.6-.1-2-1.1-4.5-1.9-7.1-2.6-2.7-.4-5.6-.7-8.5-.7-1.9 0-3.7.1-5 .5-1.4.4-2.5.8-3.3 1.3s-1.5 1.2-1.9 1.9c-.4.8-.6 1.6-.6 2.4 0 1.1.3 2.1.9 2.9.6.9 1.7 1.7 3.1 2.6 1.4.9 3.4 1.9 5.9 3l3.8 1.4c4.5 1.9 8 3.8 10.5 5.9 2.5 2.1 4.3 4.3 5.3 6.8s1.5 5 1.5 7.9c0 4-1.1 7.6-3.2 10.6-2.2 3-5.1 5.4-8.9 7s-8.4 2.4-13.6 2.4zm60.3-11.1v8.4c0 .7-.3 1.2-.8 1.3-1.3.4-2.7.7-4.1 1s-3.1.4-4.9.4c-4.5 0-7.9-1.2-10.5-3.5-2.5-2.3-3.8-6.1-3.8-11.2V69.6H85c-.6 0-.8-.3-.8-.9V58.5c0-.6.3-.8.9-.8h6.1c.1-1.2.1-2.5.3-4 .1-1.5.2-3.1.4-4.6.1-1.5.3-2.8.4-3.8.1-.2.1-.4.3-.6.1-.1.3-.3.5-.4l12.2-1.5c.2-.1.4-.1.5 0 .1.1.2.3.2.6-.1 1.6-.2 3.7-.3 6.4-.1 2.7-.1 5.3-.2 7.9h9.5c.4 0 .6.3.6.8v10.4c0 .4-.1.6-.5.7h-9.7v21.9c0 2.3.4 4 1.2 5 .8 1 2.2 1.5 4.3 1.5.6 0 1.2 0 1.7-.1.6 0 1.1-.1 1.7-.1.2-.1.4-.1.6.1.2.1.3.3.3.6z"
                  fill="#fff"/>
</svg>
												</span>
                            <!--end::Svg Icon-->
											</span>
            Adobe Stock {{--<span class="badge badge-danger">{{__('Bakımda')}}</span>--}}
        </a>
    </li>

        <li class="{{ Request::route()->getName() == 'panel.service.flaticon' ? 'active-page' : '' }}">
            <a class="menu-link " href="{{ route('panel.service.flaticon') }}">
						<span class="menu-icon">
												<span class="svg-icon svg-icon-2">

<svg style="width: 24px;height: 24px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve">
                    <path style="fill:#16D298;"
                          d="M13.462 7.626H7.816L6.05 4.606h9.178L17.902 0H2.732a2.73 2.73 0 0 0-2.36 1.354 2.652 2.652 0 0 0 0 2.707l9.673 16.606c.76 1.288 2.443 1.717 3.747.958a2.86 2.86 0 0 0 .974-.958l.313-.545-4.44-7.659 2.823-4.837Z"></path><path
            fill="#16D298"
            d="M24.473 1.354A2.71 2.71 0 0 0 22.112 0h-.66l-7.264 12.463 2.675 4.606 7.61-13.041a2.67 2.67 0 0 0 0-2.674Z"></path></svg>

												</span>
                            <!--end::Svg Icon-->
											</span>
                Flaticon {{--<span class="badge badge-success">{{__('New')}} <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></span>--}}
            </a>
        </li>

    <li class="sidebar-title">
        {{__('Store')}}
    </li>
    @if(auth()->user()->ref==null)
        <li class="{{ Request::route()->getName() == 'panel.shop' ? 'active-page' : '' }}">
            <a href="{{ route('panel.shop') }}"><i
                        class="material-icons-two-tone">store</i>{{__("Store")}}</a>
        </li>
    @endif
    <li class="">
        <a href="#" data-bs-toggle="modal" data-bs-target="#usingKeyModal"><i
                    class="material-icons-two-tone">downloading</i>{{__("Using Key")}}</a>
    </li>
    @if(auth()->user()->ref=='7728')
        <li>
            <a href="https://wa.me/261349977393" target="_blank" class="btn btn-success btn-sm fw-bold text-white"><i
                        class="fab fa-whatsapp" style="color:white!important;"></i>{{__("Whatsapp Support")}}</a>
        </li>
    @else
        <li>
            <a href="https://wa.me/908503094032" target="_blank" class="btn btn-success btn-sm fw-bold text-white"><i
                        class="fab fa-whatsapp" style="color:white!important;"></i>{{__("Whatsapp Support")}}</a>
        </li>
    @endif
</ul>


<div class="modal fade" id="AddBalanceModal" tabindex="-1" role="dialog"
     aria-labelledby="AddBalanceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" method="post" action="{{route('panel.usingkey')}}"
             style="    box-shadow: 0px 1px 267px 129px #cfffcb;border: 3px solid #cfffcb">
            <div class="modal-header">
                <h5 class="modal-title" id="usingKeyModalLabel">{{__("Balance Add")}}</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <i class="fa fa-times fa-2x text-danger"></i></span>
                </div>
            </div>
            <div class="modal-body">
                @csrf
                @method('POST')
                <p>Lütfen yüklemek istediğiniz tutarı giriniz ;</p>
                <small class="text-danger">Minimum 200 !</small>
                <div class="input-group">
                    <span class="input-group-text">₺</span>
                    <input type="number" name="price" id="addBalancePrice" class="form-control" value="200">
                    {{-- <button class="btn btn-success">Öde</button>--}}
                </div>
                <small class="text-danger">Tahminen Ödeme Yapılacak Tutar Dolar Cinsinden : $ <b
                            id="totalAddBalanceUSD">0.00</b></small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">{{__("Buy Now")}}</button>
                <button type="button" class="btn btn-warning"
                        data-bs-dismiss="modal">{{__("Pay with Crypto")}}</button>
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{__("Cancel")}}</button>
            </div>
        </div>
    </div>
</div>


