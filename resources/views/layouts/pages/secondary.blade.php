<!DOCTYPE html>
<html>
<head>
    @include('partials.pages.default.metadata')
</head>
<body class="fixed-header dashboard">
@include('partials.pages.default.sidebar')
<div class="page-container ">
    @include('partials.pages.default.header')
    <div class="page-content-wrapper full-height">
        <div class="content full-height">
            <nav class="secondary-sidebar">
                @yield('sidebar')
            </nav>
            <div class="inner-content full-height">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('partials.pages.default.quickview')
@include('partials.pages.default.overlay')
@include('partials.pages.default.footerjs')
@include('partials.pages.default.session_flash_message')
</body>
</html>
