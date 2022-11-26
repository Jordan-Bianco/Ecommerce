<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <style>
        .fade-enter-active,
        .fade-leave-active {
            transition: opacity 200ms ease;
        }

        .fade-enter-from,
        .fade-leave-to {
            opacity: 0;
        }

        .list-enter-active,
        .list-leave-active {
            transition: all 250ms ease-in-out;
        }

        .list-enter-from,
        .list-leave-to {
            opacity: 0;
            transform: translateX(-20px);
        }

        .from-r-enter-active,
        .from-r-leave-active {
            transition: all 200ms ease-in-out;
        }

        .from-r-enter-from,
        .from-r-leave-to {
            opacity: 0;
            transform: translateX(20px);
        }
    </style>
</head>

<body class="font-sans antialiased text-zinc-800">
    @inertia
</body>

</html>