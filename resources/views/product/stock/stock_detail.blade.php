@extends('adminlte::page')

@section('title', 'Detail Stock')


@section('content_header')
    {{-- back button --}}
    <h1>Stock Detail</h1>

@stop

@section('content')
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="id_stock" value="{{ $detail['id'] }}">
        <div class="card px-3 py-3">

            <div class="row mb-3">
                <div class="col-12 ">
                    <h5>Stock Data</h5>
                </div>
            </div>
            <div class="row">
                <x-adminlte-input value="{{ $detail['id'] }}" name="id" label="Stock ID"
                    fgroup-class="col-md-6 col-sm-12" disabled />
            </div>
            <div class="row">
                <x-adminlte-input value="{{ $detail['product_name'] }}" name="product_name" label="Product Name"
                    fgroup-class="col-md-6 col-sm-12" />

                <x-adminlte-input value="{{ $detail['current_stock'] }}" name="current_stock" label="Current Stock"
                    fgroup-class="col-md-6 col-sm-12" />

                <x-adminlte-input value="{{ $detail['total_stock'] }}" name="total_stock" label="Total Stock"
                    fgroup-class="col-md-6 col-sm-12" />
                
                <x-adminlte-input value="{{ $detail['code'] }}" name="code" label="Code"
                    fgroup-class="col-md-6 col-sm-12" />

                <x-adminlte-input value="{{ $detail['sell_price'] }}" name="sell_price" label="Sell Price"
                    fgroup-class="col-md-6 col-sm-12" />
            </div>

            <div class="row justify-content-end">

                {{-- back button --}}
                <x-adminlte-button class="btn-flat mr-3" onclick="history.back()" label="Back" theme="primary"
                    icon="fas fa-md fa-arrow-left" />
                <x-adminlte-button class="btn-flat" type="submit" label="Save" theme="success" icon="fas fa-md fa-save"
                    id="save" />
                {{-- <div class="col">
                </div> --}}
            </div>
        </div>
    </form>

@stop

@section('js')
    <script></script>
@stop
