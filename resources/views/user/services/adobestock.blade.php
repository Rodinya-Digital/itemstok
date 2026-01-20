@extends('layouts.FrontV1-master')

@section('title')
    Adobe Stock
@endsection
@section('topbuttons')

    <div class="card mb-6 w-100">
        <div class="user-profile-header-banner">

        </div>
        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">

                <svg class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 64px;height: 64px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 180 180" xml:space="preserve">
  <path class="st0" d="M0 122V27.4c0-1.8.1-3.6.5-5.3s.9-3.5 1.6-5.1 1.5-3.2 2.5-4.8S6.8 9.3 8 8c1.3-1.3 2.7-2.4 4.2-3.4s3.1-1.9 4.8-2.5c1.7-.7 3.4-1.2 5.1-1.6 1.8-.4 3.5-.5 5.3-.5h100.2c1.8 0 3.6.1 5.3.5 1.8.4 3.5.9 5.1 1.6s3.2 1.5 4.8 2.5 2.9 2.2 4.2 3.4c1.3 1.3 2.4 2.7 3.4 4.2s1.9 3.1 2.5 4.8c.7 1.7 1.2 3.4 1.6 5.1.4 1.8.5 3.5.5 5.3V122c0 1.8-.1 3.6-.5 5.3-.4 1.8-.9 3.5-1.6 5.1-.7 1.7-1.5 3.2-2.5 4.8s-2.2 2.9-3.4 4.2c-1.3 1.3-2.7 2.4-4.2 3.4s-3.1 1.9-4.8 2.5c-1.7.7-3.4 1.2-5.1 1.6-1.8.4-3.5.5-5.3.5H27.5c-1.8 0-3.6-.1-5.3-.5-1.8-.4-3.5-.9-5.1-1.6-1.7-.7-3.2-1.5-4.8-2.5s-2.9-2.2-4.2-3.4c-1.3-1.3-2.4-2.7-3.4-4.2s-1.9-3.1-2.5-4.8c-.7-1.7-1.2-3.4-1.6-5.1-.4-1.6-.6-3.4-.6-5.3z"/>
                    <path d="M54.9 109.6c-3.8 0-7.3-.4-10.4-1-3.1-.6-5.7-1.5-7.9-2.5-.6-.3-.8-.9-.8-1.7V92.2c0-.3.1-.4.3-.6.1-.1.4-.1.6.1 2.9 1.8 5.9 3.1 9.1 4 3.2.9 6.3 1.3 9.4 1.3 3.9 0 6.7-.6 8.4-1.8 1.7-1.2 2.5-2.7 2.5-4.5 0-1.2-.3-2.2-.8-3.1-.6-.9-1.5-1.8-2.9-2.7-1.4-.9-3.2-1.8-5.6-2.7L51.7 80c-4.2-1.8-7.4-3.7-9.8-5.7-2.4-2-4-4.2-4.8-6.5-.9-2.3-1.4-4.8-1.4-7.5 0-3.7.9-7.1 2.7-10 1.9-3 4.5-5.4 8.2-7.1 3.6-1.7 8.2-2.6 13.6-2.6 3.2 0 6.3.2 9.2.6 2.8.4 5.1 1.1 6.8 1.9.5.3.7.7.7 1.3V56c0 .1-.1.3-.3.4-.1.1-.4.1-.6-.1-2-1.1-4.5-1.9-7.1-2.6-2.7-.4-5.6-.7-8.5-.7-1.9 0-3.7.1-5 .5-1.4.4-2.5.8-3.3 1.3s-1.5 1.2-1.9 1.9c-.4.8-.6 1.6-.6 2.4 0 1.1.3 2.1.9 2.9.6.9 1.7 1.7 3.1 2.6 1.4.9 3.4 1.9 5.9 3l3.8 1.4c4.5 1.9 8 3.8 10.5 5.9 2.5 2.1 4.3 4.3 5.3 6.8s1.5 5 1.5 7.9c0 4-1.1 7.6-3.2 10.6-2.2 3-5.1 5.4-8.9 7s-8.4 2.4-13.6 2.4zm60.3-11.1v8.4c0 .7-.3 1.2-.8 1.3-1.3.4-2.7.7-4.1 1s-3.1.4-4.9.4c-4.5 0-7.9-1.2-10.5-3.5-2.5-2.3-3.8-6.1-3.8-11.2V69.6H85c-.6 0-.8-.3-.8-.9V58.5c0-.6.3-.8.9-.8h6.1c.1-1.2.1-2.5.3-4 .1-1.5.2-3.1.4-4.6.1-1.5.3-2.8.4-3.8.1-.2.1-.4.3-.6.1-.1.3-.3.5-.4l12.2-1.5c.2-.1.4-.1.5 0 .1.1.2.3.2.6-.1 1.6-.2 3.7-.3 6.4-.1 2.7-.1 5.3-.2 7.9h9.5c.4 0 .6.3.6.8v10.4c0 .4-.1.6-.5.7h-9.7v21.9c0 2.3.4 4 1.2 5 .8 1 2.2 1.5 4.3 1.5.6 0 1.2 0 1.7-.1.6 0 1.1-.1 1.7-.1.2-.1.4-.1.6.1.2.1.3.3.3.6z" fill="#fff"/>
</svg>
            </div>
            <div class="flex-grow-1 mt-3 mt-lg-5">
                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                        <h3 class="mb-2 mt-lg-6">Adobe Stock</h3>
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
                <input type="text" class="form-control rounded-end-0" id="adobestock_url"
                       placeholder="{{__("Please enter the content URL.")}}">
                <button style="width: 300px!important;height: 43px!important;" class="btn btn-success rounded-start-0"
                        id="adobestock_down">{{__("Create Link")}}</button>
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
                $('#adobestock_down').click(() => {
                    swal.fire({
                        title: '{{__("Now loading")}}',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })
                    $.post('<?= route('api.adobestock') ?>', {
                        type: 'file',
                        url: $('#adobestock_url').val()
                    }).done((response) => {
                        console.log(response)
                        if (response.success) {
                            swal.fire({
                                title: '',
                                html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.download + '" target="_blank">{{__("Click For Download")}}</a>',
                                icon: 'success'
                            })
                            window.open(response.download)
                            $('#adobestock_url').val("")
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
