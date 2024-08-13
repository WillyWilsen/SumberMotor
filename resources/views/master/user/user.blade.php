@extends('adminlte::page')
@section('title', 'Item')

@section('content_header')
    <div class="container-fluid">
        <h1>Item</h1>

    </div>
@stop

@section('content')
    <div>
        <div class="card w-100">
            {{-- add button  align right --}}
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('master.user.create') }}">
                        <button class="btn btn-primary">Add</button>
                    </a>
                    {{-- <form action="{{ route('master.user.import') }}" method="POST" enctype="multipart/form-data">
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
                            <th>Email</th>
                            <th>Role</th>
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                ajax: "{{ route('master.user.list') }}",
                columns: columns,
            });
        }


        $(function() {
            initDatatables()
        });
    </script>
    @include('js_template.delete', [
        'deleteRoute' => route('master.user.delete', ':id'),
    ])
    {{-- @include('js_template.csv', [
        'importRoute' => route('master.user.import'),
    ]) --}}
@stop
