@if (Session::has('message-success'))
    <div class="pgn-wrapper" data-position="top">
        <div class="pgn push-on-sidebar-open pgn-bar">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
                <span>{!! trans(Session::get('message-success')) !!}</span>
            </div>
        </div>
    </div>
@endif
@if (Session::has('message-error'))
    <div class="pgn-wrapper" data-position="top">
        <div class="pgn push-on-sidebar-open pgn-bar">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
                <span>{!! trans(Session::get('message-error')) !!}</span>
            </div>
        </div>
    </div>
@endif
@if (Session::has('message-warning'))
    <div class="pgn-wrapper" data-position="top">
        <div class="pgn push-on-sidebar-open pgn-bar">
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
                <span>{!! trans(Session::get('message-warning')) !!}</span>
            </div>
        </div>
    </div>
@endif
