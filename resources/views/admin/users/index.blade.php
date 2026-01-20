@extends('layouts.SolarTheme')

@section('title')
{{__("User Management")}}
@endsection
@section('topbuttons')
  <form action="">
    <input type="text" class="form-control w-200px mb-4" name="q" value="{{request()->q}}" placeholder="Kullanıcı Ara...">
  </form>
  <a href="{{ route('panel.users.create') }}" class="btn btn-primary">{{__("Add User")}}</a>
@endsection
@section('content')
  <div class="card p-4">
    <table class="table table-striped gy-5 gs-7">
      <thead>
      <tr>
        <th>{{__("ID")}}</th>
        <th>{{__("Name")}} {{__("Surname")}}</th>
        <th>{{__("Email")}}</th>
        <th>{{__("Status")}}</th>
        <th>{{__("Language")}}</th>
        <th>{{__("Creation Date")}}</th>
        <th>{{__("Action")}}</th>
      </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{$user->id}}</td>
          <td>{{$user->name}} {{$user->surname}}</td>
          <td>{{$user->email}}</td>
          @if($user->status==1)
            <td><span class="badge badge-light-success">{{__("Active")}}</span></td>
          @elseif($user->status==2)
            <td><span class="badge badge-danger">{{__("Passive")}}</span></td>
          @endif
          <td>{{$user->locale}}</td>
          <td>{{$user->created_at}}</td>
          <td>
            <a href="{{route('panel.uservice.user',$user->id)}}"
               class="btn btn-sm btn-light-warning mr-1" data-toggle="tooltip"
               title="Servis Yönetimi">
              <i class="fas fa-user-cog"></i>
            </a>
            <a href="{{route('panel.users.edit',$user->id)}}"
               class="btn btn-sm btn-light-primary mr-1" data-toggle="tooltip"
               title="Düzenle">
              <i class="fas fa-pencil-alt"></i>
            </a>
            <form id="item_delete_{{$user->id}}"
                  action="{{route('panel.users.destroy',$user->id)}}"
                  method="post"
                  class="d-inline">
              @method('delete')
              @csrf
              <button class="btn btn-sm btn-light-danger" id="item_delete"
                      data-item="{{$user->id}}"
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
  {{ $users->links() }}
@endsection
