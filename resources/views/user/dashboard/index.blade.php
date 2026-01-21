@extends('layouts.SolarTheme')

@section('title')
    {{__("Dashboard")}}
@endsection

@section('content')

    <!-- Welcome Header -->
    <div class="col-12 mb-4">
        <div class="ios-blur p-4 d-flex align-items-center gap-4" data-testid="welcome-header">
            <div class="position-relative mr-4">
                <div style="border: 3px solid var(--brand-primary); border-radius: 50%; padding: 3px;">
                    <img src="{{asset('SolarTheme/images/profile/user-'.\Auth::user()->avatar.'.jpg')}}" class="rounded-circle" alt="user" width="60" height="60">
                </div>
                <span style="position: absolute; bottom: 5px; right: 0; width: 14px; height: 14px; background: var(--success); border-radius: 50%; border: 2px solid var(--bg-card);"></span>
            </div>
            <div>
                <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">
                    {{__("Welcome back")}}, {{\Auth::user()->name}}! 
                </h3>
                <p class="mb-0" style="color: var(--text-secondary);">{{__("Here's your download overview")}}</p>
            </div>
            <div class="ms-auto d-none d-md-flex align-items-center gap-2">
                @php
                    $langs = [
                        'tr' => ['flag' => 'tr', 'name' => 'TR'],
                        'en' => ['flag' => 'us', 'name' => 'EN'],
                        'es' => ['flag' => 'es', 'name' => 'ES'],
                        'fr' => ['flag' => 'fr', 'name' => 'FR'],
                        'bd' => ['flag' => 'bd', 'name' => 'BD']
                    ];
                @endphp
                @foreach($langs as $code => $lang)
                    <a href="?setLang={{$code}}" class="btn btn-sm {{ Auth::user()->locale == $code ? 'btn-primary' : 'btn-light' }}" data-testid="lang-{{$code}}-btn">
                        <span class="fi fi-{{$lang['flag']}} me-1"></span>{{$lang['name']}}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        @php
            $totalActiveServices = 0;
            $totalDownloadsToday = 0;
            $servicesData = [];
            $servicesList = [
                "Freepik Premium" => ["slug" => "freepik", "color" => "#3075FF", "icon" => "fa-image"],
                "Envato Elements" => ["slug" => "envatoelements", "color" => "#81B441", "icon" => "fa-leaf"],
                "Motion Array" => ["slug" => "motionarray", "color" => "#5C5CFF", "icon" => "fa-film"],
                "ShutterStock" => ["slug" => "shutterstock", "color" => "#EE2B25", "icon" => "fa-camera"],
                "Epidemic Sound" => ["slug" => "epidemicsound", "color" => "#F2F2F2", "icon" => "fa-music"],
                "Flaticon Premium" => ["slug" => "flaticon", "color" => "#17D1C6", "icon" => "fa-icons"]
            ];
            foreach($servicesList as $name => $config) {
                $serviceData = (new \App\Http\Controllers\UserServicesController)->getServiceInfos($config['slug']);
                if($serviceData['data']) {
                    $totalActiveServices++;
                    $servicesData[$name] = array_merge($config, $serviceData);
                }
            }
        @endphp

        <!-- Balance Card -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card h-100" data-testid="balance-stat-card" onclick="$('#AddBalanceModal').modal('show');" style="cursor: pointer;">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-wallet" style="color: white; font-size: 1.2rem;"></i>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-success">
                            <i class="fas fa-plus me-1"></i>{{__("Top Up")}}
                        </span>
                    </div>
                </div>
                <div class="stat-value">{{number_format(auth()->user()->balance, 2)}} ₺</div>
                <div class="stat-label">{{__("Current Balance")}}</div>
            </div>
        </div>

        <!-- Active Services -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card h-100" data-testid="active-services-stat">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="color: white; font-size: 1.2rem;"></i>
                    </div>
                </div>
                <div class="stat-value">{{$totalActiveServices}}</div>
                <div class="stat-label">{{__("Active Services")}}</div>
            </div>
        </div>

        <!-- Total Downloads -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card h-100" data-testid="total-downloads-stat">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download" style="color: white; font-size: 1.2rem;"></i>
                    </div>
                </div>
                @php
                    $totalAllDowns = 0;
                    foreach($servicesData as $sd) {
                        $totalAllDowns += $sd['allDowns'] ?? 0;
                    }
                @endphp
                <div class="stat-value">{{$totalAllDowns}}</div>
                <div class="stat-label">{{__("Total Downloads")}}</div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card h-100" data-testid="account-status-stat">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-shield" style="color: white; font-size: 1.2rem;"></i>
                    </div>
                </div>
                <div class="stat-value" style="font-size: 1.5rem;">
                    @if($totalActiveServices > 0)
                        <span style="color: var(--success);">{{__("Premium")}}</span>
                    @else
                        <span style="color: var(--warning);">{{__("Free")}}</span>
                    @endif
                </div>
                <div class="stat-label">{{__("Account Status")}}</div>
            </div>
        </div>
    </div>

    <!-- Active Services Grid -->
    @if(count($servicesData) > 0)
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2" style="color: var(--brand-primary);"></i>
                    {{__("Active Services Overview")}}
                </h5>
                <span class="badge bg-success">{{count($servicesData)}} {{__("Active")}}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($servicesData as $name => $svc)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="service-card-new active" data-testid="service-card-{{$svc['slug']}}">
                                <!-- Service Header -->
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 44px; height: 44px; background: {{$svc['color']}}20; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas {{$svc['icon']}}" style="color: {{$svc['color']}}; font-size: 1.1rem;"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="service-name mb-0">{{$name}}</h6>
                                        <span class="service-status">{{__("Active")}}</span>
                                    </div>
                                </div>

                                <!-- Stats Row -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div style="background: var(--bg-input); border-radius: 8px; padding: 12px; text-align: center;">
                                            <div style="font-size: 1.25rem; font-weight: 700; color: {{$svc['color']}};">{{$svc['downs']}}</div>
                                            <div style="font-size: 0.7rem; color: var(--text-muted);">{{__("Daily Left")}}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div style="background: var(--bg-input); border-radius: 8px; padding: 12px; text-align: center;">
                                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">{{$svc['allDowns']}}</div>
                                            <div style="font-size: 0.7rem; color: var(--text-muted);">{{__("Total")}}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small style="color: var(--text-muted);">{{__("Quota")}}</small>
                                        <small style="color: var(--text-secondary);">{{$svc['maxp']->total}} / {{$svc['maxp']->max}}</small>
                                    </div>
                                    @php
                                        $percentage = min(($svc['maxp']->total / max($svc['maxp']->max, 1)) * 100, 100);
                                    @endphp
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{$percentage}}%; background: {{$svc['color']}} !important;"></div>
                                    </div>
                                </div>

                                <!-- Expiry -->
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid var(--border-default);">
                                    <small style="color: var(--text-muted);">
                                        <i class="fas fa-clock me-1"></i>{{__("Expires")}}
                                    </small>
                                    <small style="color: {{$svc['color']}}; font-weight: 600;">
                                        {{ \Carbon\Carbon::create($svc['expDAte'])->diffForHumans(\Carbon\Carbon::now(), ['parts' => 1]) }}
                                    </small>
                                </div>

                                <!-- Quick Access Button -->
                                <a href="{{ route('panel.service.'.$svc['slug']) }}" class="btn btn-sm btn-light w-100 mt-3" data-testid="access-{{$svc['slug']}}-btn">
                                    <i class="fas fa-download me-1"></i>{{__("Download Now")}}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- No Active Services -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body text-center py-5">
                <div style="width: 80px; height: 80px; background: var(--bg-input); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-box-open" style="font-size: 2rem; color: var(--text-muted);"></i>
                </div>
                <h5 style="color: var(--text-primary);">{{__("No Active Services")}}</h5>
                <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 20px;">
                    {{__("You don't have any active services yet. Activate a key or contact your dealer to start downloading.")}}
                </p>
                <button class="btn btn-primary" onclick="$('#usingKeyModal').modal('show');" data-testid="activate-key-btn">
                    <i class="fas fa-key me-2"></i>{{__("Activate Key")}}
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Access Services -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket me-2" style="color: var(--brand-primary);"></i>
                    {{__("Quick Access")}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $quickServices = [
                            ['name' => 'Envato Elements', 'route' => 'panel.service.envatoelements', 'color' => '#81B441', 'icon' => 'fa-leaf'],
                            ['name' => 'Freepik', 'route' => 'panel.service.freepik', 'color' => '#3075FF', 'icon' => 'fa-image'],
                            ['name' => 'Shutterstock', 'route' => 'panel.service.shutterstock', 'color' => '#EE2B25', 'icon' => 'fa-camera'],
                            ['name' => 'Motion Array', 'route' => 'panel.service.motionarray', 'color' => '#5C5CFF', 'icon' => 'fa-film'],
                            ['name' => 'Epidemic Sound', 'route' => 'panel.service.epidemicsound', 'color' => '#666', 'icon' => 'fa-music'],
                            ['name' => 'Flaticon', 'route' => 'panel.service.flaticon', 'color' => '#17D1C6', 'icon' => 'fa-icons'],
                        ];
                    @endphp
                    @foreach($quickServices as $qs)
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="{{ route($qs['route']) }}" class="text-decoration-none" data-testid="quick-access-{{strtolower(str_replace(' ', '-', $qs['name']))}}">
                                <div style="background: var(--bg-input); border: 1px solid var(--border-default); border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s ease;" 
                                     onmouseover="this.style.borderColor='{{$qs['color']}}'; this.style.transform='translateY(-4px)';" 
                                     onmouseout="this.style.borderColor='var(--border-default)'; this.style.transform='translateY(0)';">
                                    <div style="width: 48px; height: 48px; background: {{$qs['color']}}20; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                        <i class="fas {{$qs['icon']}}" style="color: {{$qs['color']}}; font-size: 1.2rem;"></i>
                                    </div>
                                    <div style="font-size: 0.8rem; font-weight: 500; color: var(--text-primary);">{{$qs['name']}}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Downloads -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2" style="color: var(--brand-primary);"></i>
                    {{__("Recent Downloads")}}
                </h5>
                <span class="badge bg-primary">{{count($downloads)}} {{__("Records")}}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" data-testid="recent-downloads-table">
                        <thead>
                            <tr>
                                <th>{{__("ID")}}</th>
                                <th>{{__("Service")}}</th>
                                <th>{{__("Content")}}</th>
                                <th>{{__("Status")}}</th>
                                <th>{{__("Time")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($downloads as $key => $val)
                                @php
                                    if($val->type != 'success' && $val->name=='freepik') continue;
                                    
                                    $serviceColors = [
                                        'freepik' => '#3075FF',
                                        'envatoelements' => '#81B441',
                                        'shutterstock' => '#EE2B25',
                                        'flaticon' => '#17D1C6',
                                        'motionarray' => '#5C5CFF',
                                        'epidemicsound' => '#666',
                                        'adobestock' => '#FF0000'
                                    ];
                                    $color = $serviceColors[$val->name] ?? '#6366f1';
                                @endphp
                                <tr>
                                    <td>
                                        <span style="color: var(--text-muted);">#{{$val->id}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 32px; height: 32px; background: {{$color}}20; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                                <i class="fas fa-download" style="color: {{$color}}; font-size: 0.8rem;"></i>
                                            </div>
                                            <span style="text-transform: capitalize; font-weight: 500;">{{$val->name}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ $val->value }}" target="_blank" class="btn btn-sm btn-outline-primary" data-testid="view-content-{{$val->id}}">
                                            <i class="fas fa-external-link-alt me-1"></i>{{__("View")}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($val->type == 'success')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>{{__("Success")}}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>{{__("Failed")}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="color: var(--text-secondary);">
                                            {{ \Carbon\Carbon::create($val->created_at)->diffForHumans(\Carbon\Carbon::now(),['parts'=>1]) }}
                                        </div>
                                        <small style="color: var(--text-muted);">{{ $val->created_at }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox mb-2" style="font-size: 2rem; color: var(--text-muted);"></i>
                                        <p style="color: var(--text-muted); margin: 0;">{{__("No downloads yet")}}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
