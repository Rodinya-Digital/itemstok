@extends('layouts.SolarTheme')

@section('title')
    {{__("Add Service")}}
@endsection

@section('content')
    <div class="card p-4">
        <form class="row" action="{{route('panel.services.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="col-lg-9 col-md-9 col-12 col-sm-12">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Service Name")}}</span>
                    </div>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Service Name")}} EN</span>
                    </div>
                    <input type="text" class="form-control" name="name_en" required>
                </div>

                <div class=" mb-3">
                    <span class="input-group-text w-100 mb-2">{{__("Description")}}</span>
                    <textarea name="desc" id="kt_docs_ckeditor_classic" class="w-100" style="width: 100%"></textarea>
                </div>
                <div class=" mb-3">
                    <span class="input-group-text w-100 mb-2">{{__("Description")}} EN</span>
                    <textarea name="desc_en" id="kt_docs_ckeditor_classic2" class="w-100" style="width: 100%"></textarea>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-12 col-sm-12">


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Custom Sort")}}</span>
                    </div>
                    <input type="text" class="form-control" name="order">
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
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[shutterstock]" class="form-check-input h-20px w-30px" >
                    <label class="form-check-label">{{__("ShutterStock")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[adobestock]" class="form-check-input h-20px w-30px" >
                    <label class="form-check-label">{{__("Adobe Stock")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                        <input type="checkbox" name="services[freepik]" class="form-check-input h-20px w-30px" >
                        <label class="form-check-label">{{__("Freepik")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[flaticon]" class="form-check-input h-20px w-30px" >
                    <label class="form-check-label">{{__("Flaticon")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2 mt-2">
                    <input type="checkbox" name="services[epidemicsound]" class="form-check-input h-20px w-30px" >
                    <label class="form-check-label">{{__("Epidemic Sound")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <input type="checkbox" name="services[envatoelements]" class="form-check-input h-20px w-30px">
                        <label class="form-check-label">{{__("Envato Elements")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <input type="checkbox" name="services[motionarray]" class="form-check-input h-20px w-30px">
                        <label class="form-check-label">{{__("Motion Array")}}</label>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                        <input type="checkbox" name="services[motionelements]" class="form-check-input h-20px w-30px">
                        <label class="form-check-label">{{__("Motion Elements")}}</label>
                </div>
                <small>{{__("Price writing example: 5 or 4.99 (with dots)")}}</small>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__("Price")}}</span>
                    </div>
                    <input type="text" class="form-control" name="price" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="product_status">{{__("Status")}}</label>
                    </div>
                    <select class="form-control" id="product_status" name="status" required>
                        <option value="" selected>{{__("Select broadcast status")}}</option>
                        <option value="1">{{__("Published")}}</option>
                        <option value="2">{{__("Not Published (Draft)")}}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">{{__("Save")}}</button>

            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
      /*  ClassicEditor
            .create( document.querySelector( '#kt_docs_ckeditor_classic' ) )
            .catch( error => {
                console.error( error );
            } );
        ClassicEditor
            .create( document.querySelector( '#kt_docs_ckeditor_classic2' ) )
            .catch( error => {
                console.error( error );
            } );*/
    </script>
@endsection
