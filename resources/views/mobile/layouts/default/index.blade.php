<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title')</title>
        <link rel="icon" href="{{ URL::asset('images/favicon.ico') }}" type="image/x-icon" >
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta name="robots" content="noodp " />
        
        
        <link rel="stylesheet" href="{{ URL::asset('dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="<?php echo URL::asset('css/common_style.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('plugins/font-awesome/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('css/mobile_custom_default.css') ?>">
        <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css') }}">
        <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
        @include('common/google_analytics_code')

        @yield('page_style')
    </head>
    <body>
        @include('mobile.layouts.default.includes.header')
        
        <div style="margin-bottom: 50px">
        @yield('content')
        </div>
        
        
        @include('mobile.layouts.default.includes.footer')

        <script src="{{ URL::asset('js/custom_default.js') }}"></script>
        <script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            setTimeout(function(){
                $(".alert").fadeOut(500);
            }, 5000);
        </script>
        
        @yield('page_javascript')

        <?php  ?>
    </body>
</html>