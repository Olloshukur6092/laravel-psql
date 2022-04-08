<header id="header">
    <nav class="navbar navbar-expand-lg">
        <div class="nav-left">
            <a href="" class="navbar-product">Products</a>
        </div>
        <div class="nav-right">
            <span class="mr-4">{{ session()->get('user')[0]->username }}</span>
            <a href="{{ route('auth.logout') }}">Logout</a>
        </div>
    </nav>
</header>