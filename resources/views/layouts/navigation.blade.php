<nav class="bg-white dark:bg-gray-800 shadow fixed w-full z-10 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Section: Job Portal Title -->
            <div class="flex items-center space-x-4">
                <!-- Job Portal Title -->
                <a href="{{ route('jobs.index') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                    Job Portal
                </a>

                {{-- Post a Job button for posters (only on /dashboard or /jobs) --}}
                @if (auth()->check() && auth()->user()->role === 'poster' && (request()->is('dashboard') || request()->is('jobs')))
                    <a href="{{ route('jobs.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        + Post a Job
                    </a>
                @endif

                {{-- Show Inactive Jobs button for posters (hide on /jobs/inactive) --}}
                @if (auth()->check() && auth()->user()->role === 'poster' && !request()->is('inactive'))
                    <a href="{{ route('jobs.inactive') }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Show Inactive Jobs
                    </a>
                @endif

                {{-- Show Dashboard button only if not on job index or root --}}
                @if (!request()->is('/') && !request()->is('jobs'))
                    <a href="{{ route('dashboard') }}" class="text-gray-900 dark:text-white">Dashboard</a>
                @endif
            </div>

            <!-- Right Section: Theme Toggle and Authentication Links -->
            <div class="flex items-center space-x-4">
                {{-- Show logged-in user name with role --}}
                @auth
                    <span class="text-gray-900 dark:text-white font-medium">
                        Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                    </span>
                @endauth

                {{-- Authentication Links --}}
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-900 dark:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m0 6H3" />
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-900 dark:text-white">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 text-gray-900 dark:text-white">Register</a>
                @endauth

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="flex items-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded ml-8">
                    <span id="theme-icon" class="mr-2">
                        <!-- Sun Icon for Light Mode -->
                        <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.343 17.657l-1.414 1.414M17.657 17.657l1.414-1.414M6.343 6.343L4.93 4.93" />
                        </svg>
                        <!-- Moon Icon for Dark Mode -->
                        <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </span>
                    <span id="theme-text">Dark Mode</span>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Add spacing below the navbar to prevent content from being hidden --}}
<div class="h-16"></div>

<script>
    // Check for saved user preference or system preference
    const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme');

    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    const themeText = document.getElementById('theme-text');

    if (savedTheme === 'dark' || (!savedTheme && userPrefersDark)) {
        document.documentElement.classList.add('dark');
        moonIcon.classList.remove('hidden');
        themeText.textContent = 'Light Mode';
    } else {
        document.documentElement.classList.remove('dark');
        sunIcon.classList.remove('hidden');
        themeText.textContent = 'Dark Mode';
    }

    // Theme toggle button
    const themeToggleButton = document.getElementById('theme-toggle');
    themeToggleButton.addEventListener('click', () => {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            themeText.textContent = 'Dark Mode';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
            themeText.textContent = 'Light Mode';
        }
    });
</script>
