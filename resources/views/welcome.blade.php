<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Client Website</title>
    <link rel="stylesheet" href=
        "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 80px;
        }
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(0, 0, 0, 0.4) !important;
        }
    </style>
</head>
<body>
@include('component.nav')
@yield('content')

<script src=
            "https://code.jquery.com/jquery-3.5.1.slim.min.js">
</script>
<script src=
            "https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js">
</script>
<script src=
            "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
</script>
</body>

</html>
