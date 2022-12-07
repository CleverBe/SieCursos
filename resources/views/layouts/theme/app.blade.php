<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sie Cursos </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    @include('layouts.theme.styles')
    <!-- END GLOBAL MANDATORY STYLES -->
    @yield('css')

</head>

<body class="sidebar-noneoverflow starterkit">
    <!--  BEGIN NAVBAR  -->
    {{-- @include('layouts.theme.header') --}}
    @livewire('header-component')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layouts.theme.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @yield('content')
            </div>
            @include('layouts.theme.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    @include('layouts.theme.scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('javascript')

</body>

</html>
