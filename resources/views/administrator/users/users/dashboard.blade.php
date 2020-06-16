@extends('administrator.default')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"><example-component></example-component></div>
            <div class="col-12"><authorized-clients-component></authorized-clients-component></div>
        </div>
    </div>
</section>
@endsection
