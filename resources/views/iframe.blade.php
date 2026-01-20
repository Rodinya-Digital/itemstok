@extends('layouts.FrontV1-master')

@section('title')
    {{__("Store")}}
@endsection

@section('content')
    <iframe src="{{$url}}" style="width: 100%;height: 100%;border: none;"></iframe>
@endsection
