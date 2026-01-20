@extends('layouts.SolarTheme')

@section('title')
    {{__("Store")}}
@endsection

@section('content')
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
        <h4 class="mb-2">⚠️ Servis Bilgilendirme</h4>
        <p class="mb-0">Servis yenilemek veya satın almak için <strong>bayiniz ile iletişime geçiniz</strong>.</p>
    </div>

  {{--  <div class="container py-4">
        @if(auth()->user()->ref!=null)
            <div class="card widget widget-info-inline mb-4 border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="card-title mb-0">
                        @if(auth()->user()->locale=='tr')
                            Hizmet satın almak için bayinizle iletişime geçin.<br>
                            Size hizmet vermekten mutluluk duyarız.
                        @else
                            Contact your dealer to purchase services.<br>
                            We are happy to serve you.
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="widget-info-container">
                        <div class="widget-info-image"
                             style="background: url('https://www.stokla.net/v4Assets/images/widgets/speed.svg')"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="section-header text-center mb-5">
            <h2 class="section-title text-dark">{{__('Select the Product You Want to Buy')}}</h2>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="row justify-content-center g-4">


            <div class="col-md-3 col-lg-3">
                <div class="service-card h-100" id="">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #5602ac, #c304ba);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
<svg height="40px" width="40px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 53.867 53.867" xml:space="preserve"> <polygon
            style="fill:#ffffff;"
            points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/> </svg>                                </span>
                            </div>
                            <h5 class="text-white mb-3">{{__('Other Services')}}</h5>
                            <p class="text-white text-center mb-4">{{__('Other Services-desc')}}</p>
                            <a href="/panel/service/otherServices" class="btn btn-light w-100 mt-auto">{{__('Detail')}}</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="mix">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #245edc, #4db106);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                   <svg style="width: 40px;height: 40px;"   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
    <rect x="20" y="30" width="10" height="40" fill="white"/>
    <rect x="40" y="20" width="10" height="50" fill="white"/>
    <rect x="60" y="10" width="10" height="60" fill="white"/>
    <path d="M20,30 L70,10" stroke="white" stroke-width="2"/>
</svg></span>
                            </div>
                            <h5 class="text-white mb-3">Mix</h5>
                            <p class="text-white text-center mb-4">{{__('Mix-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="envatoelements">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #82B440, #92c550);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                   <svg style="width: 40px;height: 40px;" id="Layer_1" data-name="Layer 1"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 107.65 122.88"><defs><style>.cls-1 {
                                                   fill: rgb(255, 255, 255);
                                               }</style></defs><title>envato</title><path class="cls-1"
                                                                                          d="M91.76,1C88.16-1,77.83.18,65.44,4c-21.7,14.83-40,36.69-41.29,71.78-.24.83-2.38-.12-2.8-.38-5.86-11.23-8.18-23.06-3.29-40.12.91-1.51-2.07-3.38-2.61-2.85a61.75,61.75,0,0,0-8.52,11C-7.81,69,1.83,101.78,27.62,116.12a53.44,53.44,0,0,0,72.69-20.69C116.92,65.66,101.5,6.38,91.76,1Z"></path></svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Envato Elements</h5>
                            <p class="text-white text-center mb-4">{{__('Envato Elements-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="freepik">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #1E88E5, #2470d8);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                   <svg style="width: 40px;height: 40px;" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 266 223.5" width="2500"
                                        height="2101"><style>.st0 {
                                               fill: rgb(239, 241, 243)
                                           }

                                           .st1 {
                                               fill: rgb(255, 255, 255)
                                           }

                                           .st2 {
                                               fill: rgb(255, 255, 255)
                                           }

                                           .st3 {
                                               fill: rgb(255, 255, 255)
                                           }</style><title>freepik</title><g id="Cwb6Ph.tif"><path class="st0"
                                                                                                   d="M46.3 157.8c-1-5.4-2.3-10.7-3-16.1-2.8-21.1 1.7-40.6 14.2-58C67.3 70 80.7 60.5 96.1 53.9c18.5-7.9 38.4-12.2 58.5-12.6 17.9-.5 33.5 6.1 47.1 17.3 14 11.6 24.8 25.9 33.1 42 4 7.8 7.7 15.8 11.5 23.8.4.9.7 1.9.9 2.9-5.3 3.2-10.4 6.5-15.8 9.4-20 11-41.6 18.5-64.1 22.4-12.3 2.1-24.7 3.3-37.1 4.1-11.8.8-23.6 1.2-35.4.9-16.1-.4-32.1-2.9-48.5-6.3zm25.4-53.6c-.3 17.6 14 31.8 31.4 32 16.8.2 32.5-12.7 32.5-31.6 0-19.6-15.1-32-32-32-17.5 0-31.8 14.1-31.9 31.6zm122.9 9.2c9.5.7 20.1-7.2 20.2-20.2.1-10.8-8.6-19.6-19.4-19.7h-.4c-11-.2-20 8.6-20.2 19.5v.3c0 11.4 8.5 20.1 19.8 20.1z"></path><path
                                                   class="st1"
                                                   d="M247.8 131.8c1.4 16.8-2.8 31.6-11.2 45.2-11.4 18.4-28.4 30-48.4 37.3-20.4 7.4-42.1 10.3-63.7 8.7-12.9-.9-25.9-2.8-37.5-8.9-20-10.6-32.4-27.5-38.9-49-.3-1.3-.4-2.7-.5-4 70.5 16.3 137.4 9.1 200.2-29.3z"></path><path
                                                   class="st2"
                                                   d="M244.5 70.7c5.2-1.9 5.2-2 4.7-6.9-.3-2.8-.4-5.6 1-8.3.6-1.1.5-2.5.6-3.8.2-4 3.5-7.1 7.5-7.1s7.4 3.2 7.6 7.2c0 4-3.2 7.3-7.2 7.5-1.3.1-2.6 0-4.4 0-.2 2-.6 3.8-.4 5.5.6 4.9-.2 9-5.8 11.1l11.4 20.2-17.1 10.6C235.2 90 224.2 76.2 211 63.6l10.2-12.4c9.5 4.5 16.6 11.7 23.3 19.5zM38.7 132.6L22.1 127c-.8-10 1.3-19.3 5-28.4l-5.8-9.2c-2.1 0-4.2.4-6-.1-4-.9-7.9-2.1-11.6-3.6C.8 84.5-.5 80.5.3 77.6c1.1-3.5 4.4-5.7 8-5.4 3.4.3 6.2 2.9 6.7 6.3.2 1.6 0 3.3 0 5.3h8.8c3.7 1.5 3.5 6 6.3 8.9 5.5-7.2 10.9-14.4 19.1-19.5l7.6 5.9c-5.8 8-12 15.5-14.1 24.8-2.1 9.4-2.7 18.8-4 28.7z"></path><path
                                                   class="st3"
                                                   d="M106.7 48.2l-3.4-8.4c9.4-7.5 20.1-10.6 31.4-12.1.2-3-1.3-4.3-3.6-5.5-7.8-4-9.1-13.4-2.9-19.1 3.7-3.4 8.1-3.9 12.5-2.2 4 1.4 6.8 5.1 7.1 9.4.7 4.6-1.5 9.1-5.5 11.4-1.1.6-2.3 1.1-3.4 1.6l1.2 3.8c10.1-.2 20-.1 29.8 3.8l-1.4 8.3c-20.7.1-41.7-1-61.8 9z"></path></g></svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Freepik Premium</h5>
                            <p class="text-white text-center mb-4">{{__('Freepik Premium-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="shutterstock">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #D36559, #EE2B24);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                   <svg style="width: 40px;height: 40px;" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" viewBox="0 0 396.918 396.918" xml:space="preserve"> <path
                                               style="fill:#ffffff;"
                                               d="M0,22.652v351.614c0,12.51,10.141,22.652,22.652,22.652h351.614c12.51,0,22.652-10.141,22.652-22.652V22.652C396.917,10.141,386.776,0,374.266,0H22.652C10.141,0,0,10.141,0,22.652z M180.96,108.222h-62.29c-6.256,0-11.344,5.088-11.344,11.344v59.92H55.353v-59.92c0-34.912,28.405-63.317,63.317-63.317h62.291L180.96,108.222L180.96,108.222z M341.565,277.352c0,34.912-28.405,63.317-63.317,63.317h-62.291v-51.973h62.291c6.256,0,11.344-5.088,11.344-11.344v-59.92h51.973L341.565,277.352L341.565,277.352z"></path> </svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Shutterstock</h5>
                            <p class="text-white text-center mb-4">{{__('Shutterstock-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="motionarray">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #6B2FD9, #834af0);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                    <svg style="background: purple; width: 40px;height: 40px;" version="1.0"
                                         xmlns="http://www.w3.org/2000/svg" width="28.000000pt" height="28.000000pt"
                                         viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet"> <g
                                                transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
                                                fill="#ffffff" stroke="none"> <path
                                                    d="M0 640 l0 -640 640 0 640 0 0 640 0 640 -640 0 -640 0 0 -640z m415 73 c26 -71 51 -132 55 -136 4 -4 29 53 56 127 l49 136 58 0 57 0 0 -201 0 -200 -42 3 -43 3 -5 113 -5 112 -44 -115 -43 -115 -37 0 -37 0 -44 117 -45 117 -5 -114 -5 -115 -42 -3 -43 -3 0 200 0 201 59 0 58 0 48 -127z m530 13 c45 -19 55 -42 55 -129 0 -57 4 -76 15 -81 9 -3 15 -19 15 -41 0 -33 -2 -35 -34 -35 -19 0 -42 7 -50 15 -14 14 -18 14 -45 0 -97 -50 -207 29 -161 116 17 30 64 49 125 49 56 0 65 8 46 39 -13 20 -71 18 -86 -2 -18 -25 -85 -23 -85 1 0 19 29 51 65 70 28 16 99 15 140 -2z"></path> <path
                                                    d="M838 559 c-35 -20 -17 -59 28 -59 19 0 54 36 54 55 0 18 -55 20 -82 4z"></path> </g> </svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Motion Array</h5>
                            <p class="text-white text-center mb-4">{{__('Motion Array-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="epidemicsound">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #1A1A1A, #222222);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                   <svg style="width: 40px;height: 40px;" fill="#fff" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" width="24px" height="24px"><path
                                               d="M 14.275391 2.0019531 C 11.365107 2.045791 8.5075 3.1841406 6.359375 5.3066406 C 4.192375 7.4496406 3 10.296125 3 13.328125 C 3 16.358125 4.192375 19.207609 6.359375 21.349609 L 6.7265625 21.710938 C 6.9135625 21.895938 7.1656875 22 7.4296875 22 L 13.345703 22 C 13.750703 22 14.115531 21.755859 14.269531 21.380859 C 14.423531 21.005859 14.336828 20.574063 14.048828 20.289062 L 10.724609 17.003906 C 9.7306094 16.020906 9.1835938 14.716125 9.1835938 13.328125 C 9.1835937 11.941125 9.7306094 10.635344 10.724609 9.6523438 C 12.571532 7.8287205 15.450849 7.646168 17.509766 9.0898438 L 11.40625 15.298828 C 11.12425 15.585828 11.041266 16.014719 11.197266 16.386719 C 11.352266 16.757719 11.716141 16.998047 12.119141 16.998047 L 19 16.998047 C 19.553 16.998047 20 16.551047 20 15.998047 L 20 9.046875 L 20 4.03125 C 20 3.64625 19.777687 3.2949062 19.429688 3.1289062 C 17.786438 2.3440313 16.021561 1.9756504 14.275391 2.0019531 z"></path></svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Epidemic Sound</h5>
                            <p class="text-white text-center mb-4">{{__('Epidemic Sound-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="service-card h-100" id="flaticon">
                    <div class="card border-0 shadow-hover h-100">
                        <div class="card-body d-flex flex-column align-items-center p-4"
                             style="background: linear-gradient(45deg, #0F4637, #16D298);">
                            <div class="service-icon-wrapper mb-3">
                                <span class="service-icon d-flex align-items-center justify-content-center">
                                  <svg style="width: 40px;height: 40px;" version="1.1" id="Layer_1"
                                       xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                       x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve"> <path
                                              style="fill:#fff;"
                                              d="M13.462 7.626H7.816L6.05 4.606h9.178L17.902 0H2.732a2.73 2.73 0 0 0-2.36 1.354 2.652 2.652 0 0 0 0 2.707l9.673 16.606c.76 1.288 2.443 1.717 3.747.958a2.86 2.86 0 0 0 .974-.958l.313-.545-4.44-7.659 2.823-4.837Z"></path><path
                                              fill="#fff"
                                              d="M24.473 1.354A2.71 2.71 0 0 0 22.112 0h-.66l-7.264 12.463 2.675 4.606 7.61-13.041a2.67 2.67 0 0 0 0-2.674Z"></path></svg>
                                </span>
                            </div>
                            <h5 class="text-white mb-3">Flaticon Premium</h5>
                            <p class="text-white text-center mb-4">{{__('Flaticon Premium-desc')}}</p>
                            <button class="btn btn-light w-100 mt-auto">{{__('List Packages')}}</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="row mt-8" id="products">
        @foreach($products as $product)
            @php
                $nameColor = 'success';
                $category = '';

                // --- DEĞİŞİKLİK BURADA ---
                // strpos yerine stripos kullanarak büyük/küçük harf duyarlılığı kaldırıldı.
                if(stripos($product->name,'Envato')!== false){
                    $nameColor = 'envato-btn';
                    $category = 'Envato';
                }
                else if(stripos($product->name,'Flaticon')!== false){
                    $nameColor = 'flaticon-btn';
                    $category = 'Flaticon';
                }
                else if(stripos($product->name,'Mix')!== false){
                    $nameColor = 'mix-btn';
                    $category = 'Mix';
                }
                else if(stripos($product->name,'Freepik')!== false){
                    $nameColor = 'freepik-btn';
                    $category = 'Freepik';
                }
                else if(stripos($product->name,'Epidemic')!== false){
                    $nameColor = 'epidemicsound-btn';
                    $category = 'Epidemic';
                }
                else if(stripos($product->name,'Shutter')!== false){
                    $nameColor = 'shutterstock-btn';
                    $category = 'Shutter';
                }
                else if(stripos($product->name,'Motion')!== false){
                    $nameColor = 'motionarray-btn';
                    $category = 'Motion';
                }
                // Adobe ile ilgili 'else if' bloğu tamamen kaldırıldı.
            @endphp
            <div class="col-xl-3 mb-5 product-item" data-category="{{$category}}" style="display: none">
                <div class="card border-0 shadow-hover h-100">
                    <div class="card-header {{$nameColor}} text-white py-3">
                        <h5 class="card-title mb-0 text-center">
                            {{auth()->user()->locale=='tr'?$product->name:($product->name_en?:$product->name)}}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            @if($countryCode!='TR')
                                <span class="fs-6 fw-bold text-primary">{{number_format($product->price*1.5,2)}} ₺</span>
                            @else
                                <span class="fs-6 fw-bold text-primary">{{number_format($product->price,2)}} ₺</span>
                            @endif
                        </div>

                        <div class="product-description mb-4 text-center">
                            {!!auth()->user()->locale=='tr'?$product->desc:($product->desc_en?:$product->desc)!!}
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{route('paytrpay',['service_id'=>$product->id])}}"
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>
                                {{__("Pay with Card")}}
                            </a>

                            <a href="{{route('payid19pay',['service_id'=>$product->id])}}"
                               class="btn btn-dark btn-lg">
                                <i class="fab fa-bitcoin me-2"></i>
                                {{__("Pay with Crypto")}}
                                <span class="ms-1">
                                    ( $ @if($countryCode!='TR')
                                        {{round($product->price*1.5/38,1)}}
                                    @else
                                        {{round($product->price/38,1)}}
                                    @endif )
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="paymentdiv"></div>

    <style>
        .envato-btn {
            background: linear-gradient(45deg, #82B440, #92c550);
            color: white;
        }
        .mix-btn {
            background: linear-gradient(45deg, #b71fc6, #92c550);
            color: white;
        }

        .flaticon-btn {
            background: linear-gradient(45deg, #0F4637, #16D298);
            color: white;
        }

        .freepik-btn {
            background: linear-gradient(45deg, #1E88E5, #2470d8);
            color: white;
        }

        .epidemicsound-btn {
            background: linear-gradient(45deg, #1A1A1A, #222222);
            color: white;
        }

        /* .adobestock-btn stili kaldırıldı. */

        .shutterstock-btn {
            background: linear-gradient(45deg, #D36559, #EE2B24);
            color: white;
        }

        .motionarray-btn {
            background: linear-gradient(45deg, #6B2FD9, #834af0);
            color: white;
        }
        .section-header {
            position: relative;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #6B2FD9, #834af0);
            border-radius: 2px;
        }

        .service-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .shadow-hover {
            transition: all 0.3s ease;
        }

        .shadow-hover:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .service-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon-wrapper {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }

        .card-body {
            border-radius: 15px;
        }

        .btn-light {
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.75rem;
            }

            .service-card {
                margin-bottom: 1rem;
            }
        }
    </style>--}}
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Service card click handlers
            const serviceCards = {
                'envatoelements': 'Envato',
                'mix': 'Mix',
                'flaticon': 'Flaticon',
                'epidemicsound': 'Epidemic',
                'freepik': 'Freepik',
                'shutterstock': 'Shutter',
                // 'adobestock' kaydı kaldırıldı.
                'motionarray': 'Motion'
            };

            Object.entries(serviceCards).forEach(([cardId, category]) => {
                document.getElementById(cardId)?.addEventListener('click', () => {
                    // Hide all product items
                    document.querySelectorAll('.product-item').forEach(div => {
                        div.style.display = 'none';
                    });

                    // Show all products of selected category
                    document.querySelectorAll(`.product-item[data-category="${category}"]`).forEach(div => {
                        div.style.display = 'block';
                    });

                    // Smooth scroll to products section
                    document.getElementById('products').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // Payment form handler
            window.getPayFormInit = function (url) {
                fetch(url, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.text())
                    .then(response => {
                        window.location.href = response;
                    })
                    .catch(() => {
                        Swal.fire({
                            title: '{{__("Error")}}',
                            html: '{{__("An unknown error has occurred, please try again later.")}}',
                            icon: 'warning'
                        });
                    });
            };
        });
    </script>

    <style>
        #weepay-checkout-reopen-button {
            display: none !important;
        }

        .bg-purple {
            background: #7239ea !important;
        }

        /* Service card animations */
        .service-card {
            transform-origin: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-card:active {
            transform: scale(0.98);
        }

        /* Loading animation for payment buttons */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            right: 10px;
            margin-top: -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: button-loading-spinner 0.8s linear infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }
    </style>
@endsection