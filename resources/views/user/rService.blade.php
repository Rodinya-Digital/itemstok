<div class="row g-5 g-xl-8">
    <div class="col-xl-3">

        <!--begin::Statistics Widget 5-->
        <div class="card bg-primary hoverable card-xl-stretch mb-xl-8">
            <!--begin::Body-->
            <div class="card-body">


                <div class="text-white fw-bold fs-5">
                    {{$downs}}
                </div>

                <div class="fw-semibold text-white">
                    {{__("Remaining Daily Download")}}
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Statistics Widget 5-->
    </div>
    <div class="col-xl-3">

        <!--begin::Statistics Widget 5-->
        <div class="card bg-success hoverable card-xl-stretch mb-xl-8">
            <!--begin::Body-->
            <div class="card-body">

                <div class="text-white fw-bold fs-5">
                    {{\Carbon\Carbon::create($expDAte)->diffForHumans(\Carbon\Carbon::now(),['parts'=>2])}}
                </div>

                <div class="fw-semibold text-white">
                    {{__("Service End Date")}}
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Statistics Widget 5-->
    </div>
    <div class="col-xl-3">

        <!--begin::Statistics Widget 5-->
        <div class="card bg-warning hoverable card-xl-stretch mb-xl-8">
            <!--begin::Body-->
            <div class="card-body">


                <div class="text-white fw-bold fs-5">
                    {{$maxp->total}}/{{$maxp->max}}
                </div>

                <div class="fw-semibold text-white">
                    {{__("Max Download Quota (Preiod)")}}
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Statistics Widget 5-->
    </div>
    <div class="col-xl-3">

        <!--begin::Statistics Widget 5-->
        <div class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Body-->
            <div class="card-body">

                <div class="text-white fw-bold fs-5">
                    {{$allDowns}}
                </div>

                <div class="fw-semibold text-white">
                    {{__("Total Downloads")}}
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Statistics Widget 5-->
    </div>
</div>