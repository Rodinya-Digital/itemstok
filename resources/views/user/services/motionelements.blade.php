@extends('layouts.admin-master')

@section('title')
    Motion Elements
@endsection
@section('topbuttons')
    <span class="btn btn-light-success">{{__("Service Status")}}: {{__("Active")}}</span>
@endsection
@section('content')

    @if($data && $downs)
        <div class="row g-5 g-xl-8">
            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-light svg-icon-3x ms-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z"
      fill="currentColor"></path>
<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z"
      fill="currentColor"></path>
</svg>
</span>
                        <!--end::Svg Icon-->

                        <div class="text-white fw-bold fs-2 mb-2 mt-5">
                            {{$downs}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Remaining Daily Download")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>

            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-light svg-icon-3x ms-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z"
      fill="currentColor"></path>
<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z"
      fill="currentColor"></path>
</svg>
</span>
                        <!--end::Svg Icon-->

                        <div class="text-white fw-bold fs-2 mb-2 mt-5">
                            {{\Carbon\Carbon::create($data->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Service End Date")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>

            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-light svg-icon-3x ms-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z"
      fill="currentColor"></path>
<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z"
      fill="currentColor"></path>
</svg>
</span>
                        <!--end::Svg Icon-->

                        <div class="text-white fw-bold fs-2 mb-2 mt-5">
                            {{$maxp->total}}/{{$maxp->max}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Max Download Quota (Preiod)")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>

            <div class="col-xl-3">

                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon-->
                        <span class="svg-icon svg-icon-light svg-icon-3x ms-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z"
      fill="currentColor"></path>
<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z"
      fill="currentColor"></path>
</svg>
</span>
                        <!--end::Svg Icon-->

                        <div class="text-white fw-bold fs-2 mb-2 mt-5">
                            {{$allDowns}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Total Downloads")}}
                        </div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>
        </div>
        <div class="card p-4">
            <div class="alert alert-danger">
                {!! __("<b>ATTENTION </b> Download links are valid for 1 minute, clicking the link late will not work in case of") !!}
            </div>
            <div class="alert alert-info">
                {!! __("<b>NOTICE </b> After downloading your content from here, you can make licensed downloads through the download history on the 'Dashboard' tab.") !!}
            </div>
            <span class="alert alert-info">
                <svg data-v-06c2f4f4="" aria-hidden="true" focusable="false" data-prefix="fas"
                     data-icon="me-subscription" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 92 122"
                     class="text-info svg-inline--fa fa-me-subscription fa-fw fa-sm">
                    <path data-v-06c2f4f4="" fill="currentColor"
                          d="M57.25 53.5H83.5C86.5469 53.5 89.3594 55.6094 90.2969 58.4219C91.4688 61.4687 90.7656 64.75 88.4219 66.8594L28.4219 119.359C25.6094 121.469 21.8594 121.703 19.0469 119.594C16.2344 117.719 15.0625 113.969 16.4688 110.688L34.5156 68.5H8.26563C5.21875 68.5 2.40625 66.625 1.46875 63.8125C0.296875 60.7656 1 57.4844 3.34375 55.375L63.3438 2.875C66.1562 0.765625 69.9062 0.53125 72.7188 2.64062C75.5312 4.51562 76.7031 8.26562 75.2969 11.5469L57.25 53.5Z"
                          class=""></path>
                    </svg>
                 <b>{{__('Content with an icon is supported.')}}</b>
                     </span>


            <div class="d-flex align-items-center">
                <input type="text" class="form-control rounded-end-0" id="motionelements_url"
                       placeholder="{{__("Please enter the content URL.")}}">
                <button class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success rounded-start-0 w-200px"
                        id="motionelements_down">{{__("Create Link")}}</button>
            </div>
        </div>
        @section('scripts')
            <script>
                let nolimit = "{!! __('To use the service, you must purchase this service.<br> To purchase, visit the store page.')  !!}"
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#motionelements_down').click(() => {
                    swal.fire({
                        title: '{{__("Now loading")}}',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })
                    $.post('<?= route('api.motionelements') ?>', {
                        type: 'file',
                        url: $('#motionelements_url').val()
                    }).done((response) => {
                        if (response.success) {
                            swal.fire({
                                title: '',
                                html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.url + '" target="_blank">{{__("Click For Download")}}</a>',
                                icon: 'success'
                            })
                            window.open(response.url)
                            $('#motionelements_url').val("")
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
