@extends('layouts.SolarTheme')

@section('title')
    ShutterStock
@endsection
@section('topbuttons')


    <div class="card mb-6 w-100">
        <div class="user-profile-header-banner">

        </div>
        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">

                <svg class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 64px;height: 64px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 396.918 396.918" xml:space="preserve">
<path style="fill:#FF1A03;" d="M0,22.652v351.614c0,12.51,10.141,22.652,22.652,22.652h351.614c12.51,0,22.652-10.141,22.652-22.652
    V22.652C396.917,10.141,386.776,0,374.266,0H22.652C10.141,0,0,10.141,0,22.652z M180.96,108.222h-62.29
    c-6.256,0-11.344,5.088-11.344,11.344v59.92H55.353v-59.92c0-34.912,28.405-63.317,63.317-63.317h62.291L180.96,108.222
    L180.96,108.222z M341.565,277.352c0,34.912-28.405,63.317-63.317,63.317h-62.291v-51.973h62.291
    c6.256,0,11.344-5.088,11.344-11.344v-59.92h51.973L341.565,277.352L341.565,277.352z"></path>
</svg>

            </div>
            <div class="flex-grow-1 mt-3 mt-lg-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                        <h3 class="mb-2 mt-lg-6">ShutterStock</h3>
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
                <input type="text" class="form-control rounded-end-0" id="shutterstock_url"
                       placeholder="{{__("Please enter the content URL.")}}">
                <button style="width: 300px!important;height: 43px!important;" class="btn btn-success rounded-start-0"
                        id="shutterstock_down">{{__("Create Link")}}</button>
            </div>
        </div>
        @section('scripts')
            <script>
                let nolimit = "{!! __('Your download quota is over! <br> To use the service, you must purchase this service. <br> To purchase, visit the store page.') !!}"
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#shutterstock_down').click(() => {
                    swal.fire({
                        title: '{{__("Now loading")}}',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })
                    $.post('<?= route('api.shutterstock') ?>', {
                        type: 'file',
                        url: $('#shutterstock_url').val()
                    }).done((response) => {
                        console.log(response)
                        if (response.success) {
                            swal.fire({
                                title: '',
                                html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.download + '" target="_blank">{{__("Click For Download")}}</a>',
                                icon: 'success'
                            })
                            window.open(response.download)
                            $('#shutterstock_url').val("")
                        } else {
                            swal.fire({
                                title: '{{__("Error")}}',
                                html: '{{__("An unknown error has occurred, please try again later.")}}<br><br>' + (response.message == 'nolimit' ? nolimit : response.message),
                                icon: 'warning'
                            })
                        }

                    }).fail((jqXHR) => {
                        if (jqXHR.status === 401)
                            location.reload()
                        swal.fire({
                            title: '{{__("Error")}}',
                            html: '{{__("An unknown error has occurred, please try again later.")}}',
                            icon: 'warning'
                        })
                    })
                })
            </script>
        @endsection
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
