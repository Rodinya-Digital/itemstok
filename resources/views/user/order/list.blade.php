@extends('layouts.SolarTheme')

@section('title')
    {{__("Orders")}}
@endsection

@section('content')
    <div class="card p-4">
            <div class="table table-striped gy-5 gs-7">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{__("ID")}}</th>
                        <th>{{__("Product")}}</th>
                        <th>{{__("Price")}}</th>
                        <th>{{__("Status")}}</th>
                        <th>{{__("Date")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><b>{{$order->id}}</b></td>
                           @if($order->type=='service')
                                <td class="font-weight-600">{{unserialize($order->product)['name']}}</td>
                            @else
                                <td class="font-weight-600">{{$order->name}}</td>
                           @endif
                            <td><b>{{number_format($order->price,2)}} ₺</b></td>
                            <td>
                                {{$order->gateway}}
                                <div class="badge badge-{{$order->status==0 ? 'secondary' : ($order->status==1?'success':'danger')}}">
                                    {{$order->status==0 ? __("No Payment Made") : ($order->status==1?__("Payment Successful"):__("Payment Failed"))}}
                                </div>
                            </td>
                            <td>{{$order->payment_date?:$order->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
