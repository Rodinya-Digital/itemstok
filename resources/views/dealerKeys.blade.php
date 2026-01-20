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



            <div class="col-12 col-md-12 col-lg-12">
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
                                    @if(request()->list)
                                        <th>{{__('Used By')}}</th>
                                    @endif
                                    <th>{{__("Create Date")}}</th>
                                    <th>{{__("Update Date")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keys as $key)
                                    <tr>
                                        <td>{{$key->id}}</td>
                                        <td{{request()->list?' id=srttr_key':''}}>{!! !request()->list?$key->name.'<br><small>'.__("Piece").' : '.\App\Managekey::where('name','=',$key->name)->where('usedby', '=', NULL)->count().'<br>'.__("Download Quota (Days)").' : '.$key->downs.'<br>'.__("Max Download Quota (Preiod)").' : '.$key->max.'<br>'.__("Service Time (Days)").' : '.$key->days.'<br>'.__("Download permissions").' :'.mb_strtoupper(implode(',',$key->services)).'</small>':$key->key !!}</td>
                                        @if(request()->list)
                                           <td>
                                               @if($key->usedby!==null)
                                               {{__('Used')}} : {{\App\User::find($key->usedby)->email}}
                                               @else
                                                   {{__('Not Used')}}
                                               @endif
                                           </td>
                                        @endif
                                        <td>{{$key->created_at}}</td>
                                        @if(request()->list)
                                            <td>{{$key->updated_at}}</td>
                                            <script>
                                                document.querySelector('#copyallbuttonkeys').dataset.clipboardText+='{{$key->key}}\n'
                                            </script>
                                        @else
                                            <td>{{$key->updated_at}} <a href="{{route("panel.dealerKeys",['list'=>$key->name])}}"
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
