<nav class="navbar navbar-light navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-nav " id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                </li>
            </ul>

        </div>

        <div class="d-flex hidden-on-mobile">
            <ul class="navbar-nav">

                <div class="hidden-on-mobile" style="display: flex;
    justify-content: space-between;
    align-items: center;">
                    <a class="nav-item" href="{{route('setThemeMode')}}">
                        @if(\Illuminate\Support\Facades\Auth::user()->theme_mode=='light')
                            <i class="fa-solid fa-moon fs-1 text-dark p-4"></i>
                        @else
                            <i class="fa-solid fa-sun fs-1 text-warning p-4"></i>
                        @endif
                    </a>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown"
                           data-bs-toggle="dropdown">
                            @if(auth()->user()->locale=='tr')
                                <i class="fi fi-tr fis rounded-circle fs-1 me-1"></i>
                            @elseif(auth()->user()->locale=='en')
                                <i class="fi fi-us fis rounded-circle fs-1 me-1"></i>
                            @elseif(auth()->user()->locale=='es')
                                <i class="fi fi-es fis rounded-circle fs-1 me-1"></i>
                            @elseif(auth()->user()->locale=='bd')
                                <i class="fi fi-bd fis rounded-circle fs-1 me-1"></i>
                            @endif

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown"
                            aria-labelledby="languageDropDown">
                            <li><a class="dropdown-item" href="?setLang=tr"><i
                                            class="fi fi-tr fis rounded-circle fs-1 me-1"></i>Türkçe</a></li>
                            <li><a class="dropdown-item" href="?setLang=en"><i
                                            class="fi fi-us fis rounded-circle fs-1 me-1"></i>English</a></li>
                            <li><a class="dropdown-item" href="?setLang=es"><i
                                            class="fi fi-es fis rounded-circle fs-1 me-1"></i>Spanish</a></li>
                            <li><a class="dropdown-item" href="?setLang=bd"><i
                                            class="fi fi-bd fis rounded-circle fs-1 me-1"></i>বাংলা</a></li>
                        </ul>
                    </li>
                    {{-- <a class="nav-item  pr-4" href="?setLang=tr">
                         <i class="fi fi-tr fis rounded-circle fs-1 me-1"></i>
                     </a>
                     <a class="nav-item" href="?setLang=en">
                         <i class="fi fi-us fis rounded-circle fs-1 me-1"></i>
                     </a>--}}

                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#"
                           data-bs-toggle="dropdown"><i class="fa-regular fa-bell"></i> 1</a>
                        <div class="dropdown-menu dropdown-menu-end notifications-dropdown"
                             aria-labelledby="notificationsDropDown">
                            <h6 class="dropdown-header">{{__('Notifications')}}</h6>
                            <div class="notifications-dropdown-list">
                                <a href="javascript:void(0)">
                                    <div class="notifications-dropdown-item">
                                        <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge bg-info text-white">
                                                            <i class="material-icons-outlined">campaign</i>
                                                        </span>
                                        </div>
                                        <div class="notifications-dropdown-item-text">
                                            <p class="bold-notifications-text">
                                                @if(auth()->user()->locale=='tr')
                                                    📢 Merhaba! Görüşlerinizi önemsiyoruz! 💬 Sağ alttaki kırmızı yuvarlak
                                                    butona tıklayarak geri bildirimde bulunun. 🌟
                                                @else
                                                    📢 Hello! We value your feedback! 💬 Click the red round button at the
                                                    bottom right to share your thoughts. 🌟
                                                @endif
                                            </p>
                                            <small>{{\Carbon\Carbon::create('2024-05-27')->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>


                </div>


                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img style="width: 45px!important;" src="{{asset('v4Assets/images/avatars/avatar.png')}}"
                                 alt
                                 class=" h-auto rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ Auth::user()->profilelink }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{asset('v4Assets/images/avatars/avatar.png')}}" alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{__("Hi")}}
                                                , {{ Auth::user()->name }}</span>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ Auth::user()->profilelink }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">{{__("Profile Settings")}}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('panel.orders') }}">
                                <i class="bx bx-credit-card me-2"></i>
                                <span class="align-middle">{{__("Order History")}}</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">{{__("Logout")}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="d-md-none d-lg-none" style="list-style: none;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-right: 10px">
            <a class="nav-item" href="{{route('setThemeMode')}}">
                @if(\Illuminate\Support\Facades\Auth::user()->theme_mode=='light')
                    <i class="fa-solid fa-moon fs-1 text-dark p-2"></i>
                @else
                    <i class="fa-solid fa-sun fs-1 text-warning p-2"></i>
                @endif
            </a>

            <li class="nav-item">
                <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown"><i
                            class="fi fi-tr fis rounded-circle fs-1 me-1"></i></a>
                <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                    <li><a class="dropdown-item" href="?setLang=tr"><i
                                    class="fi fi-tr fis rounded-circle fs-1 me-1"></i>Türkçe</a></li>
                    <li><a class="dropdown-item" href="?setLang=en"><i
                                    class="fi fi-us fis rounded-circle fs-1 me-1"></i>English</a></li>
                </ul>
            </li>

            <a class="nav-item me-1" href="{{ route('logout') }}"><i
                        class="p-2 fa-solid fa-right-from-bracket fa-2x"></i></a>
        </div>
    </div>
</nav>