@extends('layouts.SolarTheme')

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
                            <div>
                                &nbsp;&nbsp;|&nbsp;
                                @php
                                    $tUser = \App\User::find($feedback->user_id);
                                @endphp
                                {{$tUser->name.' '.$tUser->surname}}&nbsp;&nbsp;|&nbsp;
                                {{$tUser->email}}&nbsp;&nbsp;|&nbsp;
                                <a target="_blank" href="{{route('panel.uservice.user',$tUser->id)}}"
                                   class="btn btn-sm btn-warning mr-1">
                                    <i class="fas fa-user-cog"></i>
                                </a>&nbsp;&nbsp;|&nbsp;
                                <a target="_blank" href="{{route('panel.users.edit',$tUser->id)}}"
                                   class="btn btn-sm btn-primary mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </h5>

                        <div class="btn-group">
                            <a href="{{route('Feedback-yes',$feedback->id)}}"
                               class="btn btn-sm btn-success mr-1">
                                <i class="fa fa-eye m-0 p-0 text-white"></i>&nbsp;&nbsp;
                                <i class="fa fa-check m-0 p-0 text-white"></i>
                            </a>
                            <a href="{{route('Feedback-no',$feedback->id)}}"
                               class="btn btn-sm btn-warning mr-1">
                                <i class="fa fa-eye m-0 p-0 text-white"></i> &nbsp;&nbsp;
                                <i class="fa fa-times m-0 p-0 text-white"></i>
                            </a>
                            <button class="btn btn-success" onclick='Swal.fire({
  html: `<form method="post" action="{{route('panel.addAnswerFB',$feedback->id)}}">
  @csrf
  <textarea  class="form-control" style="height:250px;background:black;color:white;" name="answer">{{$feedback->answer}}</textarea>
  <button type="submit" class="btn btn-success mt-4 w-100">Cevapla</button>
  </form>
  `,
  width: 1000,
  showConfirmButton: false})'>Cevapla</button>
                            {{-- <a class="btn btn-primary" data-fslightbox
                                href="{{asset('storage/app/'.$feedback->user_info['screenshot'])}}">
                                 {{__('Screenshot')}}
                             </a>--}}
                            <button class="btn btn-primary" onclick='Swal.fire({
  html: `
  <table class="table table-dark table-striped gy-5 gs-7">
  @php
$dataFeed = $feedback->user_info;
  unset($dataFeed['screenshot'])
  @endphp
@foreach($dataFeed as $k=>$v)
<tr>
<th class="w-25">{{$k}}</th>
<th>@if(is_array($v))
{{implode('x',$v)}}
@else
{{$v}}
@if($k=='ip')
<a class="btn btn-primary" target="_blank" href="http://ip-api.com/json/{{$v}}">{{__('Detail')}}</a>
@endif
@if($k=='user')
&nbsp;&nbsp;&nbsp;
<a target="_blank" href="{{route('panel.uservice.user',$v)}}"
               class="btn btn-sm btn-light-warning mr-1">
              <i class="fas fa-user-cog"></i>
            </a>
            <a target="_blank" href="{{route('panel.users.edit',$v)}}"
               class="btn btn-sm btn-light-primary mr-1">
              <i class="fas fa-pencil-alt"></i>
            </a>
@endif
@endif
</th>
</tr>
@endforeach
</table>
  `,
  width: 1000,
  showConfirmButton: false,
});'>{{__('Detail')}}</button>
                        </div>

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