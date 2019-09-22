@extends('layouts.gameforest.landings')

{{--@todo xABE : Remove at the end of beta--}}

@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('auth.register') }}</div>
                        <div class="card-body">
                            <p class="semi-bold no-margin">
                                Les inscriptions ne sont pas ouverte durant la période de beta privée.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
