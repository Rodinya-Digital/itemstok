@extends('layouts.SolarTheme')

@section('title')
    Epidemic Sound
@endsection
@section('topbuttons')

    <div class="card p-4 mb-8 w-100" style="
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
">
        <div>
            <svg class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" style="width: 64px;height: 64px;" fill="#bdc3c7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30px" height="30px"><path d="M 14.275391 2.0019531 C 11.365107 2.045791 8.5075 3.1841406 6.359375 5.3066406 C 4.192375 7.4496406 3 10.296125 3 13.328125 C 3 16.358125 4.192375 19.207609 6.359375 21.349609 L 6.7265625 21.710938 C 6.9135625 21.895938 7.1656875 22 7.4296875 22 L 13.345703 22 C 13.750703 22 14.115531 21.755859 14.269531 21.380859 C 14.423531 21.005859 14.336828 20.574063 14.048828 20.289062 L 10.724609 17.003906 C 9.7306094 16.020906 9.1835938 14.716125 9.1835938 13.328125 C 9.1835937 11.941125 9.7306094 10.635344 10.724609 9.6523438 C 12.571532 7.8287205 15.450849 7.646168 17.509766 9.0898438 L 11.40625 15.298828 C 11.12425 15.585828 11.041266 16.014719 11.197266 16.386719 C 11.352266 16.757719 11.716141 16.998047 12.119141 16.998047 L 19 16.998047 C 19.553 16.998047 20 16.551047 20 15.998047 L 20 9.046875 L 20 4.03125 C 20 3.64625 19.777687 3.2949062 19.429688 3.1289062 C 17.786438 2.3440313 16.021561 1.9756504 14.275391 2.0019531 z"></path></svg>


        </div>

        <div>
            <h3 class="p-0 m-0">Epidemic Sound</h3>
        </div>

        <div>
            <a href="javascript:void(0)" class="btn btn-success mb-1 waves-effect waves-light">
                <i class="ti ti-server-bolt ti-xs me-2"></i>{{__('Service Status')}} : {{__('Active')}}
            </a>
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
            <div class="alert alert-success" role="alert" bis_skin_checked="1">
                <h4 class="alert-heading">Göz Atma Hesapları (Sadece Epidemic Sound'da şarkı aramak için geçerlidir, indirme yapmak için değil. İndirmeler buradan yapılır)</h4>
                <p>⚡ [angelord2014@gmail.com - pmmgtmam24] ⚡ [anupamajayanath98@gmail.com - Anupama1234] ⚡ [apuinatvs06@gmail.com - apuinatvokeoye]</p>
            </div>

            <div class="d-flex align-items-center">
                <input type="text" class="form-control rounded-end-0" id="epidemicsound_url"
                       placeholder="{{__("Please enter the content URL.")}}">

                <button class="btn btn-success rounded-start-0" style="width: 150px!important;height: 43px!important;"
                        id="epidemicsound_btn_next">{{__("Next")}}</button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly">
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark mr-4" disabled value="Full mix#MP3" data-type="Full mix">Full mix <span class="badge bg-label-success">MP3</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="All stems (.zip)#MP3" data-type="All stems (.zip)">All stems (.zip) <span class="badge bg-label-success">MP3</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Melody#MP3" data-type="Melody">Melody <span class="badge bg-label-success">MP3</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Instruments#MP3" data-type="Instruments">Instruments <span class="badge bg-label-success">MP3</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Bass#MP3" data-type="Bass">Bass <span class="badge bg-label-success">MP3</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Drums#MP3" data-type="Drums">Drums <span class="badge bg-label-success">MP3</span></button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly">
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark mr-4" disabled value="Full mix#WAV" data-type="Full mix">Full mix <span class="badge bg-label-primary">WAV</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="All stems (.zip)#WAV" data-type="All stems (.zip)">All stems (.zip) <span class="badge bg-label-primary">WAV</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Melody#WAV" data-type="Melody">Melody <span class="badge bg-label-primary">WAV</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Instruments#WAV" data-type="Instruments">Instruments <span class="badge bg-label-primary">WAV</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Bass#WAV" data-type="Bass">Bass <span class="badge bg-label-primary">WAV</span></button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="Drums#WAV" data-type="Drums">Drums <span class="badge bg-label-primary">WAV</span></button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly">
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="WAV" data-format="WAV">WAV</button>
                <button style="display: none; margin-top: 10px" class="downloadType btn btn-dark pr-4" disabled value="MP3" data-format="MP3">MP3</button>
            </div>


            @section('scripts')
                <script>
                    function clearLangPart(url) {
                        // URL'yi parçalarına ayırıyoruz
                        const urlParts = new URL(url);
                        const pathSegments = urlParts.pathname.split('/').filter(Boolean); // Boş değerleri filtreliyoruz

                        // Eğer ilk parametre 'track' ise işlem yapmayacağız
                        if (pathSegments[0] === 'track') {
                            return url; // URL zaten doğru, hiçbir işlem yapmıyoruz
                        }
                        if (pathSegments[0] === 'sound-effects') {
                            return url; // URL zaten doğru, hiçbir işlem yapmıyoruz
                        }

                        // Eğer ilk parametre 'track' değilse, ilk segmenti kaldırıyoruz
                        return urlParts.origin + '/' + pathSegments.slice(1).join('/') + '/';
                    }

                    function updateButtonVisibility() {
                        $('button.downloadType').each(function() {
                            if ($(this).attr('disabled')) {
                                $(this).css('display', 'none'); // disabled butonları gizle
                            } else {
                                $(this).css('display', 'inline-block'); // etkin olan butonları göster
                            }
                        });
                    }

                    let videoSelected = false;
                    let nolimit = "{!! __('Your download quota is over! <br> To use the service, you must purchase this service. <br> To purchase, visit the store page.')  !!}"
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    updateButtonVisibility()
                    $('#epidemicsound_url').change(()=>{
                        $('[data-type="Full mix"]').attr('disabled', true);
                        $('[data-type="All stems (.zip)"]').attr('disabled', true);
                        $('[data-type="Melody"]').attr('disabled', true);
                        $('[data-type="Instruments"]').attr('disabled', true);
                        $('[data-type="Bass"]').attr('disabled', true);
                        $('[data-type="Drums"]').attr('disabled', true);
                        $('[data-format="MP3"]').attr('disabled', true);
                        $('[data-format="WAV"]').attr('disabled', true);
                        updateButtonVisibility()
                    })


                    $('#epidemicsound_btn_next').click(() => {

                        let insertedUrl = $('#epidemicsound_url').val();
                        insertedUrl = clearLangPart(insertedUrl);
                        console.log(insertedUrl)
                        if (insertedUrl.includes('epidemicsound.com/sound-effects/')) {
                            $('[data-type="Full mix"]').attr('disabled', true);
                            $('[data-type="All stems (.zip)"]').attr('disabled', true);
                            $('[data-type="Melody"]').attr('disabled', true);
                            $('[data-type="Instruments"]').attr('disabled', true);
                            $('[data-type="Bass"]').attr('disabled', true);
                            $('[data-type="Drums"]').attr('disabled', true);
                            $('[data-format="MP3"]').attr('disabled', false);
                            $('[data-format="WAV"]').attr('disabled', false);
                        } else if (insertedUrl.includes('epidemicsound.com/track/')) {
                            $('[data-type="Full mix"]').attr('disabled', false);
                            $('[data-type="All stems (.zip)"]').attr('disabled', false);
                            $('[data-type="Melody"]').attr('disabled', false);
                            $('[data-type="Instruments"]').attr('disabled', false);
                            $('[data-type="Bass"]').attr('disabled', false);
                            $('[data-type="Drums"]').attr('disabled', false);
                            $('[data-format="MP3"]').attr('disabled', true);
                            $('[data-format="WAV"]').attr('disabled', true);
                        } else {
                            $('[data-type="Full mix"]').attr('disabled', true);
                            $('[data-type="All stems (.zip)"]').attr('disabled', true);
                            $('[data-type="Melody"]').attr('disabled', true);
                            $('[data-type="Instruments"]').attr('disabled', true);
                            $('[data-type="Bass"]').attr('disabled', true);
                            $('[data-type="Drums"]').attr('disabled', true);
                            $('[data-format="MP3"]').attr('disabled', true);
                            $('[data-format="WAV"]').attr('disabled', true);
                            swal.fire({
                                title: '{{__("Error")}}',
                                html: '{{__("An unknown error has occurred, please try again later.")}}<br><br><b>Not Supported!</b>',
                                icon: 'warning'
                            })
                            return false;
                        }
                        updateButtonVisibility()
                    });

                    $('button.downloadType').click(function () {
                        let clickedButton = $(this).val();

                        swal.fire({
                            title: '{{__("Now loading")}}',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })
                        $.post('<?= route('api.epidemicsound') ?>', {
                            type: 'file',
                            dwType: clickedButton,
                            url: clearLangPart($('#epidemicsound_url').val()),
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
                                $('#epidemicsound_url').val("")
                                $('[data-type="Full mix"]').attr('disabled', true);
                                $('[data-type="All stems (.zip)"]').attr('disabled', true);
                                $('[data-type="Melody"]').attr('disabled', true);
                                $('[data-type="Instruments"]').attr('disabled', true);
                                $('[data-type="Bass"]').attr('disabled', true);
                                $('[data-type="Drums"]').attr('disabled', true);
                                $('[data-format="MP3"]').attr('disabled', true);
                                $('[data-format="WAV"]').attr('disabled', true);

                                updateButtonVisibility()
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
