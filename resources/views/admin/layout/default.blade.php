@include('admin.layout._header')
@include('admin.layout._nav')
<body>
<div class="container">
    @include('admin.layout._notice')
    @yield('contents')
</div>
@yield('javascript')
</body>
@include('admin.layout._footer')