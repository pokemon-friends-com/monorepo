<!DOCTYPE html>
<html style="background-color: transparent;">
<head>
    <style>
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            background: transparent;
        }
        #app div {
            margin: 15px 15px;
        }
    </style>
    @include('partials.metadata')
</head>
<body>
    <div id="app">
        <qr-code-stream-feed-component channel="{{ $user->profile->twitch_channel }}"></qr-code-stream-feed-component>
    </div>
    @include('partials.scripts')
</body>
</html>
