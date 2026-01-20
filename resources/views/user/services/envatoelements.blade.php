@extends('layouts.SolarTheme')

@section('title')
    Envato Elements
@endsection
@section('topbuttons')

    <div class="card p-4 mb-8 w-100" style="
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle, #c4f89e, #87e64b);
">
        <div>
            <svg style="width: 64px; height: 64px;" width="46" height="64" viewBox="0 0 46 64" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M25.5598 64.0081C27.1393 64.0081 28.4198 62.7276 28.4198 61.1481C28.4198 59.5686 27.1393 58.2881 25.5598 58.2881C23.9802 58.2881 22.6998 59.5686 22.6998 61.1481C22.6998 62.7276 23.9802 64.0081 25.5598 64.0081Z"
                      fill="#fff"/>
                <path d="M41.9998 41.648L25.8698 43.378C25.5698 43.408 25.4198 43.038 25.6598 42.848L41.4398 30.558C42.4598 29.718 43.1198 28.418 42.8398 27.018C42.5598 24.878 40.7898 23.478 38.5498 23.758L21.3998 26.268C21.0998 26.308 20.9398 25.928 21.1798 25.738L38.1798 12.758C41.5298 10.148 41.8098 5.02804 38.7398 2.04804C35.9498 -0.741956 31.4698 -0.651956 28.6798 2.13804L1.28975 30.008C0.269752 31.128 -0.200248 32.618 0.079752 34.198C0.549752 36.718 3.05975 38.388 5.57975 37.928L20.3498 34.918C20.6698 34.848 20.8398 35.278 20.5698 35.458L4.18975 45.948C2.13975 47.248 1.20975 49.578 1.85975 51.908C2.50975 54.978 5.58975 56.748 8.56975 56.008L33.0598 49.978C33.3398 49.908 33.5398 50.228 33.3598 50.448L29.5398 55.168C28.5198 56.468 30.1898 58.238 31.5898 57.218L44.1698 46.878C46.4098 45.018 44.9198 41.378 42.0298 41.658L41.9998 41.648Z"
                      fill="#fff"/>
            </svg>
        </div>
{{--
        <style>
            .envato-banner {
                background-color: #fff3cd;
                color: #856404;
                border: 1px solid #ffeeba;
                padding: 16px;
                margin: 20px auto;
                max-width: 800px;
                border-radius: 6px;
                font-family: Arial, sans-serif;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .envato-banner h3 {
                margin-top: 0;
                color: brown;
            }
            .envato-banner a {
                color: #856404;
                font-weight: bold;
                text-decoration: underline;
            }
            .envato-banner a:hover {
                text-decoration: none;
            }
        </style>

        <div class="envato-banner">
            <h3>⚠️ Envato Elements Servis Durumu</h3>
            <p>Envato Elements servisimiz şu anda <strong>Envato'nun kendi altyapısındaki bir kesinti</strong> nedeniyle geçici olarak çalışmamaktadır.</p>
            <p>Bu sorun <strong>bizden kaynaklı değildir</strong> ve doğrudan Envato tarafındandır.</p>
            <p>Güncel durumu takip etmek için:
                <a href="https://status.envato.com/" target="_blank" rel="noopener noreferrer">status.envato.com</a>
            </p>
            <p>Gelişmeleri yakından izliyoruz. Anlayışınız için teşekkür ederiz.</p>
        </div>--}}

        {{--  <div>
              <h3 class="p-0 m-0 fw-bold" style="color: #fff">Envato Elements</h3>
          </div>--}}

        {{--<div>
            <a href="javascript:void(0)" class="btn btn-success mb-1 waves-effect waves-light">
                <i class="ti ti-server-bolt ti-xs me-2"></i>{{__('Service Status')}} : {{__('Active')}}
            </a>
        </div>--}}
    </div>

@endsection
@section('content')
    {{--
        @dd('GEÇİCİ BİR SÜRE BAKIMDADIR. | TEMPORARILY UNDER MAINTENANCE.')
    --}}
    @if($data)
        <div class="row g-5 g-xl-8">
            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <div class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">


                        <div class="text-white fw-bold fs-5">
                            {{$downs}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Remaining Daily Download")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <div class="card bg-success hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="text-white fw-bold fs-5">
                            {{\Carbon\Carbon::create($data->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Service End Date")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <div class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">


                        <div class="text-white fw-bold fs-5">
                            {{$maxp->total}}/{{$maxp->max}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Max Download Quota (Preiod)")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <div class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="text-white fw-bold fs-5">
                            {{$allDowns}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Total Downloads")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 5-->
            </div>
        </div>
        {{--<div class="alert alert-danger fw-bold">
            📢 Envato Elements sitesinde yapılan kapsamlı bir arka plan güncellemesi nedeniyle sistemde geçici kesintiler
            yaşanmaktadır. Bu değişikliğe en kısa sürede uyum sağlamak ve hizmeti sorunsuz şekilde tekrar kullanıma
            sunmak için yoğun bir şekilde çalışıyoruz. Lütfen sabırlı olun ve beklemede kalın.
            <hr>
            📢 Due to a major background update on the Envato Elements site, temporary service interruptions are
            occurring. We are working intensively to adapt quickly and restore the service smoothly as soon as possible.
            Please stay patient and stay tuned!
            <hr>
            📢 Debido a una actualización importante en segundo plano en el sitio de Envato Elements, se están
            produciendo interrupciones temporales del servicio. Estamos trabajando intensamente para adaptarnos
            rápidamente y restablecer el servicio sin problemas lo antes posible. ¡Por favor, tenga paciencia y
            manténgase atento!
        </div>--}}

        <div class="row">
            <div class="col-sm-6">
                <div class="card p-4">
                    <div class="card-header p-2 fs-5 fw-bolder mb-4 ">
                        Envato Elements
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="text" style="color:#0b0b0b;" class="form-control rounded-end-0"
                               id="envatoelements_url"
                               placeholder="{{__("Please enter the content URL.")}}">
                        <button style="width: 300px!important;height: 43px!important;"
                                class="btn btn-light btn-sm rounded-start-0"
                                id="envatoelements_down">{{__("Create Link")}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card p-4">

                    <div class="card-header p-2 fs-5 fw-bold mb-4 ">
                        @if(auth()->user()->locale=='tr')
                            Tema ve Uzantıları için Token Alın
                            <button class="btn-sm btn btn-info"
                                    onclick="Swal.fire({title:'<h4 class=\'fs-6 fw-bold text-black\'>2. Adımda, `Follow this link` metnine sağ tıklayın ve bağlantıyı kopyalayıp Aşağıdaki içerik bağlantısını buraya yapıştır yazan alana yapıştırın.</h4><h4 class=\'fs-6 fw-bold text-danger\'>Not: Resimdeki gibi bir yer görmüyorsanız, bu tema Envato Elements tarafından desteklenmiyor demektir!</h4>',imageUrl:'{{asset('envatoToken.png')}}'})">
                                <i class="fa-solid fa-question"></i>&nbsp;&nbsp;Nasıl Kullanılır
                            </button>
                        @else
                            Get Token for Theme and Extensions
                            <button class="btn-sm btn btn-info"
                                    onclick="Swal.fire({title:'<h4 class=\'fs-6 fw-bold text-black\'>In Step 2, right-click on the text `Follow this link` and copy and paste the link into the field that says Paste the following content link here.</h4><h4 class=\'fs-6 fw-bold text-danger\'>Note: If you don\'t see a place like in the image, this theme is not supported by Envato Elements !</h4>',imageUrl:'{{asset('envatoToken.png')}}'})">
                                <i class="fa-solid fa-question"></i>&nbsp;&nbsp;How to Use
                            </button>
                        @endif
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control rounded-end-0" id="tenvatoelements_url"
                               placeholder="{{__("Please enter the content URL.")}}">
                        <button style="width: 300px!important;height: 43px!important;"
                                class="btn btn-success rounded-start-0"
                                id="tenvatoelements_down">{{__("Create")}}
                        </button>
                    </div>

                    @section('scripts')
                        <script>
                            let nolimit = "{!! __('Your download quota is over! <br> To use the service, you must purchase this service. <br> To purchase, visit the store page.')  !!}"
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $('#envatoelements_down').click(() => {
                                swal.fire({
                                    title: '{{__("Now loading")}}',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onOpen: () => {
                                        swal.showLoading();
                                    }
                                })
                                $.post('<?= route('api.envatoelements') ?>', {
                                    type: 'file',
                                    url: $('#envatoelements_url').val(),
                                    token_: $('meta[name="csrf-token"]').attr('content')
                                }).done((response) => {
                                    console.log(response)
                                    if (response.success) {
                                        swal.fire({
                                            title: '',
                                            html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.url + '" target="_blank">{{__("Click For Download")}}</a>',
                                            icon: 'success'
                                        })
                                        window.open(response.url)
                                        $('#envatoelements_url').val("")
                                    } else {
                                        swal.fire({
                                            title: '{{__("Error")}}',
                                            html: '{{__("An unknown error has occurred, please try again later.")}}<br><br>' + (response.error == 'nolimit' ? nolimit : response.error),
                                            icon: 'warning'
                                        })
                                    }
                                }).fail(() => {
                                    swal.fire({
                                        title: '{{__("Error")}}',
                                        html: '{{__("An unknown error has occurred, please try again later.")}}',
                                        icon: 'warning'
                                    })
                                });
                            })

                            $('#tenvatoelements_down').click(() => {
                                swal.fire({
                                    title: '{{__("Now loading")}}',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onOpen: () => {
                                        swal.showLoading();
                                    }
                                })
                                $.post('<?= route('api.tenvatoelements') ?>', {
                                    type: 'file',
                                    url: $('#tenvatoelements_url').val(),
                                    token_: $('meta[name="csrf-token"]').attr('content')
                                }).done((response) => {
                                    if (response.status) {
                                        swal.fire({
                                            html: '<input type="text" class="form-control text-black" value="' + response.tokenCode + '">',
                                            icon: 'success'
                                        })
                                        $('#tenvatoelements_url').val("")
                                    } else {
                                        swal.fire({
                                            title: '{{__("Error")}}',
                                            html: '{{__("An unknown error has occurred, please try again later.")}}<br><br>' + response.error,
                                            icon: 'warning'
                                        })
                                    }
                                }).fail(() => {
                                    swal.fire({
                                        title: '{{__("Error")}}',
                                        html: '{{__("An unknown error has occurred, please try again later.")}}',
                                        icon: 'warning'
                                    })
                                });
                            })
                        </script>
                </div>
                @endsection
            </div>
        </div>
        </div>
    @else

        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">

                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">

                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <p class="fs-5 fw-bold">{!!__("To use the service you need to purchase this service.<br> Visit the store page to purchase.")!!}</p>
                                    <a href="{{route('panel.shop')}}"
                                       class="btn btn-outline-primary widget-info-action">{{__('Buy Now')}}</a>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-danger mb-1 waves-effect waves-light">
                                    <i class="ti ti-server-bolt ti-xs me-2"></i>Premium : {{__('Passive')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
