<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (IE 9)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US" content="IE=edge"> <!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @include('partials.other.header')
</head>
<body class="cpanel">


    @include('partials.navigation')
    <div class="wrapper">
        @include('partials.aside')
        <div class="container-fluid" id="main-container">
            <div class="page-head">
                <h2 >
                    @yield('page-title')

                    @include('partials.buttons')
                </h2>
                <small>@yield('page-sub-title')</small>
            </div>
            <div class="container-fluid">
            @include('partials.notifications')
            </div>
            <div class="container-fluid">

                               @yield('content')

            </div>
        </div>
    </div>

<footer>
    @include('partials.footer')
</footer>
</body>
</html>
