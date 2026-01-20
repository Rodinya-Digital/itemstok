@extends('layouts.SolarTheme')

@section('title')
    {{__("Add User")}}
@endsection

@section('content')
    <form action="{{route('panel.users')}}" method="post" class="card">
        @csrf
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Name')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" name="name" value="{{old('name')}}"
                           placeholder="{{__('Name')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Surname')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" name="surname" value="{{old('surname')}}"
                           class="form-control" placeholder="{{__('Surname')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Email')}}</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" name="email" value="{{old('email')}}"
                           placeholder="{{__('Email')}}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{__('Type')}}</label>
                <div class="col-sm-12 col-md-7">
                    <select class="form-control" name="role">
                        <option value="2">User</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
            </div>
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
                    <input type="password"  name="password_confirmation" class="form-control" placeholder="{{__('Password Repeat')}}">

                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary">{{__("Add User")}}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
