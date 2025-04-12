<nav class="bg-white dark:bg-gray-800 shadow fixed w-full z-10 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-4">
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
            </div>
        </div>
    </div>
</nav>

{{-- Add spacing below the navbar to prevent content from being hidden --}}
<div class="h-16"></div>
