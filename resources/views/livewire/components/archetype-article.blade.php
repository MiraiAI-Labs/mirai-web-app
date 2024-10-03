<div class="w-full h-full">
    <button class="btn btn-neutral" @click="toggleArticle"><i class="fa-solid fa-angle-left"></i> Back</button>
    <section class="flex flex-row my-4">
        <div class="sm:w-8/12 flex flex-col justify-center lg:pr-6">
            <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-6xl font-bold text-left !bg-clip-text text-transparent bw-gradient" :class="theme == 'dark' ? 'dark' : 'light'">Ketahui dirimu, ketahui lawanmu, dan jadilah tak terkalahkan.</h1>
            <h2 class="text-sm md:text-xl text-black dark:text-white my-4 lg:my-12">Kami percaya bahwa dalam dunia industri Teknologi Informasi sekalipun, setiap persona memiliki ciri khas yang dapat diklasifikasikan berdasarkan sebuah sistem dikotomi. </h2>
            <button class="btn btn-orange-gradient normal-case text-black self-start">Pelajari Arketipe Saya</button>
        </div>
        <div class="sm:w-4/12 lg:pl-6 hidden sm:block">
            <img src="{{ asset('images/hero-archetype.png') }}" alt="Hero Archetype">
        </div>
    </section>
    <section class="flex md:flex-row flex-col mt-2 mb-6 md:mb-16">
        <div class="md:w-1/2 pr-0 md:pr-6 flex">
            <h1 class="my-auto text-3xl md:text-4xl lg:text-6xl font-bold text-left !bg-clip-text text-transparent bw-gradient" :class="theme == 'dark' ? 'dark' : 'light'">Persona menjadi kunci kesuksesan karir.</h1>
        </div>
        <div class="md:w-1/2 pr-0 md:pl-6 mt-4 md:mt-0">
            <p class="text-sm lg:text-xl text-black dark:text-white">Pada kenyataannya, terdapat banyak sekali ragam dan karakteristik dalam pekerjaan di industri IT. Mulai dari pekerjaan yang melibatkan analisis hingga kreativitas out-of-the-box.</p>
            <br />
            <p class="text-sm lg:text-xl text-black dark:text-white">Berdasarkan studi yang dilakukan oleh Heslin, dkk. (2018), bukti empiris penelitian telah membuktikan bahwa persona dan sifat sangat mempengaruhi keberhasilan seseorang dalam karir mereka.</p>
        </div>
    </section>
    <section class="flex md:flex-row flex-col mb-6 md:mb-16">
        <div class="md:w-1/2 md:flex md:justify-evenly md:flex-col md:pr-16 mb-4 md:mb-0">
            <p class="text-sm lg:text-lg text-black dark:text-white">Setiap orang memiliki karakteristik dan kepribadiannya masing-masing. Hal ini dapat mempengaruhi bagaimana pilihan bidang IT mereka nanti. Hingga saat ini, belum ada acuan pasti yang mengklasifikasikan bidang yang tepat berdasarkan kepribadian seseorang.</p>
            <br />
            <p class="text-sm lg:text-lg text-black dark:text-white">Menanggapi hal ini, Mirai mengusulkan sistem dikotomi 7 Arketipe IT (The Seven IT Archetypes). Sistem dikotomi ini mengklasifikasikan minat dan bakat seseorang berdasarkan uji kepribadian dan tingkah laku seseorang dalam bidang ini.</p>
        </div>
        <div class="md:w-1/2 mt-4 md:mt-0 flex">
            <img src="{{ asset('images/diagram-archetype.png') }}" alt="Diagram Archetype" class="m-auto">
        </div>
    </section>
    <section>
        <h1 class="text-4xl font-bold !bg-clip-text text-transparent bw-gradient text-center my-4" :class="theme == 'dark' ? 'dark' : 'light'">Manakah Arketipemu ?</h1>
        @php
            $archetypes = App\Models\Archetype::getBaseArchetypes();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 xl:grid-rows-2 gap-6 py-4 px-12">
            @foreach($archetypes as $archetype)
            <div class="group btn normal-case relative w-full h-0 pb-[100%] bg-cover bg-center rounded-xl border-4 border-blue-500 hover:border-blue-400 hover:shadow-[0_0_20px_-5px_rgba(63,131,248,0.9)] transition-all duration-300 ease-in-out shadow-lg" style="background-image: url('{{ asset($archetype->image) }}');">
         
                <!-- Overlay effect -->
                <div class="group absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent rounded-xl"></div>
            
                <!-- Text content -->
                <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-white transform transition duration-300">
                    <h3 class="m-0 text-sm font-bold drop-shadow-md">{{ $archetype->name }}</h3>
                    <p class="m-0 text-justify font-light text-[0.5rem] leading-[0rem] group-hover:drop-shadow-md group-hover:leading-[0.65rem] mt-2 opacity-0 duration-300 ease-in-out group-hover:opacity-100">
                        {{ $archetype->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>