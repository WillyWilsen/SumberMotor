@php 
$status_msg = "";
$status_css = "";

if (session()->has("success")) {
    $status_msg = session()->get("success");
    $status_css = "alert-success";
    session()->forget('success');
}

if (session()->has("error")) {
    $status_msg = session()->get("error");
    $status_css = "alert-danger";
    session()->forget('error');
}
@endphp

<style>
    .select2-selection--single {
        height: 100% !important;
    }
    .select2-selection__rendered{
        word-wrap: break-word !important;
        text-overflow: inherit !important;
        white-space: normal !important;
    }
    input{
        /* width: 100% !important; */
    }
    select{
        /* width: 100% !important; */
    }
</style>
@if($status_msg != "")
<div class="alert {{ $status_css }} alert-dismissible fade show mb-2" role="alert">
  {!! $status_msg !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-2">
        Oops, please check that :
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    function goBack() {
        sessionStorage.setItem("back", "1");
        window.history.back();
    }
    window.onpopstate = function() {
        sessionStorage.setItem("back", "1");
    }
</script>