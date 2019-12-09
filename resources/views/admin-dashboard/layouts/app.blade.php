<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('site_title', config('app.name'))</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('header_tag')
</head>
<body class="@yield('bg_image')">
<div id="app">
    <div class="row">
        <div class="col-12 col-sm-3 col-md-2 col-lg-2">
            {{-- Include Left Sidebar --}}
            @include('admin-dashboard.layouts.left-sidebar')
        </div>
        <!-- /.col-12 col-sm-4 col-md-3 col-lg-3 -->

        <div class="col-12 col-sm-9 col-md-10 col-lg-10">
            @yield('content')
        </div>
        <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->
    </div>
    <!-- /.row -->

    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
			$.fn.selectpicker.Constructor.BootstrapVersion = 4;
    </script>

    <script>
			$(function() {
				$('select').selectpicker({
					actionsBox: true,
					liveSearch: true,
					width: '100%',
					selectedTextFormat: 'count > 3',
					showTick: true,
					size: 4,
				});
			});
    </script>

    @yield('customJS')

</div>
</body>
</html>
