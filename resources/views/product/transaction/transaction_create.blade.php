@extends('adminlte::page')

@section('title', 'Add Transaction')


@section('content_header')
    {{-- back button --}}
    <h1>Add Transaction</h1>

@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            line-height: 36px;
            padding: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding: 4px 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            line-height: 36px;
        }
    </style>
@stop

@section('content')
    <form method="POST">
        @csrf
        <div class="card px-3 py-3">

            @include('alert')
            <div class="row mb-3">
                <div class="col-12 ">
                    <h5>Transaction Data</h5>
                </div>
            </div>
            <div class="row">
                <x-adminlte-select name="item_id" label="Item" fgroup-class="col-md-6 col-sm-12" class="select2">
                      <option value="">Choose Item</option>
                      @foreach ($list_item as $item)
                          <option value="{{ $item->id }}">
                              {{ $item->name }}
                          </option>
                      @endforeach
                </x-adminlte-select>
                <x-adminlte-input name="quantity" label="Quantity" fgroup-class="col-md-6 col-sm-12" />
                <x-adminlte-input name="total_price" label="Total Price" fgroup-class="col-md-6 col-sm-12" />

            </div>

            <div class="row justify-content-end">

                <x-adminlte-button class="btn-flat mr-3" onclick="history.back()" label="Back" theme="primary"
                    icon="fas fa-md fa-arrow-left" />
                <x-adminlte-button class="btn-flat" type="submit" label="Save" theme="success" icon="fas fa-md fa-save"
                    id="save" />
            </div>
        </div>
    </form>

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@stop