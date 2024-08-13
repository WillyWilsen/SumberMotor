@extends('adminlte::page')

@section('title', 'Detail User')


@section('content_header')
    {{-- back button --}}
    <h1>User Detail</h1>

@stop

@section('content')
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="id_user" value="{{ $detail['id'] }}">
        <div class="card px-3 py-3">

            @include('alert')
            <div class="row mb-3">
                <div class="col-12 ">
                    <h5>User Data</h5>
                </div>
            </div>
            {{-- <div class="row">
                <x-adminlte-input value="{{ $detail['id'] }}" name="id" label="Item ID"
                    fgroup-class="col-md-6 col-sm-12" disabled />
            </div> --}}
            <div class="row">
                <x-adminlte-input value="{{ $detail['name'] }}" name="name" label="Name"
                    fgroup-class="col-md-6 col-sm-12" />
                
                <x-adminlte-input value="{{ $detail['email'] }}" name="email" label="Email"
                    fgroup-class="col-md-6 col-sm-12" />

            </div>

            <div class="row">
                <x-adminlte-input name="password" label="Password" type="password" fgroup-class="col-md-6 col-sm-12" />
            </div>
            
            <div class="row">
                <x-adminlte-input name="confirm_password" label="Confirm Password" type="password" fgroup-class="col-md-6 col-sm-12" />
            </div>

            <div class="row">
                <x-adminlte-select value="{{ $detail['role'] }}" name="role" label="Role"
                    fgroup-class="col-md-6 col-sm-12" class="select2" >
                    @foreach ($list_role as $role)
                        <option value="{{ $role->name }}" {{ $role->name == $detail['role'] ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-adminlte-select>
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
