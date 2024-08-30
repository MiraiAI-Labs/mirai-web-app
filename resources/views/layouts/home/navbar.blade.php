<div class="navbar bg-base-100/70 shadow-sm fixed backdrop-blur z-20 h-16">
    <div class="navbar-start !w-full">
        <label for="my-drawer-2" class="drawer-button lg:hidden">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
        </label>

        <div class="sticky top-0 items-center gap-2 bg-opacity-90 lg:px-4 lg:py-2 flex justify-center">
            <a href="{{ route('home') }}" aria-current="page" aria-label="Homepage" class="flex-0 px-2">
                <x-logo class="mx-auto h-8 w-auto" />
            </a>
        </div>
    </div>
    <div class="navbar-end">
        <x-theme-selector class="dropdown-bottom dropdown-end !mt-0" />
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar ml-2">
                <div class="w-10 rounded-full !flex justify-center items-center">
                    <i class="fa-solid fa-user fa-xl"></i>
                </div>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 min-w-52 p-2 shadow">
                <li>
                    <a href="{{ route("user.password") }}" class="flex">
                        <i class="fa-solid fa-user fa-xl"></i>
                        <div class="ml-2">
                            <p class="text-sm font-normal">{{ auth()->user()->name }}</p>
                            <p class="text-xs">{{ auth()->user()->email }}</p>
                        </div>
                    </a>
                </li>
                <hr class="my-2">
                <li>
                    <a href="{{ route("logout") }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>