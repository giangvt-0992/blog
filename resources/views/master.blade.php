<html>
<head>
    <title> @yield('title') </title>
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/select2.min.css')}}">

</head>
<body>
@include('_partial.navbar')

@yield('content')


    <script src="{{url('js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{url('js/popper.min.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>  
    <script src="{{url('js/select2.min.js')}}"></script>
@yield('after-scripts')
</body>
</html>