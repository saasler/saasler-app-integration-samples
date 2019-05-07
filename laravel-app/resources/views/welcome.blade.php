<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>

        <div id="saasler-integrations" class="panel-body"></div>
        <!-- start Saasler -->
        <script type="text/javascript">
        ("undefined"==typeof window?global:window).__416c084fc49057a3260f322421d1699c=function(){var e={exports:{}},t=e.exports,n={module:e,exports:t},a=function(a){return function(r,o,i){var s,f,c="undefined"==typeof window?global:window,l=c.define;i=[i,o,r].filter(function(e){return"function"==typeof e})[0],o=[o,r,[]].filter(Array.isArray)[0],s=i.apply(null,o.map(function(e){return n[e]})),f=typeof s,"function"==typeof l&&l("string"==typeof r?r:a,o,i),"string"===f?s=String(s):"number"===f?s=Number(s):"boolean"===f&&(s=Boolean(s)),void 0!==s&&(t=e.exports=s)}}("__416c084fc49057a3260f322421d1699c");return a.amd=!0,function(e,n){if("function"==typeof a&&a.amd)a([],n);else if("undefined"!=typeof t)n();else{var r={exports:{}};n(),e.saasler_snippet=r.exports}}(this,function(){var e="https://saasler-production-static.s3.amazonaws.com/saasler.min.js",t="https://saasler-production-static.s3.amazonaws.com/saasler.min.css";!function(n,a){a.SV||!function(){var r=function(e){var t=n.createElement("script");t.type="text/javascript",t.async=!0,t.src=e;var a=n.getElementsByTagName("script")[0];a.parentNode.insertBefore(t,a)},o=function(e){var t=n.createElement("link");t.rel="stylesheet",t.type="text/css",t.href=e;var a=n.getElementsByTagName("script")[0];a.parentNode.insertBefore(t,a)};window.saasler=a,a.initParams=[],a.init=function(n,i,s){r(e),o(t),a.initParams=[n,i,s]},a.SV=1}()}(document,window.saasler||[])}),e.exports}.call(this);
        saasler.init('{{ $saasler_tenant_id }}',
            '{{ $saasler_token }}',
            {
                intentListWidth: '100%',
                intentListHeight: '600px'
            });
        </script>
        <!-- end Saasler -->
    </body>
</html>
