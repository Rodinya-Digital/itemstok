@extends('layouts.SolarTheme')

@section('title')
    {{__("Edit Profile")}} ({{ $user->name .' '.$user->surname }})
@endsection

@section('content')
    <form action="{{route('panel.users.update',$user->id)}}" method="post" class="card">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Name')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" name="name" value="{{$user->name}}"
                           placeholder="{{__('Name')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Surname')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" name="surname" value="{{$user->surname}}"
                           class="form-control" placeholder="{{__('Surname')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Balance')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" name="balance" value="{{number_format($user->balance,2)}}"
                           class="form-control" placeholder="{{__('Balance')}}">
                </div>
            </div>
            {{--<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Username')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" name="username" value="{{$user->username}}"
                           class="form-control" placeholder="{{__('Username')}}" oninput="validateUsername(this)">
                    <div id="error-message" style="display: none" class="mt-1 alert alert-danger"></div>
                </div>
            </div>--}}
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Email')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" name="email"
                           @if(!request()->user()->can('edit-users')) disabled @endif value="{{$user->email}}"
                           placeholder="{{__('Email')}}">
                </div>
            </div>

            @if(!$user->isme && request()->user()->can('edit-users'))
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Status')}}</label>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control" name="status">
                            <option @if($user->status==1) selected @endif value="1">{{__('Active')}}</option>
                            <option @if($user->status==2) selected @endif value="2">{{__('Passive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Phone')}}</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" name="phone" value="{{$user->phone}}"
                               placeholder="{{__('Phone')}}">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Type')}}</label>
                    <div class="col-sm-12 col-md-7">
                        <select class="form-control" name="role">
                            <option @if($user->roles[0]->id==2) selected @endif value="2">User</option>
                            <option @if($user->roles[0]->id==1) selected @endif value="1">Admin</option>
                        </select>
                    </div>
                </div>
            @endif

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Current Password')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="password" name="current_password"
                           class="form-control" placeholder="{{__('Current Password')}}"><small
                            class="text-danger">{{__('You must enter a password to change the account details.')}}</small>
                </div>
            </div>

            <h3 class="fs-5">{{__('To change your password, enter your new password in the field below.')}}</h3>
            <hr>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Password')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="password" name="password"
                           class="form-control" placeholder="{{__('Password')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Password Repeat')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{__('Password Repeat')}}">

                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        function validateUsername(input) {
            const invalidChars = input.value.match(/[^a-zA-Z0-9çğıöşüÇĞİÖŞÜ-]/g);
            if (invalidChars) {
                document.getElementById('error-message').textContent = `{{__('Invalid')}}: ${invalidChars.join(', ')}`;
                document.getElementById('error-message').style.display = 'block'
                input.value = input.value.replace(/[^a-zA-Z0-9çğıöşüÇĞİÖŞÜ-]/g, '');
            } else {
                document.getElementById('error-message').textContent = '';
                document.getElementById('error-message').style.display = 'none'
            }
        }
    </script>
@endsection
