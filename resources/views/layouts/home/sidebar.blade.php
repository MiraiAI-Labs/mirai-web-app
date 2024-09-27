<div class="drawer-side z-50 lg:z-10 !w-56 !fixed lg:pt-16">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay !fixed w-[100vw] h-[100vh] lg:hidden"></label>
    <ul class="menu bg-base-300 text-base-content min-h-full w-56 p-4">
        <!-- Sidebar content here -->
        <li class="my-1">
            <a href={{ route('home') }} class="{{ ($activeTab ?? null) == 'home' ? 'active' : '' }}"><i class="fa-solid fa-house"></i>Dashboard</a>
        </li>
        @if(auth()->user()->positionChosen)
            <li class="my-1">
                <a href={{ route('cv') }} class="{{ ($activeTab ?? null) == 'cv' ? 'active' : '' }}"><i class="fa-solid fa-file-lines"></i>CV Analysis</a>
            </li>
            <li class="my-1">
                <a href={{ route('interview') }} class="{{ ($activeTab ?? null) == 'interview' ? 'active' : '' }}"><i class="fa-solid fa-microphone-lines"></i>Practice Interview</a>
            </li>
            <li class="my-1">
                <a href={{ route('roadmap') }} class="{{ ($activeTab ?? null) == 'roadmap' ? 'active' : '' }}"><i class="fa-solid fa-map"></i>Roadmap</a>
            </li>
            <li class="my-1">
                <a href={{ route('quiz') }} class="{{ ($activeTab ?? null) == 'quiz' ? 'active' : '' }}"><i class="fa-solid fa-clipboard-question"></i>Quiz Exercise</a>
            </li>
            <li class="my-1">
                <a href={{ route('courses') }} class="{{ ($activeTab ?? null) == 'courses' ? 'active' : '' }}"><i class="fa-solid fa-graduation-cap"></i>Course</a>
            </li>
            <li class="my-1">
                <a href={{ route('jobs') }} class="{{ ($activeTab ?? null) == 'jobs' ? 'active' : '' }}"><i class="fa-solid fa-square-poll-vertical"></i>Job Vacancies</a>
            </li>
        @endif
        <li class="my-1">
            <a href={{ route('user.password') }} class="{{ ($activeTab ?? null) == 'account' ? 'active' : '' }}"><i class="fa-solid fa-user"></i>Akun</a>
        </li>
    </ul>
</div>