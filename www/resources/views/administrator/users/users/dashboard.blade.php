@extends('administrator.default')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"><example-component></example-component></div>
            <div class="col-12"><authorized-clients-component></authorized-clients-component></div>
            <div class="col-12"><clients-component></clients-component></div>
            <div class="col-12"><personal-access-tokens-component></personal-access-tokens-component></div>
        </div>
    </div>
</section>
@endsection
