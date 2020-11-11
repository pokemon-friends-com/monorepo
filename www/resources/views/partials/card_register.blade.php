<div class="card">
    {!! Form::open(['route' => ['register'], 'method' => 'POST']) !!}
    @honeypot
    <div class="card-body">
        <div class="form-group">
            <div class="input-group">
                <input
                        type="text"
                        name="friend_code"
                        class="form-control {{ $errors && $errors->has('friend_code') ? 'is-invalid' : '' }}"
                        placeholder="{{ trans('users.profiles.friend_code') }}"
                        value="{{ old('friend_code') }}"
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-users"></span>
                    </div>
                </div>
            </div>
            @if ($errors && $errors->has('friend_code'))
                <div class="text-danger text-sm">{{ $errors->first('friend_code') }}</div>
            @endif
        </div>
        <div class="form-group">
            <div class="input-group">
                <input
                        type="email"
                        name="email"
                        class="form-control {{ $errors && $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="{{ trans('users.email') }}"
                        value="{{ old('email') }}"
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            @if ($errors && $errors->has('email'))
                <div class="text-danger text-sm">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="sm-p-t-10 clearfix"></div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ trans('auth.register') }}
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
