@extends('layouts.SolarTheme')

@section('title')
    {{__("Edit Service")}}
@endsection
@section('topbuttons')
    <a href="{{ route('panel.services.create') }}" class="btn btn-primary">{{__("Add New Service")}}</a>
@endsection
@section('content')

    <div class="card p-4">
        <form class="row" action="{{route('panel.services.update',$service->id)}}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="col-lg-9 col-md-9 col-12 col-sm-12">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Service Name")}}</span>
                    </div>
                    <input type="text" class="form-control" name="name" value="{{$service->name}}" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Service Name")}} EN</span>
                    </div>
                    <input type="text" class="form-control" name="name_en" value="{{$service->name_en}}" required>
                </div>
                <div class="mb-3">
                    <span class="input-group-text w-100 mb-2">{{__("Description")}}</span>
                    <textarea name="desc" id="kt_docs_ckeditor_classic">{{$service->desc}}</textarea>
                </div>
                <div class="mb-3">
                    <span class="input-group-text w-100 mb-2">{{__("Description")}} EN</span>
                    <textarea name="desc_en" id="kt_docs_ckeditor_classic2">{{$service->desc_en}}</textarea>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-12 col-sm-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Custom Sort")}}</span>
                    </div>
                    <input type="text" class="form-control" name="order" value="{{$service->order}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Service Time (Days)")}}</span>
                    </div>
                    <input type="number" class="form-control" name="days" placeholder="30" value="{{$service->days}}"
                           required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Download Quota (Days)")}}</span>
                    </div>
                    <input type="number" class="form-control" name="downs" value="{{$service->downs}}" placeholder="10"
                           required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Max Download Quota (Preiod)")}}</span>
                    </div>
                    <input type="number" class="form-control" name="max" value="{{$service->max}}" placeholder="10"
                           required>
                </div>
                <label class="mt-2">{{__("Download permissions")}}</label>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[shutterstock]"
                           class="form-check-input h-20px w-30px" {{in_array('shutterstock',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("ShutterStock")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[adobestock]"
                           class="form-check-input h-20px w-30px" {{in_array('adobestock',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Adobe Stock")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[freepik]"
                           class="form-check-input h-20px w-30px" {{in_array('freepik',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Freepik")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[flaticon]"
                           class="form-check-input h-20px w-30px" {{in_array('flaticon',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Flaticon")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[epidemicsound]"
                           class="form-check-input h-20px w-30px" {{in_array('epidemicsound',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Epidemic Sound")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                    <input type="checkbox" name="services[envatoelements]"
                           class="form-check-input h-20px w-30px" {{in_array('envatoelements',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Envato Elements")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                    <input type="checkbox" name="services[motionarray]"
                           class="form-check-input h-20px w-30px" {{in_array('motionarray',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Motion Array")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                    <input type="checkbox" name="services[motionelements]"
                           class="form-check-input h-20px w-30px" {{in_array('motionelements',$service->services)?'checked':''}}>
                    <label class="form-check-label">{{__("Motion Elements")}}</label>
                </div>
                <small>{{__("Price writing example: 5 or 4.99 (with dots)")}}</small>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Price")}}</span>
                    </div>
                    <input type="text" class="form-control" name="price" value="{{$service->price}}" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">{{__("Status")}}</label>
                    </div>
                    <select class="form-control" id="status" name="status" required>
                        <option value="" selected>{{__("Select broadcast status")}}</option>
                        <option value="1" @if($service->status==1) selected @endif>{{__("Published")}}</option>
                        <option value="2"
                                @if($service->status==2) selected @endif>{{__("Not Published (Draft)")}}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{__("Update")}}</button>


            </div>
        </form>
    </div>

@endsection

