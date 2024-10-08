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

            @include('alert')
            <div class="row mb-3">
                <div class="col-12 ">
                    <h5>Stock Data</h5>
                </div>
            </div>
            {{-- <div class="row">
                <x-adminlte-input value="{{ $detail['id'] }}" name="id" label="Stock ID"
                    fgroup-class="col-md-6 col-sm-12" disabled />
            </div> --}}
            <div class="row">
                <x-adminlte-select value="{{ $detail['item_id'] }}" name="item_id" label="Item"
                    fgroup-class="col-md-6 col-sm-12" class="select2" disabled >
                    <option value="">Choose Item</option>
                    @foreach ($list_item as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $detail['item_id'] ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-adminlte-select>
                
                <x-adminlte-input value="{{ $detail['quantity'] }}" name="quantity" label="Quantity"
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
