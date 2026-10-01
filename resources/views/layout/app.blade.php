<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- Tabler CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- Slick Carousel CSS --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <style>
        html,
        body {
            overflow-x: hidden;
        }
    </style>

    @stack('styles')
</head>

<body>
    <x-navbar />

    @yield('content')

    <x-footer />

    {{-- jQuery Full Version (BUKAN slim) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Tabler JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>

    {{-- Slick Carousel JS --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

  {{--  --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    {{-- Script kustom dari view halaman --}}
    @stack('scripts')
</body>

</html>
