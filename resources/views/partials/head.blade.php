<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'Laravel' }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('farabytelogo.png') }}" />

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Include Flowbite JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/d46a78d0a5.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@stack('scripts')
@vite(['resources/css/app.css', 'resources/js/app.js','resources/css/app-CsdDytoL.css','resources/js/app-l0sNRNKZ.js'])
@fluxAppearance
@fluxScripts()
