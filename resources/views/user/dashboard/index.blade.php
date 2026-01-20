@extends('layouts.SolarTheme')

@section('title')
    {{__("Dashboard")}}
@endsection

@section('content')

    <!-- User Profile Section -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">


                    <!-- Language Selection -->
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-center mt-3 mt-lg-0">
                            <div class="me-3">
                                <h6 class="fw-semibold mb-2 text-dark">
                                    <i class="ti ti-world me-2"></i>{{ __('Language') }}
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="?setLang=tr" class="btn btn-outline-primary btn-sm px-3 mr-2">
                                        <span class="fi fi-tr me-2"></span>Türkçe
                                    </a>
                                    <a href="?setLang=en" class="btn btn-primary btn-sm px-3 mr-2">
                                        <span class="fi fi-us me-2"></span>English
                                    </a>
                                    <a href="?setLang=es" class="btn btn-outline-primary btn-sm px-3 mr-2">
                                        <span class="fi fi-es me-2"></span>Español
                                    </a>
                                    <a href="?setLang=fr" class="btn btn-outline-primary btn-sm px-3 mr-2">
                                        <span class="fi fi-fr me-2"></span>Français
                                    </a>
                                    <a href="?setLang=bd" class="btn btn-outline-primary btn-sm px-3 mr-2">
                                        <span class="fi fi-bd me-2"></span>বাংলা
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Active Services Overview -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0 text-dark">{{ __('Active Services Overview') }}</h5>
            </div>
            <div class="card-body p-4">
                @php
                    $services = [
                        "Freepik Premium" => ["slug" => "freepik", "color" => "primary", "icon" => "ti-photo"],
                        "Envato Elements" => ["slug" => "envatoelements", "color" => "success", "icon" => "ti-video"],
                        "Motion Array" => ["slug" => "motionarray", "color" => "info", "icon" => "ti-movie"],
                        "ShutterStock" => ["slug" => "shutterstock", "color" => "danger", "icon" => "ti-camera"],
                        "Epidemic Sound" => ["slug" => "epidemicsound", "color" => "warning", "icon" => "ti-music"],
                        "Flaticon Premium" => ["slug" => "flaticon", "color" => "dark", "icon" => "ti-icons"]
                    ];
                @endphp

                <div class="row g-3">
                    @foreach($services as $name => $config)
                        @php
                            $serviceData = (new \App\Http\Controllers\UserServicesController)->getServiceInfos($config['slug']);
                        @endphp
                        @if($serviceData['data'])
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card border h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $config['color'] }} bg-opacity-10 rounded-2 p-2 me-2">
                                                    <i class="ti {{ $config['icon'] }} text-{{ $config['color'] }}"></i>
                                                </div>
                                                <h6 class="fw-semibold mb-0">{{ $name }}</h6>
                                            </div>
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                                        <i class="ti ti-download text-{{ $config['color'] }} me-1"></i>
                                                        <small class="text-muted">{{ __('Remaining Daily Download') }}</small>
                                                    </div>
                                                    <div class="fw-bold text-{{ $config['color'] }}">{{ $serviceData['downs'] }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-2 bg-light rounded">
                                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                                        <i class="ti ti-sum text-{{ $config['color'] }} me-1"></i>
                                                        <small class="text-muted">{{ __('Total Download') }}</small>
                                                    </div>
                                                    <div class="fw-bold text-{{ $config['color'] }}">{{ $serviceData['allDowns'] }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">{{ __('Quota Usage') }}</small>
                                                <small class="fw-semibold">{{ $serviceData['maxp']->total }}
                                                    / {{ $serviceData['maxp']->max }}</small>
                                            </div>
                                            @php
                                                $percentage = ($serviceData['maxp']->total / $serviceData['maxp']->max) * 100;
                                            @endphp
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $config['color'] }}"
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                            <small class="text-muted">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ __('Expires in') }}
                                            </small>
                                            <small class="fw-semibold text-{{ $config['color'] }}">
                                                {{ \Carbon\Carbon::create($serviceData['expDAte'])->diffForHumans(\Carbon\Carbon::now(), ['parts' => 1]) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{--    <!-- Active Services Table -->
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0 text-dark">{{ __('Active Services') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-semibold">{{ __('Service') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Daily Limit') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Max Quota') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Service Scope') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Status') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Expires') }}</th>
                                <th class="border-0 fw-semibold">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key=>$val)
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="fw-semibold">{{ $val->name }}</div>
                                            <small class="text-muted ms-2">#{{ $val->id }}</small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-semibold">{{ $val->downs }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-semibold">{{ $val->max }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($val->services as $k=>$v)
                                                <span class="badge bg-light text-dark">{{ ucfirst($v) }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @if($val->exp_date <= \Carbon\Carbon::now())
                                            <span class="badge bg-danger">{{ __('Expired') }}</span>
                                        @else
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-semibold">
                                            {{ \Carbon\Carbon::create($val->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>1]) }}
                                        </div>
                                        <small class="text-muted">{{ $val->exp_date }}</small>
                                    </td>
                                    <td class="py-3">
                                        @if($val->order_id)
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                    onclick="showOrderDetails({{ $val->order_id }}, '{{ $val->exp_date }}')">
                                                <i class="ti ti-eye me-1"></i>{{ __('View') }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>--}}

    <!-- Recent Downloads -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4 p-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0 text-dark">{{ __('Recent Downloads') }}</h5>
            </div>
            <style>
                #DataTables_Table_0_wrapper > div:nth-child(3) {
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
            </style>
            <div class="card-body p-0">
                <div class="table-responsive" style="overflow: hidden">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="border-0 fw-semibold">{{ __('ID') }}</th>
                            <th class="border-0 fw-semibold">{{ __('Service') }}</th>
                            <th class="border-0 fw-semibold">{{ __('Content') }}</th>
                            <th class="border-0 fw-semibold">{{ __('Status') }}</th>
                            <th class="border-0 fw-semibold">{{ __('Time') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($downloads as $key=>$val)
                            @php
                                if($val->type != 'success' && $val->name=='freepik'){
                                    continue;
                                }
                            @endphp
                            <tr>
                                <td class="py-3">
                                    <span class="fw-semibold">#{{ $val->id }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold">{{ $val->name }}</div>
                                    @if($val->old && $val->new)
                                        <small class="text-muted">{{ __('Old') }}: {{ $val->old }} ₺ → {{ __('New') }}
                                            : {{ $val->new }} ₺</small>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <a href="{{ $val->value }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-external-link me-1"></i>{{ __('View Content') }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    @if($val->type != 'success')
                                        <span class="badge bg-danger">
                                            <i class="ti ti-x me-1"></i>{{ __('Failed') }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="ti ti-check me-1"></i>{{ __('Success') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::create($val->created_at)->diffForHumans(\Carbon\Carbon::now(),['parts'=>1]) }}
                                    </div>
                                    <small class="text-muted">{{ $val->created_at }}</small>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showOrderDetails(orderId, expDate) {
            // AJAX ile order detaylarını al
            fetch(`/order-details/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    const order = data.order;
                    const product = data.product;

                    Swal.fire({
                        title: '{{ __("Order Details") }}',
                        html: `
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Payment Method") }}:</td>
                                        <td class="text-start">${order.gateway}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Payment Time") }}:</td>
                                        <td class="text-start">${order.payment_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Service End") }}:</td>
                                        <td class="text-start">${expDate}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Price") }}:</td>
                                        <td class="text-start"><span class="badge bg-success">${order.price} ₺</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Service Name") }}:</td>
                                        <td class="text-start">${product.name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Daily Download") }}:</td>
                                        <td class="text-start"><span class="badge bg-primary">${product.downs}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Duration") }}:</td>
                                        <td class="text-start"><span class="badge bg-info">${product.days} {{ __("days") }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-start">{{ __("Description") }}:</td>
                                        <td class="text-start">${product.desc}</td>
                                    </tr>
                                </table>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCloseButton: true,
                        width: 650,
                        customClass: {
                            popup: 'swal2-popup-custom'
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback - orijinal yöntem
                    showOrderDetailsOriginal(orderId, expDate);
                });
        }

        // Orijinal yöntem (fallback için)
        function showOrderDetailsOriginal(orderId, expDate) {
            @foreach($data as $val)
                    @if($val->order_id)
                    @php
                        $order = \App\Order::find($val->order_id);
                        $product = $order ? unserialize($order->product) : null;
                    @endphp
                    @if($order && $product)
            if (orderId === {{ $val->order_id }}) {
                Swal.fire({
                    title: '{{ __("Order Details") }}',
                    html: `
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm">
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Payment Method") }}:</td>
                                                <td class="text-start">{{ $order->gateway }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Payment Time") }}:</td>
                                                <td class="text-start">{{ $order->payment_date }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Service End") }}:</td>
                                                <td class="text-start">${expDate}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Price") }}:</td>
                                                <td class="text-start"><span class="badge bg-success">{{ $order->price }} ₺</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Service Name") }}:</td>
                                                <td class="text-start">{{ $product['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Daily Download") }}:</td>
                                                <td class="text-start"><span class="badge bg-primary">{{ $product['downs'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Duration") }}:</td>
                                                <td class="text-start"><span class="badge bg-info">{{ $product['days'] }} {{ __("days") }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-start">{{ __("Description") }}:</td>
                                                <td class="text-start">{{ str_replace(["\r\n", "\r", "\n"],'', $product['desc']) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    width: 650,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            }
            @endif
            @endif
            @endforeach
        }
    </script>

    <style>
        .swal2-popup-custom {
            border-radius: 12px !important;
        }
        .swal2-popup-custom .table {
            margin-bottom: 0;
        }
        .swal2-popup-custom .table td {
            padding: 8px 12px;
            vertical-align: middle;
        }
        .swal2-popup-custom .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection