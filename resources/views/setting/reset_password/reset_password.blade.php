@extends('adminlte::page')

@section('title', 'Reset Password')


@section('content_header')
    {{-- back button --}}
    <h1>Reset Password</h1>

@stop

@section('content')
    <form method="POST">
        @csrf
        <div class="card px-3 py-3">

            @include('alert')
            <div class="row mb-3">
                <div class="col-12 ">
                    <h5>Reset Password</h5>
                </div>
            </div>
            <div class="row">
                <x-adminlte-input name="current_password" label="Current Password" type="password" fgroup-class="col-md-6 col-sm-12" />
            </div>
            <div class="row">
                <x-adminlte-input name="new_password" label="New Password" type="password" fgroup-class="col-md-6 col-sm-12" />
            </div>
            <div class="row">
                <x-adminlte-input name="confirm_password" label="Confirm Password" type="password" fgroup-class="col-md-6 col-sm-12" />
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
    <script></script>
@stop
