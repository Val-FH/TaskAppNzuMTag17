<header class="bg-neutral text-neutral-content">
    <nav class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
        <a href="{{ route('welcome') }}" 
            class="text-xl font-bold {{ request()->routeIs('welcome') ? '' : 'opacity-80 hover:opacity-100' }}"> Task<span class="text-primary">App</span> 
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}"
                class="text-sm {{ request()->routeIs('tasks.*') ? 'font-medium' : 'opacity-50 hover:opacity-100' }}">
                Übersicht
            </a>
            <!--Wenn nicht eingeloggt ist guest sichtbar -->
            @guest
                <a href="{{ route('login') }}" class="text-sm opacity-80"> Log in </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm"> Register </a>
            @endguest
           <!--Wenn eingeloggt sieht man auth und so können nur autorisierte Leute an die Sieten -->
            @auth
               <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'font-medium' : 'opacity-80 hover:opacity-100' }}">
                Hi, {{ auth()->user()->name }}
               </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-soft btn-primary">
                        Log Out
                    </button>
                </form>
            @endauth <!--endtag für auth -->
            <!--@ funktion geht nur im view  -->
            @can('view-admin')
                    <!--route('admin')  geht nur wenn in der web auch das ->name('admin') vergeben wurde -->
                 <a href="{{ route('admin') }}" class="btn btn-soft btn-secondary"> Admin</a> </span>
            @endcan
        </div>
    </nav>
</header>