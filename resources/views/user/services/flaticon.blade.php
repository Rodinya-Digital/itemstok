@extends('layouts.SolarTheme')

@section('title')
    Flaticon
@endsection
@section('topbuttons')

    <div class="card mb-6 w-100">
        <div class="user-profile-header-banner">

        </div>
        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">

                <svg class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 64px;height: 64px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" xml:space="preserve">
                    <path style="fill:#16D298;"
                          d="M13.462 7.626H7.816L6.05 4.606h9.178L17.902 0H2.732a2.73 2.73 0 0 0-2.36 1.354 2.652 2.652 0 0 0 0 2.707l9.673 16.606c.76 1.288 2.443 1.717 3.747.958a2.86 2.86 0 0 0 .974-.958l.313-.545-4.44-7.659 2.823-4.837Z"></path>
                    <path fill="#16D298"
                          d="M24.473 1.354A2.71 2.71 0 0 0 22.112 0h-.66l-7.264 12.463 2.675 4.606 7.61-13.041a2.67 2.67 0 0 0 0-2.674Z"></path></svg>

            </div>
            <div class="flex-grow-1 mt-3 mt-lg-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                        <h3 class="mb-2 mt-lg-6">Flaticon Premium</h3>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-success mb-1 waves-effect waves-light">
                        <i class="ti ti-server-bolt ti-xs me-2"></i>{{__('Service Status')}} : {{__('Active')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

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
        <div class="card p-4">

            <div class="d-flex align-items-center">
                <input type="text" class="form-control rounded-end-0" id="flaticon_url"
                       placeholder="{{__("Please enter the content URL.")}}">

                <button class="btn btn-success rounded-start-0" style="width: 150px!important;height: 43px!important;"
                        id="flaticon_btn_next">{{__("Next")}}</button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly mt-4">
                <button class="downloadType btn btn-dark mr-4" disabled value="png16" data-type="png16">PNG X16</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="png24" data-type="png24">PNG X24</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="png64" data-type="png64">PNG X64</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="png128" data-type="png128">PNG X128
                </button>
                <button class="downloadType btn btn-dark pr-4" disabled value="png256" data-type="png256">PNG X256
                </button>
                <button class="downloadType btn btn-dark pr-4" disabled value="png512" data-type="png512">PNG X512
                </button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly mt-4">
                <button class="downloadType btn btn-dark pr-4" disabled value="svg" data-type="svg">SVG</button>
               {{-- <button class="downloadType btn btn-dark pr-4" disabled value="android" data-type="android">ANDROID
                </button>
                <button class="downloadType btn btn-dark pr-4" disabled value="ios" data-type="ios">IOS</button>--}}
                <button class="downloadType btn btn-dark pr-4" disabled value="aep" data-type="aep">AEP</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="lottie" data-type="lottie">JSON</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="gif" data-type="gif">GIF</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="mp4" data-type="mp4">MP4</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="eps" data-type="eps">EPS</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="psd" data-type="psd">PSD</button>
                <button class="downloadType btn btn-dark pr-4" disabled value="apng" data-type="apng">PNG</button>

            </div>


            @section('scripts')
                <script>
                    let videoSelected = false;
                    let nolimit = "{!! __('Your download quota is over! <br> To use the service, you must purchase this service. <br> To purchase, visit the store page.')  !!}"
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#flaticon_url').change(()=>{
                        $('[data-type="png16"]').attr('disabled', true);
                        $('[data-type="png24"]').attr('disabled', true);
                        $('[data-type="png64"]').attr('disabled', true);
                        $('[data-type="png128"]').attr('disabled', true);
                        $('[data-type="png256"]').attr('disabled', true);
                        $('[data-type="png512"]').attr('disabled', true);
                        $('[data-type="svg"]').attr('disabled', true);
                        $('[data-type="android"]').attr('disabled', true);
                        $('[data-type="ios"]').attr('disabled', true);
                        $('[data-type="aep"]').attr('disabled', true);
                        $('[data-type="lottie"]').attr('disabled', true);
                        $('[data-type="gif"]').attr('disabled', true);
                        $('[data-type="mp4"]').attr('disabled', true);
                        $('[data-type="eps"]').attr('disabled', true);
                        $('[data-type="psd"]').attr('disabled', true);
                        $('[data-type="apng"]').attr('disabled', true);
                    })


                    $('#flaticon_btn_next').click(() => {

                        let insertedUrl = $('#flaticon_url').val();
                        if (insertedUrl.includes('/free-animated-icon/')) {
                            $('[data-type="png16"]').attr('disabled', true);
                            $('[data-type="png24"]').attr('disabled', true);
                            $('[data-type="png64"]').attr('disabled', true);
                            $('[data-type="png128"]').attr('disabled', true);
                            $('[data-type="png256"]').attr('disabled', true);
                            $('[data-type="png512"]').attr('disabled', true);
                            $('[data-type="svg"]').attr('disabled', false);
                            $('[data-type="android"]').attr('disabled', true);
                            $('[data-type="ios"]').attr('disabled', true);
                            $('[data-type="aep"]').attr('disabled', false);
                            $('[data-type="lottie"]').attr('disabled', false);
                            $('[data-type="gif"]').attr('disabled', false);
                            $('[data-type="mp4"]').attr('disabled', false);
                            $('[data-type="eps"]').attr('disabled', false);
                            $('[data-type="psd"]').attr('disabled', false);
                            $('[data-type="apng"]').attr('disabled', false);
                        } else if (insertedUrl.includes('/free-icon-font/')) {
                            $('[data-type="png16"]').attr('disabled', false);
                            $('[data-type="png24"]').attr('disabled', false);
                            $('[data-type="png64"]').attr('disabled', false);
                            $('[data-type="png128"]').attr('disabled', false);
                            $('[data-type="png256"]').attr('disabled', false);
                            $('[data-type="png512"]').attr('disabled', false);
                            $('[data-type="svg"]').attr('disabled', false);
                            $('[data-type="android"]').attr('disabled', false);
                            $('[data-type="ios"]').attr('disabled', false);
                            $('[data-type="aep"]').attr('disabled', true);
                            $('[data-type="lottie"]').attr('disabled', true);
                            $('[data-type="gif"]').attr('disabled', true);
                            $('[data-type="mp4"]').attr('disabled', true);
                            $('[data-type="eps"]').attr('disabled', true);
                            $('[data-type="psd"]').attr('disabled', true);
                            $('[data-type="apng"]').attr('disabled', true);
                        } else if (insertedUrl.includes('/free-sticker/')) {
                            $('[data-type="png16"]').attr('disabled', false);
                            $('[data-type="png24"]').attr('disabled', false);
                            $('[data-type="png64"]').attr('disabled', false);
                            $('[data-type="png128"]').attr('disabled', false);
                            $('[data-type="png256"]').attr('disabled', false);
                            $('[data-type="png512"]').attr('disabled', false);
                            $('[data-type="svg"]').attr('disabled', false);
                            $('[data-type="android"]').attr('disabled', true);
                            $('[data-type="ios"]').attr('disabled', true);
                            $('[data-type="aep"]').attr('disabled', true);
                            $('[data-type="lottie"]').attr('disabled', true);
                            $('[data-type="gif"]').attr('disabled', true);
                            $('[data-type="mp4"]').attr('disabled', true);
                            $('[data-type="eps"]').attr('disabled', true);
                            $('[data-type="psd"]').attr('disabled', true);
                            $('[data-type="apng"]').attr('disabled', true);
                        } else if (insertedUrl.includes('/free-icon/')) {
                            $('[data-type="png16"]').attr('disabled', false);
                            $('[data-type="png24"]').attr('disabled', false);
                            $('[data-type="png64"]').attr('disabled', false);
                            $('[data-type="png128"]').attr('disabled', false);
                            $('[data-type="png256"]').attr('disabled', false);
                            $('[data-type="png512"]').attr('disabled', false);
                            $('[data-type="svg"]').attr('disabled', false);
                            $('[data-type="android"]').attr('disabled', true);
                            $('[data-type="ios"]').attr('disabled', true);
                            $('[data-type="aep"]').attr('disabled', true);
                            $('[data-type="lottie"]').attr('disabled', true);
                            $('[data-type="gif"]').attr('disabled', true);
                            $('[data-type="mp4"]').attr('disabled', true);
                            $('[data-type="eps"]').attr('disabled', true);
                            $('[data-type="psd"]').attr('disabled', true);
                            $('[data-type="apng"]').attr('disabled', true);
                        } else {
                            $('[data-type="png16"]').attr('disabled', true);
                            $('[data-type="png24"]').attr('disabled', true);
                            $('[data-type="png64"]').attr('disabled', true);
                            $('[data-type="png128"]').attr('disabled', true);
                            $('[data-type="png256"]').attr('disabled', true);
                            $('[data-type="png512"]').attr('disabled', true);
                            $('[data-type="svg"]').attr('disabled', true);
                            $('[data-type="android"]').attr('disabled', true);
                            $('[data-type="ios"]').attr('disabled', true);
                            $('[data-type="aep"]').attr('disabled', true);
                            $('[data-type="lottie"]').attr('disabled', true);
                            $('[data-type="gif"]').attr('disabled', true);
                            $('[data-type="mp4"]').attr('disabled', true);
                            $('[data-type="eps"]').attr('disabled', true);
                            $('[data-type="psd"]').attr('disabled', true);
                            $('[data-type="apng"]').attr('disabled', true);
                            swal.fire({
                                title: '{{__("Error")}}',
                                html: '{{__("An unknown error has occurred, please try again later.")}}<br><br><b>Not Supported!</b>',
                                icon: 'warning'
                            })
                            return false;
                        }
                    });

                    $('button.downloadType').click(function () {
                        let clickedButton = $(this).data().type;

                        swal.fire({
                            title: '{{__("Now loading")}}',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })
                        $.post('<?= route('api.flaticon') ?>', {
                            type: 'file',
                            dwType: clickedButton,
                            url: $('#flaticon_url').val(),
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
                                $('#flaticon_url').val("")
                                $('[data-type="png16"]').attr('disabled', true);
                                $('[data-type="png24"]').attr('disabled', true);
                                $('[data-type="png64"]').attr('disabled', true);
                                $('[data-type="png128"]').attr('disabled', true);
                                $('[data-type="png256"]').attr('disabled', true);
                                $('[data-type="png512"]').attr('disabled', true);
                                $('[data-type="svg"]').attr('disabled', true);
                                $('[data-type="android"]').attr('disabled', true);
                                $('[data-type="ios"]').attr('disabled', true);
                                $('[data-type="aep"]').attr('disabled', true);
                                $('[data-type="lottie"]').attr('disabled', true);
                                $('[data-type="gif"]').attr('disabled', true);
                                $('[data-type="mp4"]').attr('disabled', true);
                                $('[data-type="eps"]').attr('disabled', true);
                                $('[data-type="psd"]').attr('disabled', true);
                                $('[data-type="apng"]').attr('disabled', true);
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
                    });
                </script>
        </div>
        @endsection
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
                                    <a href="{{route('panel.shop')}}" class="btn btn-outline-primary widget-info-action">{{__('Buy Now')}}</a>
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
