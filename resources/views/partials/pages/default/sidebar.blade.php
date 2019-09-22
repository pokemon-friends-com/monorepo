<nav class="page-sidebar" data-pages="sidebar">

    {{--<div class="sidebar-overlay-slide from-top" id="appMenu">--}}
    {{--<div class="row">--}}
    {{--<div class="col-xs-6 no-padding">--}}
    {{--<a href="#" class="p-l-40"><img src="/img/demo/social_app.svg" alt="socail">--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6 no-padding">--}}
    {{--<a href="#" class="p-l-10"><img src="/img/demo/email_app.svg" alt="socail">--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}
    {{--<div class="col-xs-6 m-t-20 no-padding">--}}
    {{--<a href="#" class="p-l-40"><img src="/img/demo/calendar_app.svg" alt="socail">--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6 m-t-20 no-padding">--}}
    {{--<a href="#" class="p-l-10"><img src="/img/demo/add_more.svg" alt="socail">--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="brand" data-src="{{ asset('images/logo.png') }}" data-src-retina="{{ asset('images/logo_2x.png') }}" width="78" height="22">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu">
                {{--<i class="fa fa-angle-down fs-16"></i>--}}
            </button>
            <button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar"><i class="fa fs-12"></i></button>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu-items">
            <li class="m-t-30 ">
                <a href="{{ route('backend.dashboard.index') }}" class="detailed">
                    <span class="title">Dashboard</span>
                    <span class="details">0 New Update(s)</span>
                </a>
                <span class="@if (Route::currentRouteNamed('backend.dashboard.index')) bg-primary @endif icon-thumbnail"><i class="fa fa-dashboard"></i></span>
            </li>

            <li class="@if (
			Route::currentRouteNamed('backend.users.index')
			|| Route::currentRouteNamed('backend.users.create')
			|| Route::currentRouteNamed('backend.users.edit')
			|| Route::currentRouteNamed('backend.users.show')
			|| Route::currentRouteNamed('backend.leads.index')
			) open active @endif">
                <a href="javascript:void(0);">
                    <span class="title">{{ trans('users.title') }}</span><span class="arrow @if (
			Route::currentRouteNamed('backend.users.index')
			|| Route::currentRouteNamed('backend.users.create')
			|| Route::currentRouteNamed('backend.users.edit')
			|| Route::currentRouteNamed('backend.users.show')
			|| Route::currentRouteNamed('backend.leads.index')
			) open active @endif"></span>
                </a>
                <span class="@if (
			Route::currentRouteNamed('backend.users.index')
			|| Route::currentRouteNamed('backend.users.create')
			|| Route::currentRouteNamed('backend.users.edit')
			|| Route::currentRouteNamed('backend.users.show')
			|| Route::currentRouteNamed('backend.leads.index')
			) bg-primary @endif icon-thumbnail"><i class="fa fa-users"></i></span>
                <ul class="sub-menu">
                    <li class="@if (Route::currentRouteNamed('backend.leads.index')) active @endif">
                        <a href="{{ route('backend.leads.index') }}">{{ trans('leads.title') }}</a>
                        <span class="@if (Route::currentRouteNamed('backend.leads.index')) bg-primary @endif icon-thumbnail"><i class="fa fa-user-circle-o"></i></span>
                    </li>
                    <li class="@if (
					Route::currentRouteNamed('backend.users.index')
					|| Route::currentRouteNamed('backend.users.create')
					|| Route::currentRouteNamed('backend.users.edit')
					|| Route::currentRouteNamed('backend.users.show')
					) active @endif">
                        <a href="{{ route('backend.users.index') }}">{{ trans('users.title') }}</a>
                        <span class="@if (Route::currentRouteNamed('backend.users.index')) bg-primary @endif icon-thumbnail"><i class="fa fa-users"></i></span>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="{{ route('backend.files.index') }}">
                    <span class="title">{{ trans('files.title') }}</span>
                </a>
                <span class="@if (Route::currentRouteNamed('backend.files.index')) bg-primary @endif icon-thumbnail"><i class="fa fa-folder-open"></i></span>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</nav>
