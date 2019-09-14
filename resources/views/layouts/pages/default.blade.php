<!DOCTYPE html>
<html>
<head>
    @include('partials.pages.default.metadata')
</head>
<body class="fixed-header dashboard">
@include('partials.pages.default.sidebar')
<div id="obsessioncity" class="page-container ">
    @include('partials.pages.default.header')
    <div class="page-content-wrapper ">
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                @yield('content')
            </div>
        </div>
        @include('partials.pages.default.footer')
    </div>
</div>
@include('partials.pages.default.quickview')
@include('partials.pages.default.overlay')
@include('partials.pages.default.footerjs')
@include('partials.pages.default.session_flash_message')
</body>
</html>
