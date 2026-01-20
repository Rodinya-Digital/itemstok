@extends('layouts.SolarTheme')

@section('title')
    Motion Array
@endsection
@section('topbuttons')

    <div class="card p-4 mb-8 w-100" style="
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
">
        <div>
            <svg class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 64px;height: 64px;" viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet">

                <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" fill="#8e44ad" stroke="none">
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

        </div>

        <div>
            <h3 class="p-0 m-0">Motion Array</h3>
        </div>

        <div>
            <a href="javascript:void(0)" class="btn btn-success mb-1 waves-effect waves-light">
                <i class="ti ti-server-bolt ti-xs me-2"></i>{{__('Service Status')}} : {{__('Active')}}
            </a>
        </div>
    </div>
@endsection
@section('content')

    @if($data && $downs)
        {{--<div class="alert alert-success">
            @if(auth()->user()->locale=='tr')
                Lisanslı İndirmeler Artık Destekleniyor.(Lisans dosyanızı indirmek için Lisans İndirme Menüsünü ziyaret edin.)
            @else
                Licensed Downloads are Now Supported. (Visit License Download Menu to download your license file.)
            @endif
        </div>--}}
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

           {{-- <div class="alert alert-danger p-3">
                <b>{{__('The link you entered should have "/" at the end Example: https://motionarray.com/royalty-free-music/noir-city-1342169/')}}</b>
            </div>--}}
        <div class="d-flex align-items-center">
            <input type="text" class="form-control rounded-end-0 border border-success" id="motionarray_url"
                   placeholder="{{__("Please enter the content URL.")}}">
            <button class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success rounded-start-0" style="width: 250px"
                    id="motionarray_down">{{__("Create Link")}}</button>
        </div>
        @section('scripts')
            <script>
                let nolimit = "{!! __('To use the service, you must purchase this service.<br> To purchase, visit the store page.')  !!}"
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#motionarray_down').click(() => {
                    swal.fire({
                        title: '{{__("Now loading")}}',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })
                    $.post('<?= route('api.motionarray') ?>', {
                        type: 'file',
                        url: $('#motionarray_url').val()
                    }).done((response) => {
                        if (response.success) {
                            swal.fire({
                                title: '',
                                html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.url + '" target="_blank">{{__("Click For Download")}}</a>',
                                icon: 'success'
                            })
                            window.open(response.url)
                            $('#motionarray_url').val("")
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
            </script>
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
