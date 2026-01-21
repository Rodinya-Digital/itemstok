@extends('layouts.SolarTheme')

@section('title')
    Freepik Premium
@endsection

@section('topbuttons')
    <!-- Service Header Banner -->
    <div class="service-header-banner w-100 mb-4" style="background: linear-gradient(135deg, #3075FF 0%, #2563eb 100%);" data-testid="freepik-header">
        <div class="d-flex align-items-center gap-4">
            <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-image" style="font-size: 1.8rem; color: white;"></i>
            </div>
            <div class="text-white">
                <h2 style="font-family: 'Outfit', sans-serif; font-weight: 700; margin: 0;">Freepik Premium</h2>
                <p style="opacity: 0.9; margin: 0; font-size: 0.9rem;">{{__("Download premium vectors, photos, and PSD files")}}</p>
            </div>
        </div>
    </div>
@endsection

@section('content')

    @if($data)
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card h-100" data-testid="daily-downloads-stat" style="border-left: 4px solid #3075FF;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(48,117,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-download" style="color: #3075FF; font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="color: #3075FF;">{{$downs}}</div>
                    <div class="stat-label">{{__("Remaining Daily Download")}}</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card h-100" data-testid="expiry-stat" style="border-left: 4px solid var(--success);">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(16,185,129,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-check" style="color: var(--success); font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="font-size: 1.3rem; color: var(--success);">
                        {{\Carbon\Carbon::create($data->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                    </div>
                    <div class="stat-label">{{__("Service End Date")}}</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card h-100" data-testid="quota-stat" style="border-left: 4px solid var(--warning);">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(245,158,11,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-pie" style="color: var(--warning); font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="color: var(--warning);">{{$maxp->total}}/{{$maxp->max}}</div>
                    <div class="stat-label">{{__("Max Download Quota (Preiod)")}}</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card h-100" data-testid="total-downloads-stat" style="border-left: 4px solid var(--info);">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(59,130,246,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-cloud-download-alt" style="color: var(--info); font-size: 1.2rem;"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="color: var(--info);">{{$allDowns}}</div>
                    <div class="stat-label">{{__("Total Downloads")}}</div>
                </div>
            </div>
        </div>

        <!-- Download Input Area -->
        <div class="col-12">
            <div class="download-input-wrapper" data-testid="download-input-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h5 style="font-family: 'Outfit', sans-serif; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-link me-2" style="color: #3075FF;"></i>
                            {{__("Download Content")}}
                        </h5>
                        <p style="color: var(--text-secondary); margin-bottom: 16px; font-size: 0.9rem;">
                            {{__("Paste the Freepik URL below to download the content")}}
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>{{__("Service Active")}}
                        </span>
                    </div>
                </div>

                <div class="input-group" style="border: 1px solid var(--border-default); border-radius: var(--radius-md); overflow: hidden;">
                    <span class="input-group-text" style="background: var(--bg-input); border: none; color: var(--text-muted);">
                        <i class="fas fa-globe"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="freepik_url" 
                           placeholder="https://www.freepik.com/premium-vector/..." 
                           style="border: none !important; box-shadow: none !important;"
                           data-testid="freepik-url-input">
                    <button class="btn btn-primary" id="freepik_down" style="border-radius: 0 var(--radius-md) var(--radius-md) 0 !important; padding: 12px 32px !important;" data-testid="freepik-download-btn">
                        <i class="fas fa-download me-2"></i>{{__("Download")}}
                    </button>
                </div>

                <!-- Supported Content Types -->
                <div class="mt-4 pt-4" style="border-top: 1px solid var(--border-default);">
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 12px;">
                        <i class="fas fa-info-circle me-1"></i>{{__("Supported content types")}}:
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge" style="background: rgba(48,117,255,0.2); color: #3075FF;">
                            <i class="fas fa-vector-square me-1"></i>Vectors
                        </span>
                        <span class="badge" style="background: rgba(16,185,129,0.2); color: var(--success);">
                            <i class="fas fa-image me-1"></i>Photos
                        </span>
                        <span class="badge" style="background: rgba(245,158,11,0.2); color: var(--warning);">
                            <i class="fas fa-layer-group me-1"></i>PSD Files
                        </span>
                        <span class="badge" style="background: rgba(139,92,246,0.2); color: #8b5cf6;">
                            <i class="fas fa-video me-1"></i>Videos
                        </span>
                        <span class="badge" style="background: rgba(236,72,153,0.2); color: #ec4899;">
                            <i class="fas fa-robot me-1"></i>AI Images
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @section('scripts')
            <script>
                let videoSelected = false;
                let xUrl = false;
                let nolimit = "{!! __('Your download quota is over! <br> To use the service, you must purchase this service. <br> To purchase, visit the store page.')  !!}"
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $('#freepik_down').click(() => {
                    const url = $('#freepik_url').val();
                    
                    if (!url) {
                        Swal.fire({
                            title: '{{__("Warning")}}',
                            html: '{{__("Please enter a valid Freepik URL")}}',
                            icon: 'warning',
                            confirmButtonText: '{{__("OK")}}'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: '{{__("Downloading")}}...',
                        html: '<div class="d-flex flex-column align-items-center"><div class="spinner-border text-primary mb-3" role="status"></div><p style="color: var(--text-secondary);">{{__("Please wait while we process your request")}}</p></div>',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    $.post('<?= route('api.freepik') ?>', {
                        type: 'file',
                        url: url,
                        xurl: xUrl,
                        videoselected: videoSelected
                    }).done((response) => {
                        if (response.types) {
                            Swal.fire({
                                title: '{{__("Select Quality")}}',
                                html: videoTypeButton(response.types),
                                icon: 'question',
                                showConfirmButton: false,
                                showCloseButton: true
                            });
                        } else {
                            if (response.success) {
                                Swal.fire({
                                    title: '{{__("Success!")}}',
                                    html: '<a class="btn btn-success btn-lg" id="downloadLinkButton" href="' + response.url + '" target="_blank"><i class="fas fa-download me-2"></i>{{__("Click to Download")}}</a>',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    showCloseButton: true
                                });
                                window.open(response.url);
                                $('#freepik_url').val("");
                                videoSelected = false;
                            } else {
                                Swal.fire({
                                    title: '{{__("Error")}}',
                                    html: (response.error == 'nolimit' ? nolimit : (response.error == 'nosupport' ? '{{__("This URL is not supported")}}' : response.error)),
                                    icon: 'error',
                                    confirmButtonText: '{{__("OK")}}'
                                });
                            }
                        }
                    }).fail(() => {
                        Swal.fire({
                            title: '{{__("Error")}}',
                            html: '{{__("An unknown error has occurred, please try again later.")}}',
                            icon: 'error',
                            confirmButtonText: '{{__("OK")}}'
                        });
                    });
                });

                function videoTypeButton(datas) {
                    let datax = '<div class="d-flex flex-column gap-2">';
                    datas.forEach((v, i) => {
                        if (v.active) {
                            datax += `<button id="videoType" data-id="${v.id}" class="btn btn-light text-start" style="padding: 16px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong style="color: var(--text-primary);">${v.quality}</strong>
                                        <span class="badge bg-primary ms-2">${v.width} x ${v.height}</span>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.8rem;">
                                        ${v.size} MB • ${v.codec}
                                    </div>
                                </div>
                            </button>`;
                        }
                    });
                    datax += '</div>';
                    return datax;
                }

                $(document).on('click', '#videoType', (clickedBtn) => {
                    let lastLink = $('#freepik_url').val();
                    $('#freepik_url').val('https://www.freepik.com/premium-video/video_' + $(clickedBtn.currentTarget).data().id);
                    xUrl = lastLink;
                    videoSelected = 'secildi';
                    $('#freepik_down').click();
                    $('#freepik_url').val(lastLink);
                });

                // Enter key support
                $('#freepik_url').keypress(function(e) {
                    if (e.which == 13) {
                        $('#freepik_down').click();
                    }
                });
            </script>
        @endsection

    @else
        <!-- No Active Service -->
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div style="width: 100px; height: 100px; background: rgba(48,117,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-lock" style="font-size: 2.5rem; color: #3075FF;"></i>
                    </div>
                    <h4 style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-primary);">
                        {{__("Service Not Active")}}
                    </h4>
                    <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 24px;">
                        {!!__("To use the service you need to purchase this service.<br> Visit the store page to purchase.")!!}
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('panel.shop')}}" class="btn btn-primary" data-testid="buy-now-btn">
                            <i class="fas fa-shopping-cart me-2"></i>{{__("Buy Now")}}
                        </a>
                        <button class="btn btn-light" onclick="$('#usingKeyModal').modal('show');" data-testid="use-key-btn">
                            <i class="fas fa-key me-2"></i>{{__("Use Key")}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
