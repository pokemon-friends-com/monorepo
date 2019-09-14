@extends('layouts.gameforest.landings')

@section('title')
    {{ $metadata['title'] }}
@endsection

@section('content')
    <nav class="bg-white border-bottom" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">{{ trans('global.home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('leads.contacts') }}</li>
            </ol>
        </div>
    </nav>
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('leads.contacts') }}</div>
                        <div class="card-body">
                            <p class="semi-bold no-margin">{{ trans('leads.baseline') }}</p>
                            {!! Form::open(['route' => ['frontend.contact.store'], 'method' => 'POST', 'data-user_identifier' => (Auth::check() ? Auth::user()->uniqid : 0)]) !!}


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group form-group-default required">
                                        <label class="control-label">{{ trans('users.civility') }}</label>
                                        <select name="civility" id="civility" class="form-control">
                                            @foreach ($civilities as $key => $trans)
                                                <option value="{{ $key }}" @if (Auth::check() && $key === Auth::user()->civility) selected="selected" @endif>{{ $trans }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group form-group-default required">
                                        <label class="control-label">{{ trans('users.first_name') }}</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="{{ trans('users.first_name') }}" value="{{ old('first_name', Auth::check() ? Auth::user()->first_name : '') }}"/>
                                        @if ($errors && $errors->has('first_name'))
                                            <span class="error">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group form-group-default required">
                                        <label class="control-label">{{ trans('users.last_name') }}</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="{{ trans('users.last_name') }}" value="{{ old('last_name', Auth::check() ? Auth::user()->last_name : '') }}"/>
                                        @if ($errors && $errors->has('last_name'))
                                            <span class="error">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group form-group-default required">
                                <label class="control-label">{{ trans('users.email') }}</label>
                                <input type="text" name="email" class="form-control" placeholder="{{ trans('users.email') }}" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"/>
                                @if ($errors && $errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                            </div>


                            <div class="form-group form-group-default required">
                                <label class="control-label">{{ trans('leads.subject') }}</label>
                                <input type="text" name="subject" class="form-control" placeholder="{{ trans('leads.subject') }}" value="{{ old('subject') }}"/>
                                @if ($errors && $errors->has('subject'))
                                    <span class="error">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>


                            <div class="form-group form-group-default required">
                                <label class="control-label">{{ trans('leads.message') }}</label>
                                <textarea name="message" class="form-control" style="height:100px" placeholder="{{ trans('leads.message') }}">{{ old('message', '') }}</textarea>
                                @if ($errors && $errors->has('message'))
                                    <span class="error">{{ $errors->first('message') }}</span>
                                @endif
                            </div>


                            <div class="sm-p-t-10 clearfix">
                                <p class="pull-left small hint-text m-t-10 font-arial">{{ trans('leads.certify') }}</p>
                                <input type="submit" value="{{ trans('leads.send') }}" name="submit" class="btn btn-primary font-montserrat all-caps fs-12 pull-right xs-pull-left" />
                            </div>
                            <div class="clearfix"></div>


                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
