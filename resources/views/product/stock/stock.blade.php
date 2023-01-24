@extends('adminlte::page')
@section('title', 'Stock')

@section('content_header')
    <div class="container-fluid">
        <h1>Stock</h1>

    </div>
@stop

@section('content')
    <div>
        <div class="card w-100">
            {{-- add button  align right --}}
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('product.stock.create') }}"><button class="btn btn-primary">Add</button></a>
                    {{-- <form action="{{ route('product.stock.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf --}}
                    {{-- <div style="display: none;">
                        <x-adminlte-input-file id="csv_upload" name="file" onchange="importExcel(this.files[0])" />
                    </div>
                    <button type="button" onclick="$('#csv_upload').click();" class="btn btn-primary">Import Excel
                    </button> --}}
                    {{-- </form> --}}
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Current Stock</th>
                            <th>Total Stock</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop


@section('js')
    <script>
        // setup ajax csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'current_stock',
                name: 'current_stock'
            },
            {
                data: 'total_stock',
                name: 'total_stock'
            },
            {
                data: 'buy_price',
                name: 'buy_price'
            },
            {
                data: 'sell_price',
                name: 'sell_price'
            },
            {
                data: 'action',
                name: 'action'
            },
        ]

        function refreshDatatable() {
            $('.datatable').DataTable().ajax.reload();
        }

        function initDatatables() {

            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('product.stock.list') }}",
                columns: columns,
            });
        }


        $(function() {
            initDatatables()
        });
    </script>
    @include('js_template.delete', [
        'deleteRoute' => route('product.stock.delete', ':id'),
    ])
    {{-- @include('js_template.csv', [
        'importRoute' => route('product.stock.import'),
    ]) --}}
@stop
