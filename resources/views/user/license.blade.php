@extends('layouts.SolarTheme')

@section('title')
    {{__("Lisans Merkezi")}}
@endsection

@section('content')
    <div class="col-sm-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">{{__("Lisans İndir")}} <div class="badge badge-success"></div></h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->locale=='tr')
                    <div class="alert alert-warning">
                        <b>
                            Sistemimizin 4. versiyona geçmesiyle birlikte lisans indirme alanı tamamen özel ve benzersiz
                            bir alan haline gelmiştir.
                            <br>
                            Desteklenen Lisans İndirmeleri;
                            <br>
                            <br>
                            <i class="fa fa-square-check text-success"></i> Envato Elements (Tümü)
                            <br>
                            <i class="fa fa-square-check text-success"></i> Freepik Vektör, Görsel ve AI Görsel
                            <br>
                            <i class="fa fa-square-check text-success"></i> Motion Array (Tümü)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> ShutterStock (Tümü)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> Flaticon (Tümü)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> Freepik Video & Icon


                        </b>
                    </div>
                    <div class="alert alert-warning">
                        <small>İçeriği yeni indirdiyseniz 1,2 dakika içinde lisans dosyası oluşturulur.</small>
                        <br>
                        <b>
                            Lisansını indirmek istediğiniz içeriğin bağlantısını girin.
                            <br>
                            Aşağıdaki alana hizmetlerimizden herhangi birinin linkini girerek bir lisans indirebilirsiniz.
                        </b>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <b>
                            With the upgrade of our system to version 4, the licence download area is completely private and unique. has become a field.
                            <br>
                            Supported Licence Downloads;
                            <br>
                            <br>
                            <i class="fa fa-square-check text-success"></i> Envato Elements (All)
                            <br>
                            <i class="fa fa-square-check text-success"></i> Freepik Vector, Photo and AI Image
                            <br>
                            <i class="fa fa-square-check text-success"></i> Motion Array (All)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> ShutterStock (All)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> Flaticon (All)
                            <br>
                            <i class="fa fa-square-xmark text-danger"></i> Freepik Video & Icon

                        </b>
                    </div>
                    <div class="alert alert-warning">
                        <small>In 1,2 minutes the licence file is created if you have just downloaded the content.</small>
                        <br>
                        <b>
                            Enter the link of the content you want to download the licence for.
                            <br>
                            You can download a licence by entering the link of any of our services in the field below.
                        </b>
                    </div>
                @endif

                <div class="d-flex">
                    <input type="text" class="form-control border border-success rounded-0" id="licenseCenter_url">
                    <button class="btn btn-success w-25 rounded-0" id="licenseCenter_down">{{__('Create Link')}}</button>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#licenseCenter_down').click(() => {
            if(!$('#licenseCenter_url').val()){
                return false;
            }
            swal.fire({
                title: '{{__("Now loading")}}',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            })
            $.post('<?= route('api.licenseCenter') ?>', {
                type: 'file',
                url: $('#licenseCenter_url').val(),
                token_: $('meta[name="csrf-token"]').attr('content')
            }).done((response) => {
                console.log(response)
                if (response.success) {
                    swal.fire({
                        title: '',
                        html: '<a class="btn btn-success" id="downloadLinkButton" href="' + response.url + '" target="_blank">{{__("Click For Download")}}</a>',
                        icon: 'success'
                    })
                    window.open(response.url)
                    $('#licenseCenter_url').val("")
                } else {
                    swal.fire({
                        title: '{{__("Error")}}',
                        html: '{{__("An unknown error has occurred, please try again later.")}}<br><br>' + response.error,
                        icon: 'warning'
                    })
                }
            }).fail(() => {
                swal.fire({
                    title: '{{__("Error")}}',
                    html: '{{__("An unknown error has occurred, please try again later.")}}',
                    icon: 'warning'
                })
            });
        })
    </script>
@endsection
