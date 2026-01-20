@extends('layouts.admin-master')

@section('title')
    Ödeme Başarılı
@endsection

@section('content')
    <section class="section text-center">
        <div class="section-header">
            <h1>Ödeme Başarılı</h1>
        </div>
            <div class="alert alert-success p-4">
                <h5>Ödeme başarıyla gerçekleştirildi.</h5>
                <p>Satın aldığınız ürün hesabınıza eklendi.</p>
                <i class="fa fa-check fa-8x"></i>
            </div>
    </section>
@endsection
