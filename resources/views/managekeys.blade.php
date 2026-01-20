@extends('layouts.SolarTheme')

@section('title')
    {{__("Manage Keys")}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__("Manage Keys")}} {!!request()->list?' | <b>#'.request()->list.'</b> '.__("Key List"):''  !!}</h1>
        </div>
        <div class="row">

            <form class="col-lg-3 col-md-3 col-12" action="{{route('panel.managekeys.store')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="text-center p-2">
                        <h5>{{__("Create Keys")}}</h5>
                    </div>
                    <div class="card-body border-top">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("Key Group Nickname")}}</span>
                            </div>
                            <input type="text" class="form-control" name="name">
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("Dealer UserID")}}</span>
                            </div>
                            <input type="number" class="form-control" name="owner" placeholder="10" >
                        </div>
                        <label class="mt-2">{{__("Download permissions")}}</label>
                        <div class="input-group mb-2">
                            <label class="custom-switch  p-0">
                                <input type="checkbox" name="services[freepik]" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">{{__("Freepik")}}</span>
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("Piece")}}</span>
                            </div>
                            <input type="text" class="form-control" name="piece" required>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn btn-success w-100">{{__('Create')}}</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-12 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4>{!! request()->list?$keys[0]->name .' '.__("Key List").'<br><small>'.__("Piece").' : '.\App\Managekey::where('name','=',$keys[0]->name)->where('usedby', '=', NULL)->count().'<br>'.__("Download Quota (Days)").' : '.$keys[0]->downs.'<br>'.__("Max Download Quota (Preiod)").' : '.$keys[0]->max.'<br>'.__("Service Time (Days)").' : '.$keys[0]->days.'<br>'.__("Download permissions").' :'.mb_strtoupper(implode(',',$keys[0]->services)).'</small><br><button id="copyallbuttonkeys" class="btn btn-success rounded" data-clipboard-text="">
                            <i class="fa fa-copy"></i> '.__("Copy All Keys").'
                        </button>':__("Key List") !!}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                <tr>
                                    <th>{{__("ID")}}</th>
                                    <th>{{request()->list?__("Key"):__("Name")}}</th>
                                    <th>{{__("Creation Date")}}</th>
                                    <th>{{__("Action")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keys as $key)
                                    <tr>
                                        <td>{{$key->id}}</td>
                                        <td{{request()->list?' id=srttr_key':''}}>{!! !request()->list?$key->name.'<br><small>'.__("Piece").' : '.\App\Managekey::where('name','=',$key->name)->where('usedby', '=', NULL)->count().'<br>'.__("Download Quota (Days)").' : '.$key->downs.'<br>'.__("Max Download Quota (Preiod)").' : '.$key->max.'<br>'.__("Service Time (Days)").' : '.$key->days.'<br>'.__("Download permissions").' :'.mb_strtoupper(implode(',',$key->services)).'</small>':$key->key !!}</td>
                                        <td>{{$key->created_at}}</td>
                                        @if(request()->list)
                                            <script>
                                                document.querySelector('#copyallbuttonkeys').dataset.clipboardText+='{{$key->key}}\n'
                                            </script>
                                            <td>
                                                <form id="item_delete_{{$key->id}}"
                                                      action="{{route('panel.managekeys.destroy',$key->id)}}"
                                                      method="post"
                                                      class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-danger btn-action" id="item_delete"
                                                            data-item="{{$key->id}}"
                                                            data-toggle="tooltip" title="{{__("Delete Permanently")}}"
                                                            type="button">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @else
                                            <td><a href="{{route("panel.managekeys.index",['list'=>$key->name])}}"
                                                   class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
    <script>
        new ClipboardJS('#copyallbuttonkeys')
    </script>
@endsection
