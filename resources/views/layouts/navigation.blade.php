<nav class="site-nav">
    <div class="site-nav__inner">
        <div class="site-nav__brand">
            <a href="{{ route('dashboard') }}" class="site-nav__logo">ESN Manager</a>
            <div class="site-nav__links">
                <a href="{{ route('dashboard') }}" class="site-nav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('projects.index') }}" class="site-nav__link {{ request()->routeIs('projects.*') ? 'is-active' : '' }}">Projets</a>
                <a href="{{ route('tickets.index') }}" class="site-nav__link {{ request()->routeIs('tickets.*') ? 'is-active' : '' }}">Tickets</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="site-nav__link {{ request()->routeIs('users.*') ? 'is-active' : '' }}">Utilisateurs</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="site-nav__link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">Profil</a>
            </div>
        </div>

        <div class="site-nav__actions">
            <span class="site-nav__user">{{ Auth::user()->name }} — {{ Auth::user()->role }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="button button--secondary">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
