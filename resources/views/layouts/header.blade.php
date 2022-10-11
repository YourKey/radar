<div class="navbar bg-base-100 mb-4">
    <div class="navbar-start">
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </label>
            <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('projects.index') }}">Projects</a></li>
            </ul>
        </div>
        <a href="/" class="btn btn-ghost normal-case text-xl">📡 Radar</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal p-0">
            @auth
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
            @endauth
        </ul>
    </div>
    <div class="navbar-end">
        @auth
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="label overflow-hidden cursor-pointer hover:bg-gray-100 p-2 rounded">
                <div class="font-weight-bold mt-3 mr-2">{{ auth()->user()->name }}</div>
                <div class="w-10 rounded-full text-white font-weight-bold overflow-hidden">
                    <div class="bg-accent w-10 h-10 p-3">{{ auth()->user()->first_letter_of_name  }}</div>
                </div>
            </label>

            <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-error btn-sm btn-block" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
        @guest
            <a class="mr-3 btn btn-outline" href="{{ route('register') }}">Sign up</a>
            <a class="mr-6 btn btn-outline" href="{{ route('login') }}">Sign in</a>
        @endguest
    </div>

</div>
