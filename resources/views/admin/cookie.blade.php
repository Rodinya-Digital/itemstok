@extends('layouts.SolarTheme')

@section('title')
    {{__("Cookie Yönetimi")}}
@endsection

@section('content')
    @php
        function serviceAuthDetail(string $name): array {
            $raw = DB::table('service_auths')->where('name', $name)->value('detail_raw');
            try { return json_decode($raw, true, 512, JSON_THROW_ON_ERROR); } catch (\Exception $e) { return []; }
        }
        function getServiceAuth(string $name) { return DB::table('service_auths')->where('name', $name)->first(); }
        function timeAgo($datetime) {
            if (!$datetime) return 'Hiç güncellenmedi';
            return \Carbon\Carbon::parse($datetime)->diffForHumans();
        }
    @endphp

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Cookie Paneli</h6>
                    <small class="text-muted">Hızlı yönetim</small>
                </div>
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills" id="cookieTabs" role="tablist">
                        <button class="nav-link active d-flex align-items-center gap-2 text-start" data-bs-toggle="pill" data-bs-target="#tab-freepik" type="button">
                            <i class="fas fa-image"></i> Freepik 
                            <span class="badge bg-secondary ms-auto">2</span>
                        </button>
                        <button class="nav-link d-flex align-items-center gap-2 text-start" data-bs-toggle="pill" data-bs-target="#tab-flaticon" type="button">
                            <i class="fas fa-icons"></i> Flaticon 
                            <span class="badge bg-secondary ms-auto">4</span>
                        </button>
                        <button class="nav-link d-flex align-items-center gap-2 text-start" data-bs-toggle="pill" data-bs-target="#tab-envato" type="button">
                            <i class="fas fa-leaf"></i> Envato 
                            <span class="badge bg-secondary ms-auto">2</span>
                        </button>
                        <button class="nav-link d-flex align-items-center gap-2 text-start" data-bs-toggle="pill" data-bs-target="#tab-motion" type="button">
                            <i class="fas fa-video"></i> Motion Array 
                            <span class="badge bg-secondary ms-auto">1</span>
                        </button>
                        <button class="nav-link d-flex align-items-center gap-2 text-start" data-bs-toggle="pill" data-bs-target="#tab-epidemic" type="button">
                            <i class="fas fa-music"></i> Epidemic 
                            <span class="badge bg-secondary ms-auto">1</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9 col-md-8">
            <div class="tab-content">

                <!-- Freepik -->
                <div class="tab-pane fade show active" id="tab-freepik">
                    <div class="mb-3">
                        <h4 class="mb-1">Freepik</h4>
                        <p class="text-muted mb-0">Görsel & vektör premium hesap yönetimi</p>
                    </div>
                    <div class="row g-3">
                        @for($i=1; $i<3; $i++)
                            @php
                                $svc = serviceAuthDetail('freepik'.$i);
                                $auth = getServiceAuth('freepik'.$i);
                                $usage = (isset($svc['downloads']) && isset($svc['limit_downloads']) && $svc['limit_downloads']>0)
                                    ? round(($svc['downloads']/$svc['limit_downloads'])*100) : 0;
                            @endphp
                            <div class="col-xl-6">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Hesap #{{$i}}</h6>
                                            <small class="text-muted">{{ timeAgo($auth->updated_at ?? null) }}</small>
                                        </div>
                                        @if(isset($svc['premium']) && $svc['premium'])
                                            <span class="badge bg-warning text-dark"><i class="fas fa-crown me-1"></i>Premium</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        @if(isset($svc['login']))
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <img src="{{$svc['avatar'] ?? ''}}" class="rounded" width="40" height="40" style="object-fit:cover" onerror="this.src='https://ui-avatars.com/api/?name={{$svc['login']}}&background=6366f1&color=fff'">
                                                <div>
                                                    <div class="fw-semibold">{{$svc['login']}}</div>
                                                    <small class="text-muted">{{$svc['email'] ?? '-'}}</small>
                                                </div>
                                            </div>
                                            @if(isset($svc['downloads']) && isset($svc['limit_downloads']))
                                                <div class="d-flex justify-content-between small text-muted mb-1">
                                                    <span>İndirme</span>
                                                    <span>{{$svc['downloads']}} / {{$svc['limit_downloads']}}</span>
                                                </div>
                                                <div class="progress mb-3" style="height: 6px;">
                                                    <div class="progress-bar bg-{{ $usage > 80 ? 'danger' : ($usage > 50 ? 'warning' : 'success') }}" 
                                                         role="progressbar" style="width: {{$usage}}%;"></div>
                                                </div>
                                            @endif
                                        @endif
                                        <form method="post" action="{{route('cookie_freepik'.$i.'_update',['id'=>1])}}">
                                            @csrf
                                            <textarea name="freepik{{$i}}" class="form-control mb-3" rows="4" placeholder="Cookie JSON..." style="font-family: monospace; font-size: 0.85rem;">{{$auth->cookie ?? ''}}</textarea>
                                            <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Flaticon -->
                <div class="tab-pane fade" id="tab-flaticon">
                    <div class="mb-3">
                        <h4 class="mb-1">Flaticon</h4>
                        <p class="text-muted mb-0">İkon kütüphanesi</p>
                    </div>
                    <div class="row g-3">
                        @for($i=1; $i<5; $i++)
                            @php $auth = getServiceAuth('flaticon'.$i); @endphp
                            <div class="col-xl-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">Flaticon #{{$i}}</h6>
                                        <small class="text-muted">{{ timeAgo($auth->updated_at ?? null) }}</small>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('cookie_flaticon'.$i.'_update',['id'=>1])}}">
                                            @csrf
                                            <textarea name="flaticon{{$i}}" class="form-control mb-3" rows="4" placeholder="Cookie JSON..." style="font-family: monospace; font-size: 0.85rem;">{{$auth->cookie ?? ''}}</textarea>
                                            <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Envato -->
                <div class="tab-pane fade" id="tab-envato">
                    <div class="mb-3">
                        <h4 class="mb-1">Envato Elements</h4>
                        <p class="text-muted mb-0">Dijital varlıklar</p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Envato cookie'lerini JSON array olarak yapıştırın (.envato.com ve .elements.envato.com domainleri dahil).
                    </div>
                    <div class="row g-3">
                        @for($i=1; $i<3; $i++)
                            @php $auth = getServiceAuth('envatoelements'.$i); @endphp
                            <div class="col-xl-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">Envato #{{$i}}</h6>
                                        <small class="text-muted">{{ timeAgo($auth->updated_at ?? null) }}</small>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('cookie_envatoelements'.$i.'_update',['id'=>1])}}">
                                            @csrf
                                            <textarea name="envatoelements{{$i}}" class="form-control mb-3" rows="5" placeholder="Envato cookie JSON array..." style="font-family: monospace; font-size: 0.85rem;">{{$auth->cookie ?? ''}}</textarea>
                                            <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Motion Array -->
                <div class="tab-pane fade" id="tab-motion">
                    <div class="mb-3">
                        <h4 class="mb-1">Motion Array</h4>
                        <p class="text-muted mb-0">Video ve şablon</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            @php $auth = getServiceAuth('motionarray'); @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Ana Hesap</h6>
                                    <small class="text-muted">{{ timeAgo($auth->updated_at ?? null) }}</small>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{route('cookie_motionarray_update',['id'=>1])}}">
                                        @csrf
                                        <textarea name="motionarray" class="form-control mb-3" rows="5" placeholder="Motion Array cookie..." style="font-family: monospace; font-size: 0.85rem;">{{$auth->cookie ?? ''}}</textarea>
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Epidemic Sound -->
                <div class="tab-pane fade" id="tab-epidemic">
                    <div class="mb-3">
                        <h4 class="mb-1">Epidemic Sound</h4>
                        <p class="text-muted mb-0">Müzik ve ses</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            @php $auth = getServiceAuth('epidemicsound'); @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Ana Hesap</h6>
                                    <small class="text-muted">{{ timeAgo($auth->updated_at ?? null) }}</small>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{route('cookie_epidemicsound_update',['id'=>1])}}">
                                        @csrf
                                        <textarea name="epidemicsound" class="form-control mb-3" rows="5" placeholder="Epidemic Sound cookie..." style="font-family: monospace; font-size: 0.85rem;">{{$auth->cookie ?? ''}}</textarea>
                                        <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
