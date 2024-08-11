@extends('adminlte::page')
@section('title', 'Log')

@section('content_header')
    <div class="container-fluid">
        <h1>Log</h1>

    </div>
@stop

@section('content')
    <div>
        <div class="card w-100">
            {{-- add button  align right --}}
            <div class="card-header">
                <div class="float-right">
                    {{-- <a href="{{ route('log.create') }}"><button class="btn btn-primary">Add</button></a> --}}
                    {{-- <form action="{{ route('log.import') }}" method="POST" enctype="multipart/form-data">
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
                            <th>Message</th>
                            <th>Created By</th>
                            <th>Date</th>
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
                data: 'message',
                name: 'message'
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: 'date',
                name: 'date'
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
                ajax: "{{ route('log.list') }}",
                columns: columns,
            });
        }


        $(function() {
            initDatatables()
        });
    </script>
    @include('js_template.delete', [
        'deleteRoute' => route('log.delete', ':id'),
    ])
    {{-- @include('js_template.csv', [
        'importRoute' => route('log.import'),
    ]) --}}
@stop
