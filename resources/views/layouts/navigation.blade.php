<nav class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- <a href="{{ route('home') }}" class="text-gray-900 dark:text-white">Home</a> --}}
                <a href="{{ route('jobs.index') }}" class="ml-4 text-gray-900 dark:text-white">Jobs</a>
            </div>
            @if (auth()->check() && auth()->user()->role === 'poster')
                <div class="mb-4">
                    <a href="{{ route('jobs.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        + Post a Job
                    </a>
                </div>
            @endif
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-900 dark:text-white">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-4 text-gray-900 dark:text-white">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-900 dark:text-white">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 text-gray-900 dark:text-white">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
