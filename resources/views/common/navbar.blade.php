@php
    $user = Auth::user();
@endphp
<nav class="navbar navbar-expand-lg" style="background-color: #4273b8;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="{{ route('home.index') }}">Sale ERP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Left-side links -->
        <div class="navbar-nav">
            @if ($user)
                <a class="nav-link text-white" href="{{ route('customer.index') }}">Customer</a>
                <a class="nav-link text-white" href="{{ route('sale.index') }}">Sale</a>
                @if ($user->role_id == 1)
                    <a class="nav-link text-white" href="{{ route('product.index') }}">Product</a>
                    <a class="nav-link text-white" href="{{ route('user.index') }}">Users</a>
                @endif
            @else
                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
            @endif
        </div>

        <!-- Right-side links -->
        <div class="navbar-nav ms-auto">
            @if ($user)
                <a class="nav-link text-white">{{ $user->name }}</a>
                <a class="nav-link text-white" href="{{ route('logout') }}">Logout</a>
            @endif
        </div>
    </div>
</nav>
