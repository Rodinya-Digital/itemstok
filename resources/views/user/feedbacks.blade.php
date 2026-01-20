@extends('layouts.FrontV1-master')

@section('title')
    {{__("Feedbacks")}}
@endsection

@section('content')

    <div class="row">
        @foreach($feedbacks as $feedback)
        <div class="col-xxl-12 mb-6 order-2 order-xl-0">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i class="ti ti-list-details me-3"></i>
                        {{__('Feedback')}} #{{$feedback->id}}
                    </h5>



                    @if($feedback->reviewed==1)
                        <td><span style="height: 25px;" class="badge badge-success">{{__("Reviewed")}}</span></td>
                    @elseif($feedback->reviewed==0)
                        <td><span style="height: 25px;" class="badge badge-warning">{{__("Not Reviewed")}}</span></td>
                    @endif

                </div>
                <div class="card-body pb-0">
                    <ul class="timeline mb-0">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-3">
                                    <h6 class="mb-0">@if($feedback->type=='like')
                                            <span class="badge badge-success">{{__($feedback->type)}}</span>
                                        @elseif($feedback->type=='dislike')
                                            <span class="badge badge-secondary text-white" style="background-color: rgba(180,124,102,0.69)">{{__($feedback->type)}}</span>
                                        @elseif($feedback->type=='suggestion')
                                            <span class="badge badge-warning">{{__($feedback->type)}}</span>
                                        @elseif($feedback->type=='bug')
                                            <span class="badge badge-danger">{{__($feedback->type)}}</span>
                                        @endif</h6>
                                    <small class="text-muted">{{\Carbon\Carbon::parse($feedback->created_at)->diffForHumans()}}</small>
                                </div>
                                <p class="mb-2">
                                    {{$feedback->message}}
                                </p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-3">
                                    <h6 class="mb-0">
                                        <span class="badge badge-success">{{__('Answer')}}</span>
                                    </h6>
                                    <small class="text-muted">{{\Carbon\Carbon::parse($feedback->updated_at)->diffForHumans()}}</small>
                                </div>
                                <p class="mb-2">
                                    @if($feedback->answer!==null)
                                        {!! $feedback->answer !!}
                                    @else
                                        {{__('No Answer Yet')}}
                                    @endif
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach


    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.js"
            integrity="sha512-2VqLVM3WCyaqUgQb2hpoWHSus021RIN0Jq0wfrLqqLh+anm1kW/H4Yw7HVu3D5W4nbdUQmAA2mqQv2JEoy+kPA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection