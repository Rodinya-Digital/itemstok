@extends('layouts.SolarTheme')

@section('title')
    {{__("User Service Management")}} -> {{$user->name.' '.$user->surname}}
@endsection
@section('topbuttons')
    <a href="#" onclick="$('#serviceAddModal').modal('show');"
       class="btn btn-primary">{{__("Define Service")}}</a>
@endsection
@section('content')

    <div class="card mb-8 bg-danger">
        <div class="card-body text-white">
            <div class="row">
                <div class="col">
                    <div class="profile-widget-item-label">{{__("Balance")}}</div>
                    <div class="profile-widget-item-value">{{number_format($user->balance,2)}} ₺</div>
                </div>
                <div class="col">
                    <div class="profile-widget-item-label">{{__("All downloads")}}</div>
                    <div class="profile-widget-item-value">{{$allDownsCount}}</div>
                </div>
                <div class="col">
                    <div class="profile-widget-item-label">{{__("Date of registration")}}</div>
                    <div class="profile-widget-item-value">{{\Carbon\Carbon::create($user->created_at)->diffForHumans().' ('.$user->created_at.')'}}</div>
                </div>
                <div class="col">
                    <div class="profile-widget-name">{{$user->name.' '.$user->surname}}
                        <div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div>
                            {{$user->email}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>{{__("Satın Alım Geçmişi")}}</h5>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>{{__("ID")}}</th>
                        <th>{{__("Ürün Adı")}}</th>
                        <th>{{__("Ürün Tipi")}}</th>
                        <th>{{__("Ödeme Tipi")}}</th>
                        <th>{{__("Tutar")}}</th>
                        <th>{{__("Durumu")}}</th>
                        <th>{{__("İşlem Zamanı")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key=>$val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>
                                    <?php
                                    try {
                                        if ($val->product) {
                                            $productData = @unserialize($val->product); // Veriyi önce PHP dizisine çeviriyoruz.
                                            if ($productData !== false) {
                                                echo $productData['name'];
                                            }
                                        } else {
                                            echo "Bakiye Yükleme";
                                        }
                                    }catch (Exception $e){
                                        echo "<span class='badge badge-danger'>Burada bir hata var iso yok detaylarını bilemiyoruz yinede gelen veriyi aşağıya yazam belki anlarsınız :) Seviyorum sizleri ve çok özlediğimi bilin <3</span>";
                                        print_r($e);
                                    }
                                    ?>
                            </td>
                            <td>{{$val->type}}</td>
                            <td>{{$val->price}} ₺</td>
                            <td>{{$val->gateway}}</td>
                            <td>{!! $val->status=='1'?'<span class="badge badge-success">Başarılı</span>':'<span class="badge badge-danger">Başarısız</span>' !!}</td>
                            <td>{{\Carbon\Carbon::create($val->updated_at)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                                ({{$val->updated_at}})
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    <div class="card">
        <div class="card-header">
            <h5>{{__("Servisler")}}</h5>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>{{__("ID")}}</th>
                        <th>{{__("Service Name")}}</th>
                        <th>{{__("Daily Download")}}</th>
                        <th>{{__("Max Download Quota (Preiod)")}}</th>
                        <th>{{__("Service Scope")}}</th>
                        <th>{{__("Status")}}</th>
                        <th>{{__("End Date")}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key=>$val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->downs}}</td>
                            <td>{{$val->max}}</td>
                            <td>@foreach($val->services as $k=>$v)
                                    {{($k!=0?',':'').ucfirst($v)}}
                                @endforeach</td>
                            <td>@if($val->exp_date <= \Carbon\Carbon::now())
                                    <div class="badge badge-danger">{{__("Expired")}}</div>
                                @else
                                    <div class="badge badge-success">{{__("Active")}}</div>
                                @endif</td>
                            <td>{{\Carbon\Carbon::create($val->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                                ({{$val->exp_date}})
                            </td>
                            <td>
                                @if($val->order_id)
                                    <a onclick="swal.fire({'title':'{{__("Order detail")}}','html':'<table class=\'table table-striped\'>' +
                                                 '<tr><td>{{__("Payment method")}}</td><td>{{\App\Order::find($val->order_id)->gateway}}</td></tr>'+
                                                 '<tr><td>{{__("Payment time")}}</td><td>{{\App\Order::find($val->order_id)->payment_date}}</td></tr>'+
                                                 '<tr><td>{{__("Service End")}}</td><td>{{$val->exp_date}}</td></tr>'+
                                                 '<tr><td>{{__("Price")}}</td><td>{{\App\Order::find($val->order_id)->price}} ₺</td></tr>'+
                                                 '<tr><td>{{__("Service Name")}}</td><td>{{unserialize(\App\Order::find($val->order_id)->product)['name']}}</td></tr>'+
                                                 '<tr><td>{{__("Daily Download")}}</td><td>{{unserialize(\App\Order::find($val->order_id)->product)['downs']}}</td></tr><tr>'+
                                                 '<td>{{__("How Many Days")}}</td><td>{{unserialize(\App\Order::find($val->order_id)->product)['days']}}</td></tr><tr><td>{{__("Description")}}</td><td>{{str_replace(["\r\n", "\r", "\n"],'',unserialize(\App\Order::find($val->order_id)->product)['desc']) }}</td></tr></table>','showConfirmButton':false,'showCloseButton':true,'width':600})"
                                       class="btn btn-info"><i class="fas fa-receipt"></i></a>
                                @endif
                                <form id="item_delete_{{$val->id}}"
                                      action="{{route('panel.uservice.destroy',['id'=>$val->id])}}"
                                      method="post"
                                      class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-action" id="item_delete"
                                            data-item="{{$val->id}}"
                                            type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <h3 class="mt-8">Kalan Kullanımlar</h3>
    <hr>
    @foreach($services as $k=>$v)
        @if($v->data)
            <h3 class="mt-8">{{$k}}</h3>
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <span class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-2">
                        <div class="text-white fw-bold fs-5 mb-1">
                            {{$v->downs}}
                        </div>

                        <span class="fw-semibold text-white">
                            {{__("Remaining Daily Download")}}
                        </span>
                    </div>
                        <!--end::Body-->
                </span>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <span class="card bg-success hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-2">

                        <div class="text-white fw-bold fs-5 mb-1">
                         {{\Carbon\Carbon::create($v->data->exp_date)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                        </div>

                        <span class="fw-semibold text-white">
                            {{__("Service End Date")}}
                        </span>
                    </div>
                        <!--end::Body-->
                </span>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <span class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-2">
                        <div class="text-white fw-bold fs-5 mb-1">
                           {{$v->maxp->total}}/{{$v->maxp->max}}
                        </div>

                        <div class="fw-semibold text-white text-decoration-none">
                            {{__("Max Download Quota (Preiod)")}}
                        </div>
                    </div>
                        <!--end::Body-->
                </span>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <span class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-2">

                        <div class="text-white fw-bold fs-5 mb-1">
                            {{$v->allDowns}}
                        </div>

                        <div class="fw-semibold text-white">
                            {{__("Total Downloads")}}
                        </div>
                    </div>
                        <!--end::Body-->
                </span>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
        @endif
    @endforeach


    <div class="card mt-8">
        <div class="card-header py-7">
            <h5>{{__("Download History")}}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped gy-5 gs-7">
                    <thead>
                    <tr>
                        <th>{{__("ID")}}</th>
                        <th>{{__("Service Name")}}</th>
                        <th>{{__("Content")}}</th>
                        <th>{{__("Status")}}</th>
                        <th>{{__("Processing Time")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allDowns as $key=>$val)
                        <tr>
                            <td data-order="DESC">{{$val->id}}</td>
                            <td>{{$val->name}}
                                @if($val->old)
                                    (Old: {{$val->old}} - New: {{$val->new}})
                                @endif
                            </td>
                            <td><?php
                                    echo "<a class='btn btn-primary btn-sm' target='_blank' href='" . $val->value . "'>" . __('Content address') . "</a>";
                                    ?></td>
                            <td>@if($val->type!='success')
                                    <div class="badge badge-danger">{{__("Unsuccessful")}}</div>
                                @else
                                    <div class="badge badge-success">{{__("Successful")}}</div>
                                @endif
                            </td>
                            <td>{{\Carbon\Carbon::create($val->created_at)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                                ({{$val->created_at}})
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="serviceAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__("Define service")}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="modal-body" action="{{route('panel.serviceAddToUser',$user->id)}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="service_unit">{{__("Service Pattern")}}</label>
                        </div>
                        <select class="form-control" id="service_unit">
                            <option value="">{{__("Ready Service Patterns")}}</option>
                            @php($services = App\Service::all())
                            @foreach($services as $service)
                                <option value="{{$service->id}}" data-name="{{$service->name}}"
                                        data-services="{{implode(',',$service->services)}}"
                                        data-downs="{{$service->downs}}"
                                        data-max="{{$service->max}}"
                                        data-days="{{$service->days}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("Service Name")}}</span>
                        </div>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("Service Time (Days)")}}</span>
                        </div>
                        <input type="number" class="form-control" name="days" placeholder="30" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("Download Quota (Days)")}}</span>
                        </div>
                        <input type="number" class="form-control" name="downs" placeholder="10" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("Max Download Quota (Preiod)")}}</span>
                        </div>
                        <input type="number" class="form-control" name="max" placeholder="10" required>
                    </div>
                    <label class="mt-2">{{__("Download permissions")}}</label>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[shutterstock]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("ShutterStock")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[adobestock]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Adobe Stock")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[freepik]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Freepik")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[flaticon]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Flaticon")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[epidemicsound]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Epidemic Sound")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[envatoelements]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Envato Elements")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[motionarray]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Motion Array")}}</span>
                        </label>
                    </div>
                    <div class="input-group mb-2">
                        <label class="custom-switch  p-0">
                            <input type="checkbox" name="services[motionelements]" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{__("Motion Elements")}}</span>
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__("Cancel")}}</button>
                        <button type="submit" class="btn btn-primary">{{__("Define service")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('select#service_unit').on('change', () => {
            var selectedVal = $('select#service_unit>option:selected').data();
            var servicesExt = selectedVal.services.split(',');
            $('[name^="services"]').prop('checked', false)
            servicesExt.forEach((v, i) => {
                $('[name="services[' + v + ']"]').prop('checked', true)
            })
            $('[name="name"]').val(selectedVal.name)
            $('[name="days"]').val(selectedVal.days)
            $('[name="downs"]').val(selectedVal.downs)
            $('[name="max"]').val(selectedVal.max)
        })
    </script>
@endsection
