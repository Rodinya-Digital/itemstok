@extends('layouts.SolarTheme')

@section('title')
    {{__("Services")}}
@endsection
@section('topbuttons')
    <a href="{{ route('panel.services.create') }}" class="btn btn-primary">{{__("Add Service")}}</a>
@endsection
@section('content')
    <div class="card p-4">
        <table class="table table-striped gy-5 gs-7">
            <thead>
            <tr>
                <th>{{__("ID")}}</th>
                <th>{{__("Name")}}</th>
                <th>{{__("Custom Sort")}}</th>
                <th>{{__("Status")}}</th>
                <th>{{__("Price")}}</th>
                <th>{{__("Creation Date")}}</th>
                <th>{{__("Updated Date")}}</th>
                <th>{{__("Action")}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{$service->id}}</td>
                    <td>{{$service->name}}</td>
                    <td>{{$service->order?:''}}</td>
                    @if($service->status==1)
                        <td><span class="badge badge-light-success">{{__("Published")}}</span></td>
                    @elseif($service->status==2)
                        <td><span class="badge badge-danger">{{__("Not Published (Draft)")}}</span></td>
                    @endif
                    <td>{{$service->price}} ₺</td>
                    <td>{{$service->created_at}}</td>
                    <td>{{$service->updated_at}}</td>
                    <td>
                        <a href="{{route('panel.services.edit',$service->id)}}"
                           class="btn btn-sm btn-light-primary mr-1" data-toggle="tooltip"
                           title="Düzenle">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form id="item_delete_{{$service->id}}"
                              action="{{route('panel.services.destroy',$service->id)}}"
                              method="post"
                              class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-sm btn-light-danger" id="item_delete"
                                    data-item="{{$service->id}}"
                                    data-toggle="tooltip" title="Kalıcı Olarak Sil" type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
