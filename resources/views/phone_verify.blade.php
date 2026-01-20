@extends('layouts.admin-master')

@section('title')
    Telefon Doğrulama
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Telefon Doğrulama</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="card-body">
                            <b>{{Auth::user()->phone}} Telefon numarasına doğrulama kodu gönderilecektir.</b>
                            <b class="text-success">Doğrulama kodunuz Whatsapp üzerinden gönderilecektir.</b>
                            <div class="input-group mb-3 mt-2">
                                <input id="phone_verify_code" type="text" class="form-control" placeholder="Doğrulama Kodunu Giriniz">
                                <div class="input-group-append">
                                    <button id="phone_verify_button" class="btn btn-success" type="button">Doğrula</button>
                                </div>
                            </div>
                            <div class="input-group">
                                <button id="phone_verify_code_send" type="button" class="btn btn-primary btn-sm">Doğrulama kodu gönder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
