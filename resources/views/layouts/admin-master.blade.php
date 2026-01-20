<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>@yield('title', 'Stisla Laravel') &mdash; {{ env('APP_NAME') }}</title>
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
          rel="stylesheet">
    <link href="{{asset('v4Assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('v4Assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('v4Assets/plugins/pace/pace.css')}}" rel="stylesheet">
    <link href="{{asset('v4Assets/plugins/highlight/styles/github-gist.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('v4Assets/fonts/flag-icons.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Theme Styles -->
    <link href="{{asset('v4Assets/css/main.min.css')}}" rel="stylesheet">
    @if(\Illuminate\Support\Facades\Auth::user()->theme_mode=='dark')
        <link href="{{asset('v4Assets/css/darktheme.css')}}" rel="stylesheet">
    @endif
    <link href="{{asset('v4Assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('v4Assets/plugins/datatables/datatables.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('v4Assets/images/neptune.png')}}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('v4Assets/images/neptune.png')}}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->
    <script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>
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
            s1.src='https://embed.tawk.to/6712a9414304e3196ad3e229/1iagea9ub';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body>


<div class="app align-content-stretch d-flex flex-wrap">
    <div class="app-sidebar">
        <div class="logo">
            <a href="/" class="logo-icon"><span class="logo-text">{{env('APP_NAME')}}</span></a>
            <div class="sidebar-user-switcher user-activity-online">
                <a href="#">
                    <img src="{{asset('v4Assets/images/avatars/avatar.png')}}">
                    <span class="activity-indicator"></span>
                    <span class="user-info-text">{{auth()->user()->name}}<br><span
                                class="user-state-info">{{auth()->user()->surname}}</span></span>
                </a>
            </div>
        </div>
        <div class="app-menu">
            @include('partials.sidebar')
        </div>
    </div>
    <div class="app-container">

        <div class="app-header">
            @include('partials.topnav')
        </div>
        <div class="app-content">
            <div class="content-wrapper">
                <div class="container">
                    @include('kustomer::kustomer')

                    @if(auth()->user()->ref==null)
                        @if(auth()->user()->locale=="tr")
                         {{-- <div class="announcement-bar my-4">
                                <div class="alert alert-danger alert-dismissible fade show text-center m-0"
                                     role="alert">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true"></span>
                                    <strong>🎉 Özel İndirim Fırsatı! 🎉</strong>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true"></span>
                                    <br>Sayın Müşterilerimiz, Envato ve Freepik üyeliklerinde sınırlı bir
                                    süre için özel indirimler sunmaktayız.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            </div>--}}
                        @else
                           {{--  <div class="announcement-bar my-4">
                                 <div class="alert alert-danger alert-dismissible fade show text-center m-0"
                                      role="alert">
                                     <span class="spinner-border spinner-border-sm" role="status"
                                           aria-hidden="true"></span>
                                     <strong>🎉 Special Discount Opportunity! 🎉</strong>
                                     <span class="spinner-border spinner-border-sm" role="status"
                                           aria-hidden="true"></span>
                                     <br>Dear Customers, we are offering special discounts on Envato and Freepik memberships for a limited time.
                                     <button type="button" class="btn-close" data-bs-dismiss="alert"
                                             aria-label="Close"></button>
                                 </div>
                             </div>--}}
                        @endif
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
                </div>
            </div>
            <!-- Using Key Modal -->
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


            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme" style="margin-top: 52px">
                <div class="container d-flex justify-content-between " style="position: absolute;
    bottom: 14px;">

                        <span class="footer-link fw-bolder mr-4 "> ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                             Made with ❤️ by {{env('APP_NAME')}}</span>
                    @if(auth()->user()->ref!=null)
                        <span><img src="{{asset('payments2.jpg')}}" height="50"></span>
                    @else
                        <span><img src="{{asset('paytr/payments.png')}}" height="50"></span>
                    @endif
                    @if(auth()->user()->ref==null)
                        <a href="https://t.me/travexa" target="_blank" class="menu-link px-2 text-decoration-none">Powered
                            by VOLT
                            SOFTWARE</a>
                    @endif
                </div>
            </footer>
            <!-- / Footer -->
        </div>
    </div>
</div>

<!-- Javascripts -->
<script src="{{asset('v4Assets/plugins/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('v4Assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('v4Assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('v4Assets/plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('v4Assets/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('v4Assets/plugins/highlight/highlight.pack.js')}}"></script>
<script src="{{asset('v4Assets/plugins/datatables/datatables.min.js')}}"></script>
<script src="{{asset('v4Assets/js/main.min.js')}}"></script>
<script src="{{asset('v4Assets/js/custom.js')}}"></script>
<script src="{{asset('v4Assets/js/pages/datatables.js')}}"></script>

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
<script>
    $(document).on('keyup', '#addBalancePrice', () => {
        /*if(Number($('#addBalancePrice').val())<200)
            $('#addBalancePrice').val(200)*/
        $('#totalAddBalanceUSD').html((Number($('#addBalancePrice').val()) / 30).toFixed(2))
    })
</script>
</body>

</html>