<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My App')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2e90UthlK4nNlV0Jt2z8uA/I3Gz1x2M5T6lYqA/S5X5f3k8Z/l9Gv4g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if(session('theme', 'dark') === 'dark')
        @vite([
            'resources/black-css/common-dark.css',
            'resources/black-css/' .$page. '-dark.css'
        ])
        @else
            @vite([
                'resources/light-css/common-light.css',
                'resources/light-css/' . $page . '-light.css'
            ])
        @endif

</head>
<body class="@yield('body-class')">

    <div class="container">
        <nav class="navbar">
                <div class="menu" id="menu">
                    <ul>
    <li><a href="{{ route('dash') }}">
        <button>
            <span><i class="fa-solid fa-calculator" ></i></span>
            <span class="text">Dashboard</span>
        </button>
    </a></li>
    <li><a href="{{ route('weight.index') }}">
        <button>
            <span><i class="fa-solid fa-weight-scale"></i></span>
            <span class="text">Weight</span>
        </button>
    </a></li>
    <li><a href="{{ route('workouts.index') }}">
        <button>
            <span><i class="fa-solid fa-dumbbell" ></i></span>
            <span class="text">Workout</span>
        </button>
    </a></li>
    <li><a href="{{ route('settings') }}">
        <button>
            <span><i class="fa-solid fa-gear"></i></span>
            <span class="text">Settings</span>
        </button>
    </a></li>
</ul>

                </div>
            </nav>

        <main class="main-container">
            @yield('content')
            @stack('styles')
        </main>


        

    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @stack('scripts')
</body>
</html>