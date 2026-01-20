@extends('layouts.SolarTheme')

@section('title')
    {{__("Admin Dashboard")}}
@endsection

@section('content')
    <style>
        .volt-bg {
            background-color: #576574 !important;
        }
    </style>

    <div class="col-12">
        <div class="ios-blur p-4 d-flex align-items-center gap-4 mb-4 text-white">
            <div class="position-relative mr-4">
                <div class="border border-2 border-primary rounded-circle">
                    <img src="{{asset('SolarTheme/images/profile/user-'.\Auth::user()->avatar.'.jpg')}}" class="rounded-circle m-1" alt="user1" width="60">
                </div>
            </div>
            <div>
                <h3 class="fw-semibold">{{\Auth::user()->name.' '.\Auth::user()->surname}}
                </h3>
                <span>Hoş geldiniz.</span>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('SolarTheme/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img">
                        <p class="fw-semibold fs-3 text-primary mb-1">
                            {{__("Yönetici")}}
                        </p>
                        <h5 class="fw-semibold text-primary mb-0">{{$adminUsers->count()}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('SolarTheme/images/svgs/icon-briefcase.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img">
                        <p class="fw-semibold fs-3 text-warning mb-1">{{__('Costumers')}}</p>
                        <h5 class="fw-semibold text-warning mb-0">{{$userCount}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('SolarTheme/images/svgs/icon-mailbox.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img">
                        <p class="fw-semibold fs-3 text-info mb-1">{{__('Register Today')}}</p>
                        <h5 class="fw-semibold text-info mb-0">{{$todayRegUserCount}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('SolarTheme/images/svgs/icon-favorites.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img">
                        <p class="fw-semibold fs-3 text-danger mb-1">{{__('Today Define')}}</p>
                        <h5 class="fw-semibold text-danger mb-0">{{$todayRegServiceCount}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('SolarTheme/images/svgs/icon-speech-bubble.svg')}}" width="50" height="50" class="mb-3" alt="modernize-img">
                        <p class="fw-semibold fs-3 text-success mb-1">T.K. Balance</p>
                        <h5 class="fw-semibold text-success mb-0">{{number_format(\App\User::where('balance','>',0)->sum('balance'),2)}} ₺</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xl-12 mb-5">
            <!--begin::Chart widget 38-->
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <div style="display: flex;justify-content: space-between;">
                        <span class="fw-bold text-gray-800">{{__('Download History')}}</span>

                        <div class="d-flex align-items-center">
                            <label for="dateRangeSelect" class="me-3">{{__('Gösterilen:')}}</label>
                            <select class="form-select" id="dateRangeSelect" style="width: 150px;">
                                <option value="7" selected>{{__('Son 7 Gün')}}</option>
                                <option value="14">{{__('Son 14 Gün')}}</option>
                                <option value="30">{{__('Son 30 Gün')}}</option>
                                <option value="90">{{__('Son 90 Gün')}}</option>
                            </select>
                        </div>
                    </div>
                    <!--end::Title-->

                    <!--begin::Date Range Selector-->

                    <!--end::Date Range Selector-->

                </div>


                <!--end::Header-->
                <!--begin::Body-->

                <div class="row px-4">
                    <div class="col-sm-9 ">
                        <div id="downloadHistoryChart" class="w-100 min-h-auto ps-4 pe-6">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" id="activeServicesStat">

                    </div>
                </div>

                <!--end: Card Body-->
            </div>
            <!--end::Chart widget 38-->
        </div>
    </div>
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12 mb-5">
            <!--begin::Chart widget 38-->
            <div class="card card-flush ">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <div style="display: flex;justify-content: space-between;">
                        <span class="fw-bold text-gray-800">{{__('Günlere Göre Ödemeler')}}</span>

                        <div class="d-flex align-items-center">
                            <label for="dateRangeSelectPayments" class="me-3">{{__('Gösterilen:')}}</label>
                            <select class="form-select" id="dateRangeSelectPayments" style="width: 150px;">
                                <option value="7" selected>{{__('Son 7 Gün')}}</option>
                                <option value="14">{{__('Son 14 Gün')}}</option>
                                <option value="30">{{__('Son 30 Gün')}}</option>
                                <option value="90">{{__('Son 90 Gün')}}</option>
                            </select>
                        </div>
                    </div>
                    <!--end::Title-->

                    <!--begin::Date Range Selector-->

                    <!--end::Date Range Selector-->

                </div>


                <!--end::Header-->
                <!--begin::Body-->
                <div class="row">
                    <div class="col-sm-9">
                        <div id="paymentHistoryChart" class="w-100 min-h-auto ps-4 pe-6">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" style="padding: 0 35px">
                        <style>
                            .extra-info {
                                background-color: #f8f9fa;
                                border-radius: 8px;
                                padding: 15px;
                                box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
                                margin-top: 20px;
                            }

                            .extra-info h3 {
                                font-size: 1.25rem;
                                font-weight: bold;
                                margin-bottom: 15px;
                                color: #343a40;
                            }

                            .extra-info p {
                                font-size: 1rem;
                                margin-bottom: 10px;
                                display: flex;
                                justify-content: space-between;
                                font-weight: bold;
                            }

                            .extra-info p span {
                                color: #007bff;
                            }
                        </style>
                        <div class="extra-info">
                            <h3 class="text-center">Ekstra Bilgiler</h3>
                            <p>Bugün: <span id="todayTotal">Yükleniyor...</span></p>
                            <p>Dün: <span id="yesterdayTotal">Yükleniyor...</span></p>
                            <p>Bu Hafta: <span id="thisWeekTotal">Yükleniyor...</span></p>
                            <p>Geçen Hafta: <span id="lastWeekTotal">Yükleniyor...</span></p>
                            <p>Bu Ay: <span id="thisMonthTotal">Yükleniyor...</span></p>
                            <p>Geçen Ay: <span id="lastMonthTotal">Yükleniyor...</span></p>
                            <p>Bu Yıl: <span id="thisYearTotal">Yükleniyor...</span></p>
                            <p>Geçen Yıl: <span id="befYearTotal">Yükleniyor...</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Card Body-->

        </div>
    </div>
    <div class="row g-5 g-xl-8 mb-8">
<div class="col-xl-12 mb-5">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{__("Last Downloads")}}</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered display text-nowrap">
                    <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Service</th>
                        <th scope="col">Source Url</th>
                        <th scope="col">Zaman</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Log::orderBy('id','desc')->limit(100)->get() as $log)
                        <tr>
                            <td>
                                {!!$log->id!!}
                                <a href="{{route('panel.uservice.user',$log->user_id)}}"
                                   class="btn btn-sm btn-warning mr-1" data-toggle="tooltip"
                                   title="Servis Yönetimi">
                                    <i class="fas fa-user-cog"></i>
                                </a>
                                <a href="{{route('panel.users.edit',$log->user_id)}}"
                                   class="btn btn-sm btn-primary mr-1" data-toggle="tooltip"
                                   title="Düzenle">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                {{\App\User::find($log->user_id)->email}}</td>

                            <td>
                                    <?php
                                    if ($log->type == 'success') {
                                        echo "<span class='badge text-bg-success'>Başarılı</span>";
                                    }
                                    if ($log->type == 'danger') {
                                        echo "<span class='badge text-bg-danger'>HATA!</span>";
                                    }
                                    if ($log->type == 'info') {
                                        echo "<span class='badge text-bg-warning'>İşleniyor...</span>";
                                    }
                                    if ($log->name == 'envatoelements') {
                                        echo "<span class='badge text-bg-success'>Envato Elements</span>";
                                    }
                                    if ($log->name == 'freepik') {
                                        echo "<span class='badge text-bg-primary'>Freepik Premium</span>";
                                    }
                                    if ($log->name == 'flaticon') {
                                        echo "<span class='badge text-bg-info'>Flaticon</span>";
                                    }
                                    if ($log->name == 'epidemicsound') {
                                        echo "<span class='badge text-bg-info'>Epidemic Sound</span>";
                                    }
                                    if ($log->name == 'adobestock') {
                                        echo "<span class='badge text-bg-info'>Adobestock</span>";
                                    }
                                    if ($log->name == 'motionelements') {
                                        echo "<span class='badge text-bg-info'>Motion Elements</span>";
                                    }
                                    if ($log->name == 'motionarray') {
                                        echo "<span class='badge text-bg-info'>Motion Array</span>";
                                    }
                                    if ($log->name == 'shutterstock') {
                                        echo "<span class='badge text-bg-danger'>ShutterStock</span>";
                                    }
                                    if ($log->name == 'otherservices') {
                                        echo "<span class='badge text-bg-danger'>Other Services<br>".TranslateName($log->value)."</span>";
                                        if ($log->old) {
                                            echo "(Old: $log->old - New: $log->new)";
                                        }
                                    }
                                    ?>
                            </td>
                            <td>
                                    <?php
                                    $result = json_decode($log->value);
                                    if (json_last_error())
                                        echo "<a class='btn btn-primary btn-sm' target='_blank' href='" . $log->value . "'>İçeriğe Git</a>";
                                    else
                                        echo "<a class='btn btn-primary btn-sm' target='_blank' href='" . $result->url . "'>İçeriğe Git</a>";
                                    ?>
                            </td>
                            <td>{!!$log->created_at!!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


        @php
            function TranslateName($url) {
                // Geçerli bir URL olup olmadığını kontrol et
                if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                    return "Invalid URL";
                }

                // URL'den domain kısmını al
                $domain = parse_url($url, PHP_URL_HOST);

                // "www." kısmını çıkar
                $domain = str_replace('www.', '', $domain);

                // Alan adının ana kısmını al
                $mainPart = explode('.', $domain)[0];

                // İlk harfi büyük yap
                $formattedName = ucfirst($mainPart);

                return $formattedName;
            }
 @endphp
        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__("Last Orders")}}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered display text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">UID & PRDC</th>
                                <th scope="col">Product</th>
                                <th scope="col">Detail</th>
                                <th scope="col">{{__('Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Order::orderBy('updated_at','desc')->limit(30)->get() as $log)
                                <tr>
                                    <td>
                                        {!!$log->id!!}
                                        <a href="{{route('panel.uservice.user',$log->user_id)}}"
                                           class="btn btn-sm btn-light-warning mr-1" data-toggle="tooltip"
                                           title="Servis Yönetimi">
                                            <i class="fas fa-user-cog"></i>
                                        </a>
                                        <a href="{{route('panel.users.edit',$log->user_id)}}"
                                           class="btn btn-sm btn-light-primary mr-1" data-toggle="tooltip"
                                           title="Düzenle">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>


                                        {{\App\User::find($log->user_id)->email}}
                                    </td>
                                    @if($log->type=='service')
                                        <td>{{unserialize($log->product)['name']}}</td>
                                    @else
                                        <td>{{$log->name}}</td>
                                    @endif
                                    <td>
                                        <b class="btn btn-primary p-1">{{$log->price}} ₺</b>
                                        <button class="btn btn-dark p-1"
                                                onclick='orderDetailFunc({!! unserialize($log->detail)?:'' !!})'>
                                            Detaylar
                                        </button>
                                            <?php
                                            if ($log->status == '1') {
                                                echo "<span class='btn btn-success p-1'>Ödendi</span>";
                                            }
                                            if ($log->status == '2') {
                                                echo "<span class='btn btn-danger p-1'>Ödenmedi</span>";
                                            }
                                            if ($log->status == '0') {
                                                echo "<span class='btn btn-warning p-1'>Bekliyor</span>";
                                            }
                                            ?></td>
                                    <td>{!!$log->updated_at!!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__("Last Service Definies")}}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered display text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Product</th>
                                <th scope="col">Zaman</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\UserServices::orderBy('id','desc')->limit(30)->get() as $log)
                                <tr>
                                    <td>{!!$log->id!!}</td>
                                    <td>
                                        <a href="{{route('panel.uservice.user',$log->user_id)}}"
                                           class="btn btn-sm btn-light-warning mr-1" data-toggle="tooltip"
                                           title="Servis Yönetimi">
                                            <i class="fas fa-user-cog"></i>
                                        </a>
                                        <a href="{{route('panel.users.edit',$log->user_id)}}"
                                           class="btn btn-sm btn-light-primary mr-1" data-toggle="tooltip"
                                           title="Düzenle">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        {{\App\User::find($log->user_id)->email}}</td>
                                    <td>{{($log->name=='Key Kullan'||$log->name=='Using Key')?'KEY -> '.\App\Managekey::find($log->owner)->name:$log->owner}}</td>
                                    <td>{{$log->name}}</td>
                                    <td>{!!$log->updated_at!!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__("Managers")}}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered display text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($adminUsers as $admin)
                                <tr>
                                    <td><strong>{{$admin->name.' '.$admin->surname}}</strong>({{$admin->email}})</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script>


        function TranslateName(url) {
            const formatServiceName = (domain) => {
                const mainPart = domain.split('.')[0]; // Alan adının sadece ilk kısmını al
                return mainPart.charAt(0).toUpperCase() + mainPart.slice(1); // İlk harfi büyük yap
            };

            try {
                const domain = new URL(url).hostname.replace('www.', ''); // Domain'i al ve "www." kısmını çıkar
                return formatServiceName(domain); // Formatlanmış servis adını döndür
            } catch (error) {
                return "Invalid URL"; // Geçersiz URL durumunda hata mesajı döndür
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById('dateRangeSelect').addEventListener('change', function () {
            getDownloadChart(this.value)
        });

        document.getElementById('dateRangeSelectPayments').addEventListener('change', function () {
            getPaymentChart(this.value);
        });

        function formatCurrency(amount) {
            return new Intl.NumberFormat('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(amount);
        }

        function getPaymentChart(days) {
            $('#paymentHistoryChart').html(`
                <div id="loadingPaymentChart" class="spinner-border text-primary" role="status">
                    <span class="sr-only">Yükleniyor...</span>
                </div>
            `);

            $.get('<?= route('getPaymentStats') . '?days=' ?>' + days, {
                token_: $('meta[name="csrf-token"]').attr('content')
            }).done((response) => {
                $('#loadingPaymentChart').remove();
                var chart = new ApexCharts(document.querySelector("#paymentHistoryChart"), {
                    series: [{
                        name: 'TOPLAM ÖDEME',
                        data: response.data
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'datetime',
                    },
                    yaxis: {
                        opposite: true
                    },
                    legend: {
                        horizontalAlign: 'left'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    fill: {
                        opacity: 1,
                    },
                });
                $('#todayTotal').text(formatCurrency(response.today_total) + ' ₺');
                $('#yesterdayTotal').text(formatCurrency(response.yesterday_total) + ' ₺');
                $('#thisWeekTotal').text(formatCurrency(response.this_week_total) + ' ₺');
                $('#lastWeekTotal').text(formatCurrency(response.last_week_total) + ' ₺');
                $('#thisMonthTotal').text(formatCurrency(response.this_month_total) + ' ₺');
                $('#lastMonthTotal').text(formatCurrency(response.last_month_total) + ' ₺');
                $('#thisYearTotal').text(formatCurrency(response.this_year_total) + ' ₺');
                $('#befYearTotal').text(formatCurrency(response.befYearTotal) + ' ₺');


                chart.render();
            });
        }

        // Sayfa yüklendiğinde varsayılan olarak son 7 günün verilerini göster.
        getPaymentChart(7);

        function getDownloadChart(days) {
            $('#downloadHistoryChart').html(`
            <div id="loadingDownloadChat" class="spinner-border text-primary" role="status">
  <span class="sr-only">Loading...</span>
</div>
            `)
            $.get('<?= route('getDownloadStats') . '?days=' ?>' + days, {
                token_: $('meta[name="csrf-token"]').attr('content')
            }).done((response) => {
                $('#loadingDownloadChat').remove()
                var chart = new ApexCharts(document.querySelector("#downloadHistoryChart"),
                    {
                        series: response,
                        chart: {
                            type: 'area',
                            height: 350,
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        xaxis: {
                            type: 'date',
                        },
                        yaxis: {
                            opposite: true
                        },
                        legend: {
                            horizontalAlign: 'left'
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -10,
                                    offsetY: 0
                                }
                            }
                        }],
                        fill: {
                            opacity: 1,
                        },
                    }
                );
                chart.render();
            })
        }

        getDownloadChart(7)

        $.get('<?= route('getActiveServiceStats') ?>', {
            token_: $('meta[name="csrf-token"]').attr('content')
        }).done((response) => {

            let names = [];
            let series = [];
            response.sort((a, b) => b.count - a.count).forEach((v, i) => {
                names.push(v.name)
                series.push(v.count)
            })



            var chart = new ApexCharts(document.querySelector("#activeServicesStat"), {
                series: [{
                    name: "",
                    data: series.sort((a, b) => b - a)
                }],
                chart: {
                    width: '100%',
                    height: '100%',
                    type: 'bar',
                },
                labels: names,
                plotOptions: {
                    bar: {
                        borderRadius: 0,
                        horizontal: true,
                        distributed: true,
                        barHeight: '80%',
                        isFunnel: true,
                    },
                },
                colors: [
                    '#F44F5E',
                    '#E55A89',
                    '#D863B1',
                    '#CA6CD8',
                    '#B57BED',
                    '#8D95EB',
                    '#62ACEA',
                    '#4BC3E6',
                ],
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opt) {
                        return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
                    },
                    dropShadow: {
                        enabled: true,
                    },
                },
                xaxis: {
                    categories: names,
                },
                legend: {
                    show: false,
                },
            });

            chart.render();
        });


        function orderDetailFunc(data) {
            if (!data) {
                iziToast.destroy();
                iziToast.show({
                    id: 'haduken',
                    theme: 'dark',
                    icon: 'fa fa-sack-dollar',
                    title: 'Ödemesi için 3 gülfi bir elham okuyalım...',
                    displayMode: 2,
                    position: 'topCenter',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    progressBarColor: 'rgb(255,0,0)',
                    image: 'https://media1.tenor.com/m/16ltFxSYe7sAAAAC/waiting-patiently-waiting.gif',
                    imageWidth: 150,
                    titleLineHeight: 150,
                    layout: 2,
                    iconColor: 'rgb(255,0,0)'
                });
                return false;
            }
            if (data.status == 'success') {
                iziToast.destroy();
                iziToast.show({
                    id: 'haduken',
                    theme: 'dark',
                    icon: 'fa fa-sack-dollar',
                    title: 'Ödeme başarılı bir şekilde alınmış.',
                    displayMode: 2,
                    position: 'topCenter',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    progressBarColor: 'rgb(0, 255, 184)',
                    image: 'https://media1.tenor.com/m/ng0mwYEEpNMAAAAd/hasbulla-money.gif',
                    imageWidth: 150,
                    titleLineHeight: 150,
                    layout: 2,
                    iconColor: 'rgb(0, 255, 184)'
                });
            } else {
                iziToast.destroy();
                iziToast.show({
                    id: 'haduken',
                    theme: 'dark',
                    icon: 'fa fa-sack-dollar',
                    title: data.failed_reason_msg,
                    displayMode: 2,
                    position: 'topCenter',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    progressBarColor: 'rgb(255,0,0)',
                    image: 'https://media1.tenor.com/m/j1raonaU590AAAAd/ryan-gosling-sad-sad-gosling.gif',
                    imageWidth: 150,
                    titleLineHeight: 150,
                    layout: 2,
                    iconColor: 'rgb(255,0,0)'
                });
            }

        }
        window.Tawk_API = window.Tawk_API || {};
        window.Tawk_API.onLoad = function() {
            // Aktif kullanıcı sayısını çekmek için API çağrısı
            Tawk_API.getChatData(function(data) {
                var activeUsers = data.activeUsers;
                console.log("Aktif Kullanıcı Sayısı: " + activeUsers);
            });
        };
        document.addEventListener("DOMContentLoaded", function () {
            $(".counter-carousel").owlCarousel({
                loop: true,
                rtl: true,
                margin: 30,
                mouseDrag: true,

                nav: false,

                responsive: {
                    0: {
                        items: 2,
                        loop: true,
                    },
                    576: {
                        items: 2,
                        loop: true,
                    },
                    768: {
                        items: 3,
                        loop: true,
                    },
                    1200: {
                        items: 5,
                        loop: true,
                    },
                    1400: {
                        items: 6,
                        loop: true,
                    },
                },
            });
        })


    </script>
@endsection
