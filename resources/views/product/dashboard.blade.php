@extends('adminlte::page')
@section('title', 'Product Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <h1>Dashboard</h1>

        </div>
        {{-- <div class="row justify-content-end mt-3">

            <button onclick="onDeleteAllClick()" type="button" class="btn btn-danger mr-2">Delete all
            </button>
            <a target="_blank" href="{{ route('respond.csv_backup') }}" class="btn btn-primary">Export all data</a>

            <a target="_blank" href="{{ route('respond.csv_example') }}" class="btn btn-primary ml-2">Download CSV Example</a>
        </div> --}}
        {{-- <div class="row mt-5">
            <h4>Data Summary</h4>
        </div>
        <div class="row mt-2">
            <x-dashboard-card backgroundColor="bg-light" :total="$count_region" title="Region" />
            <x-dashboard-card backgroundColor="bg-light" :total="$count_country" title="Country" />
            <x-dashboard-card backgroundColor="bg-light" :total="$count_bank" title="Bank" />
            <x-dashboard-card backgroundColor="bg-light" :total="$count_indicator_answer" title="Indicator Answer" />

        </div> --}}
    </div>
@stop

@section('content')

@stop


@section('js')

    {{-- @include('js_template.ajax_setup')
    <script>
        function customDeleteHook() {
            location.reload()
        }
    </script>
    @include('js_template.delete_all', [
        'deleteAllRoute' => route('respond.database.purge'),
        'modalMessage' => 'Resetting data will delete all the current data.',
    ]) --}}
@endsection
