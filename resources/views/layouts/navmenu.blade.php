<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">Home</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('auth.login') }}" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('auth.register') }}" class="nav-link">Register</a>
            </li>
        </ul>
    </div>
</nav>