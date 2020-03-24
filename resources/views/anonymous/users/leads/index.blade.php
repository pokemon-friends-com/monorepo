@extends('anonymous.default')

@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-envelope mr-2"></i>{{ trans('users.leads.contacts') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('anonymous.dashboard') }}"><i class="fas fa-home mr-2"></i>{{ trans('global.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active"><i class="fas fa-envelope mr-2"></i>{{ trans('users.leads.contacts') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p>{!! trans('users.leads.baseline') !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">{{ trans('global.our_news') }}</span>
                                <span class="info-box-number text-center text-muted mb-0"><a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" title="twitter.com"><i class="fab fa-twitter mr-2"></i>Twitter</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">{{ trans('global.next_features') }}</span>
                                <span class="info-box-number text-center text-muted mb-0"><a href="{{ config('services.github.nextgen') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github mr-2"></i>Github</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">{{ trans('global.bugs_reported') }}</span>
                                <span class="info-box-number text-center text-muted mb-0"><a href="{{ config('services.github.issues') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github mr-2"></i>Github</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    {!! Form::open(['route' => ['anonymous.contact.store'], 'method' => 'POST', 'data-user_identifier' => (Auth::check() ? Auth::user()->uniqid : 0)]) !!}
                    @honeypot
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="civility" id="civility" class="form-control" {{ Auth::check() ? 'readonly' : '' }}>
                                        @foreach ($civilities as $key)
                                        <option
                                                value="{{ $key }}"
                                                @if (Auth::check() && $key === Auth::user()->civility) selected="selected" @endif
                                        >
                                            {{ trans("users.civility.{$key}") }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input
                                            type="text"
                                            name="first_name"
                                            class="form-control @if ($errors && $errors->has('first_name')) is-invalid @endif"
                                            placeholder="{{ trans('users.first_name') }}"
                                            value="{{ old('first_name', Auth::check() ? Auth::user()->first_name : '') }}"
                                            {{ Auth::check() ? 'readonly' : '' }}
                                    />
                                    @if ($errors && $errors->has('first_name'))
                                        <span class="text-danger text-sm">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input
                                            type="text"
                                            name="last_name"
                                            class="form-control @if ($errors && $errors->has('last_name')) is-invalid @endif"
                                            placeholder="{{ trans('users.last_name') }}"
                                            value="{{ old('last_name', Auth::check() ? Auth::user()->last_name : '') }}"
                                            {{ Auth::check() ? 'readonly' : '' }}
                                    />
                                    @if ($errors && $errors->has('last_name'))
                                        <span class="text-danger text-sm">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                        type="text"
                                        name="email"
                                        class="form-control @if ($errors && $errors->has('email')) is-invalid @endif"
                                        placeholder="{{ trans('users.email') }}"
                                        value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                        {{ Auth::check() ? 'readonly' : '' }}
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($errors && $errors->has('email'))
                                <span class="text-danger text-sm">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input
                                    type="text"
                                    name="subject"
                                    class="form-control @if ($errors && $errors->has('message')) is-invalid @endif"
                                    placeholder="{{ trans('users.leads.subject') }}"
                                    value="{{ old('subject') }}"
                            />
                            @if ($errors && $errors->has('subject'))
                                <span class="text-danger text-sm">{{ $errors->first('subject') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <span class="text-sm">{!! trans('users.leads.language_info') !!}</span>
                            <textarea
                                    name="message"
                                    class="form-control @if ($errors && $errors->has('message')) is-invalid @endif"
                                    style="min-height:100px;"
                                    placeholder="{{ trans('users.leads.message') }}"
                            >
                                {{ old('message', '') }}
                            </textarea>
                            @if ($errors && $errors->has('message'))
                                <span class="text-danger text-sm">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                        <div>
                            <google-recaptcha-component></google-recaptcha-component>
                            @if ($errors && $errors->has('g-recaptcha-response'))
                                <span class="text-danger text-sm">{{ $errors->first('g-recaptcha-response') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-9">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="certify" name="certify" {{ old('certify') ? 'checked' : '' }}/>
                                    <label for="certify">
                                        <span class="@if ($errors && $errors->has('certify')) text-danger @endif">{{ trans('users.leads.certify') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary float-right">{{ trans('users.leads.send') }}</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <iframe width="100%" src="https://www.youtube.com/embed/2GNw1j7fepI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <a
                                class="btn btn-primary btn-block"
                                target="_blank"
                                rel="noopener noreferrer nofollow"
                                href="https://niantic.helpshift.com/a/pokemon-go/?p=web&l={{ Session::get('locale') }}&s=friends-gifting-and-trading&f=friend-list-friendship-levels"
                        >
                            La documentation officiel
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        {{ trans('global.social_networks_baseline') }}
                        <ul>
                            <li><a href="{{ config('services.twitter.url') }}" target="_blank" rel="noopener" title="twitter.com"><i class="fab fa-twitter mr-2"></i>Twitter</a></li>
                            <li><a href="{{ config('services.github.url') }}" target="_blank" rel="noopener" title="github.com"><i class="fab fa-github mr-2"></i>Github</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
