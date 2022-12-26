<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.includes.main_head')
    </head>
    <body>
        <div class="wrapper d-flex">
            @include('admin.includes.aside')
            <div class="content-wrapper light content-wrapper-toggle">
                @include('admin.includes.header')
                <div class="overlay"></div>
                @yield('content')
                @include('admin.includes.footer')
            </div>
        </div>
        @include('admin.includes.main_foot')
        @yield('datatable')
    </body>
</html>