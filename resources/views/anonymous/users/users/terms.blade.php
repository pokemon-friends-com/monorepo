@extends('default')

@section('title', $metadata['title'])
@section('description', $metadata['description'])

@section('content')
<nav class="bg-white border-bottom" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('anonymous.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('users.terms') }}</li>
        </ol>
    </div>
</nav>
{{--<section class="d-flex align-items-center pb-0 pb-lg-4 pt-lg-6 px-1 px-md-0">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col"><h1 class="font-weight-bold mb-0 mb-md-3">{{ trans('users.terms') }}</h1>--}}
{{--                <p class="mb-0 d-none d-md-block">Depending acuteness dependent eat use dejection. Unpleasing astonished discovered not nor shy.<br>Morning hearted now met yet beloved evening.</p></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
<section class="pt-lg-5 pb-lg-6 px-1 px-md-0">
    <div class="container">
        <div class="row">
            <div class="col">
                {!! trans('users.terms-of-services', ['home_url' => route('anonymous.dashboard'), 'contact_url' => config('services.github.issues')]) !!}
            </div>
        </div>
    </div>
</section>
@endsection
