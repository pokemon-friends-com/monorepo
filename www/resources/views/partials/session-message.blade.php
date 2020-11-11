@if (Session::has('message-success'))
    <section class="content">
        <div class="row pt-2 pb-2">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible mb-0">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! trans(Session::get('message-success')) !!}
                </div>
            </div>
        </div>
    </section>
@endif

@if (Session::has('message-error'))
    <section class="content">
        <div class="row pt-2 pb-2">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible mb-0">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! trans(Session::get('message-error')) !!}
                </div>
            </div>
        </div>
    </section>
@endif

@if (Session::has('message-warning'))
    <section class="content">
        <div class="row pt-2 pb-2">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible mb-0">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! trans(Session::get('message-warning')) !!}
                </div>
            </div>
        </div>
    </section>
@endif
