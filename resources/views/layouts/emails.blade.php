<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        @include('partials.emails.metadatas')
    </head>
    <body>
        @include('partials.emails.header')
        @yield('content')
        @include('partials.emails.footer')
    </body>
</html>
