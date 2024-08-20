<nav class="bg-gray-800 p-4">
    <div class="container mx-auto">
        <a href="{{ url('/') }}" class="text-white">Home</a>
        @auth
            <a href="{{ url('/dashboard') }}" class="text-white ml-4">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white ml-4">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-white ml-4">Login</a>
            <a href="{{ route('register') }}" class="text-white ml-4">Register</a>
        @endauth
    </div>
</nav>
