@section('title')
    Welcome to Mirai
@endsection

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
</style>

<div x-data="{}" style="scroll-behavior: smooth;" class="poppins-regular">
    <nav class="navbar fixed transparent z-20 h-16 lg:px-28">
        <div>
            <div class="sticky top-0 items-center gap-2 bg-opacity-90 lg:px-4 lg:py-2 flex justify-center">
                <a href="{{ route('home') }}" aria-current="page" aria-label="Homepage" class="flex-0 px-2">
                    <x-logo class="mx-auto h-8 w-auto" />
                </a>
            </div>
        </div>

        <div class="ml-6 gap-16">
            <a href="#fitur" class="hover:cursor-pointer font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Fitur</a>
            <a href="#tentang" class="hover:cursor-pointer font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Tentang</a>
        </div>


        <div class="ml-auto mr-4">
            @auth
                <a href="{{ route('home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Home</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn border-0 bg-gray-100 ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-800 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <section class="pt-16 px-8 h-[600px] flex flex-col justify-center items-center hero-mirai" :class="theme == 'dark' ? 'dark' : 'light'">
        <h1 class="text-5xl font-bold text-center text-transparent !bg-clip-text p-1" :class="theme == 'dark' ? 'dark' : 'light'"">Bukan cuma diterima,</h1>
        <h1 class="text-5xl font-bold text-center text-transparent !bg-clip-text p-1" :class="theme == 'dark' ? 'dark' : 'light'"">tapi jadi pilihan utama.</h1>
        <h2 class="text-lg text-center mt-8 poppins-light">Mirai hadir membantu Anda mempersiapkan keterampilan dan memberikan informasi</h2>
        <h2 class="text-lg text-center mb-8 poppins-light">untuk mewujudkan karier IT impian Anda.</h2>
        <livewire:components.choose-position :landingPage="true" />
    </section>

    <section id="fitur" class="px-8 md:px-32 py-20 fitur-bg" :class="theme == 'dark' ? 'dark' : 'light'">
        <h1 class="text-transparent !bg-clip-text mirai-gradient text-5xl font-bold">Fitur Mirai</h1>
        <h2 class="my-4">Mirai didukung dengan berbagai fitur yang dapat membantu Anda mempersiapkan strategi untuk mendapatkan karir IT impian Anda. Fitur-fitur ini meliputi analisis tren lapangan pekerjaan, reviewer CV, simulasi interview, dan juga fitur pencarian pekerjaan. Mari pastikan agar kemampuan yang Anda miliki sekarang sesuai dengan tren dan kebutuhan dari industri IT di lapangan, dan jadilah kandidat pemenangnya!</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="overflow-hidden bg-[#fff] dark:bg-[#121418] rounded-2xl">
                <img src="{{ asset('images/landing/dashboard.png') }}" alt="">
                <h3 class="text-2xl text-black dark:text-white font-bold px-6 py-2 mt-4">Trend Explorer</h3>
                <p class="px-6 py-2 mb-6">Analisis bagaimana perkembangan tren dan informasi penting lain pekerjaan yang Anda cari dengan Trend Explorer!</p>
            </div>
            <div class="overflow-hidden bg-[#fff] dark:bg-[#121418] rounded-2xl">
                <img src="{{ asset('images/landing/cv.png') }}" alt="">
                <h3 class="text-2xl text-black dark:text-white font-bold px-6 py-2 mt-4">CV Reviewer</h3>
                <p class="px-6 py-2 mb-6">Review CV Anda dengan sistem AI kami! Sistem ini kami rancang khusus agar tidak hanya melakukan review CV saja, namun memastikan agar CV Anda mengikuti tren perkembangan pekerjaan yang Anda cari!</p>
            </div>
            <div class="overflow-hidden bg-[#fff] dark:bg-[#121418] rounded-2xl">
                <img src="{{ asset('images/landing/interview.png') }}" alt="">
                <h3 class="text-2xl text-black dark:text-white font-bold px-6 py-2 mt-4">Interview Simulation</h3>
                <p class="px-6 py-2 mb-6">Persiapkan wawancara kerja Anda dengan sistem Conversational AI dari Mirai! Sistem ini kami rancang agar dapat melakukan komunikasi dengan Anda secara dua arah dan natural. Tidak hanya itu, AI kami telah didesain khusus mengikuti sistematika HR dalam melakukan wawancara rekrutmen, sehingga Anda dapat merasakan suasana wawancara kerja yang nyata dimanapun Anda berada!</p>
            </div>
            <div class="overflow-hidden bg-[#fff] dark:bg-[#121418] rounded-2xl">
                <img src="{{ asset('images/landing/job.png') }}" alt="">
                <h3 class="text-2xl text-black dark:text-white font-bold px-6 py-2 mt-4">Pencarian Kerja Multiplatform</h3>
                <p class="px-6 py-2 mb-6">Sistem kami dilengkapi dengan fitur pencarian kerja multiplatform yang akan membantu Anda mencari pekerjaan yang Anda inginkan melalui berbagai platform, seperti LinkedIn, Glassdoor, dan Indeed. Ini akan memastikan agar Anda mendapatkan variasi yang lebih luas dan tidak terbatas pada satu platform saja-memastikan agar Anda selalu update!</p>
            </div>
        </div>
    </section>

    <section id="tentang" class="px-8 md:px-32 py-20 hero-mirai" :class="theme == 'dark' ? 'dark' : 'light'">
        <h1 class="text-5xl font-bold text-transparent !bg-clip-text p-1" :class="theme == 'dark' ? 'dark' : 'light'">Tentang Mirai</h1>
        <h2 class="mt-6">Di era digital yang terus berkembang pesat, kebutuhan akan tenaga kerja di bidang teknologi informasi (IT) semakin meningkat. Kompetensi dan keterampilan yang relevan menjadi kunci sukses untuk bersaing dalam industri ini. Namun, tantangan yang dihadapi oleh calon profesional IT semakin kompleks, mulai dari mengidentifikasi keterampilan yang dibutuhkan hingga mempersiapkan diri menghadapi proses rekrutmen yang semakin selektif.</h2>
        <h2 class="mt-6">Menanggapi perkembangan ini, Mirai hadir sebagai solusi inovatif untuk mendukung tenaga kerja IT dalam mempersiapkan diri menghadapi dunia kerja. Sebagai pionir di bidang ini, Mirai menawarkan platform yang dirancang khusus untuk membantu pengguna mengembangkan kompetensi yang dibutuhkan, mengumpulkan informasi penting, dan mengoptimalkan persiapan melamar pekerjaan.</h2>
        <h2 class="mt-6">Didukung oleh sistem berbasis kecerdasan buatan, Mirai menyediakan berbagai fitur yang meningkatkan pengalaman pengguna, termasuk analisis data otomatis untuk membantu memahami tren industri, CV reviewer yang ekstensif dan cerdas untuk menyempurnakan dokumen lamaran, serta simulasi wawancara kerja nyata untuk mempersiapkan diri menghadapi proses seleksi yang sebenarnya. Dengan Mirai, calon profesional IT dapat menyusun strategi karir yang lebih matang dan percaya diri dalam mengejar karier impian mereka.</h2>
    </section>
</div>

@section('scripts')
    <script></script>
@endsection