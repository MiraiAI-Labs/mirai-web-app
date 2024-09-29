<div class="w-full h-full">
    <button class="btn btn-neutral" @click="toggleArticle"><i class="fa-solid fa-angle-left"></i> Back</button>
    <section class="flex flex-row my-4">
        <div class="sm:w-8/12 flex flex-col justify-center lg:pr-6">
            <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-6xl font-bold text-left !bg-clip-text text-transparent bw-gradient" :class="theme == 'dark' ? 'dark' : 'light'">Ketahui dirimu, ketahui lawanmu, dan jadilah tak terkalahkan.</h1>
            <h2 class="text-sm md:text-xl text-theme my-4 lg:my-12" :class="theme == 'dark' ? 'dark' : 'light'">Kami percaya bahwa dalam dunia industri Teknologi Informasi sekalipun, setiap persona memiliki ciri khas yang dapat diklasifikasikan berdasarkan sebuah sistem dikotomi. </h2>
            <button class="btn btn-orange-gradient normal-case text-black self-start">Pelajari Arketipe Saya</button>
        </div>
        <div class="sm:w-4/12 lg:pl-6 hidden sm:block">
            <img src="{{ asset('images/hero-archetype.png') }}" alt="Hero Archetype">
        </div>
    </section>
    <section class="flex md:flex-row flex-col mt-2 mb-16">
        <div class="md:w-1/2 pr-0 md:pr-6 flex">
            <h1 class="my-auto text-3xl md:text-4xl lg:text-6xl xl:text-8xl font-bold text-left !bg-clip-text text-transparent bw-gradient" :class="theme == 'dark' ? 'dark' : 'light'">Persona menjadi kunci kesuksesan karir.</h1>
        </div>
        <div class="md:w-1/2 pr-0 md:pl-6 mt-4 md:mt-0">
            <p class="text-sm lg:text-xl text-theme" :class="theme == 'dark' ? 'dark' : 'light'">Pada kenyataannya, terdapat banyak sekali ragam dan karakteristik dalam pekerjaan di industri IT. Mulai dari pekerjaan yang melibatkan analisis hingga kreativitas out-of-the-box.</p>
            <br />
            <p class="text-sm lg:text-xl text-theme" :class="theme == 'dark' ? 'dark' : 'light'">Berdasarkan studi yang dilakukan oleh Heslin, dkk. (2018), bukti empiris penelitian telah membuktikan bahwa persona dan sifat sangat mempengaruhi keberhasilan seseorang dalam karir mereka.</p>
        </div>
    </section>
    <section>
        <div>
            <p class="text-sm lg:text-xl text-theme" :class="theme == 'dark' ? 'dark' : 'light'">Setiap orang memiliki karakteristik dan kepribadiannya masing-masing. Hal ini dapat mempengaruhi bagaimana pilihan bidang IT mereka nanti. Hingga saat ini, belum ada acuan pasti yang mengklasifikasikan bidang yang tepat berdasarkan kepribadian seseorang.</p>
            <br />
            <p class="text-sm lg:text-xl text-theme" :class="theme == 'dark' ? 'dark' : 'light'">Menanggapi hal ini, Mirai mengusulkan sistem dikotomi 7 Arketipe IT (The Seven IT Archetypes). Sistem dikotomi ini mengklasifikasikan minat dan bakat seseorang berdasarkan uji kepribadian dan tingkah laku seseorang dalam bidang ini.</p>
        </div>
        <div>
            <img src="{{ asset('images/diagram-archetype.png') }}" alt="Diagram Archetype">
        </div>
    </section>
</div>