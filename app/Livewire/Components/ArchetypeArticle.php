<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArchetypeArticle extends BaseController
{
    use ToastDispatchable;

    public $modalText = [];

    public $modal = [];

    public function render()
    {
        return view('livewire.components.archetype-article');
    }

    public function mount()
    {
        $this->modalText = [
            "The Shadowbroker" => [
                "title" => "The Shadowbroker",
                "content" => "Shadowbroker adalah arketipe yang ahli dalam menemukan kelemahan dan masalah tersembunyi. Arketipe ini berfokus pada keamanan dan pengujian. Orang dengan arketipe ini umumnya lebih tertarik menemukan kesalahan atau celah sistem yang sudah ada daripada membangun sesuatu yang baru.",
                "jobs" => "Penetration Tester, QA Testers, SOC Analysts, Cyber Security Analyst, QA Engineers, SecOps Engineers, dan lain-lain.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Shadow Monarch.",
                "image" => \App\Models\Archetype::getImageUrl("The Shadowbroker"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Shadow Monarch")
            ],

            "The Conductor" => [
                "title" => "The Conductor",
                "content" => "Sebagai pengatur harmoni antar tim, ia mampu menghubungkan berbagai elemen dalam sebuah proyek, baik teknis maupun non-teknis. Peran utamanya adalah memastikan bahwa komunikasi berjalan lancar dan setiap bagian organisasi selaras dengan tujuan yang sama. Ia tidak hanya fokus pada hasil teknis, tetapi juga bagaimana orang-orang bekerja bersama dengan efektif dan efisien, menciptakan sinergi yang sempurna.",
                "jobs" => "Coach, Scrum Masters, DevOps Engineers, SecOps Engineers, Produser.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Maestro.",
                "image" => \App\Models\Archetype::getImageUrl("The Conductor"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Maestro")
            ],

            "The Ruler" => [
                "title" => "The Ruler",
                "content" => "Pemimpin yang andal, ia merasa paling nyaman saat mengelola tim dan proyek. Fokus utamanya adalah memastikan bahwa tujuan tercapai dan proses berjalan sesuai rencana. Dengan kemampuan untuk mengambil keputusan strategis, ia mengatur sumber daya dan tim agar semua bergerak dalam satu tujuan yang sama. Ia lebih tertarik pada gambaran besar daripada detail teknis dan merasa puas ketika timnya berhasil mencapai target bersama.",
                "jobs" => "Manajer, Produser, Pemimpin Tim.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The King.",
                "image" => \App\Models\Archetype::getImageUrl("The Ruler"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The King")
            ],

            "The Innovator" => [
                "title" => "The Innovator",
                "content" => "Seorang pionir yang selalu mencari cara-cara baru untuk memecahkan masalah. Ia tidak puas hanya dengan solusi konvensional, tetapi selalu mengejar inovasi yang bisa mendorong batasan teknologi atau ide yang ada. Senang bereksperimen dan mengambil risiko, ia menginspirasi orang lain untuk melihat masa depan dengan pendekatan kreatif dan berpikiran maju. Ia yakin bahwa perubahan besar terjadi melalui gagasan-gagasan revolusioner.",
                "jobs" => "R&D Engineers, Inventor Teknologi, Pendiri Startup.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Visionary.",
                "image" => \App\Models\Archetype::getImageUrl("The Innovator"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Visionary")
            ],

            "The Artist" => [
                "title" => "The Artist",
                "content" => "Senjata terkuatnya terletak di dalam imajinasinya. The artist memiliki kreativitas yang tak terbatas, membuat orang-orang tidak bisa menebak apa yang ia pikirkan atau bayangkan. Ia menciptakan karya seni yang estetik melalui intuisi dan passion.",
                "jobs" => "Data Analyst, Researcher, Game Developer, Game Designers, UI/UX Designers.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Renaissance Artisans.",
                "image" => \App\Models\Archetype::getImageUrl("The Artist"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Renaissance Artisans")
            ],

            "The Philosopher" => [
                "title" => "The Philosopher",
                "content" => "Seseorang yang selalu mencari dan mengungkap kebenaran lalu mengajarkannya kepada orang lain. Arketipe ini ahli dalam menemukan konsep baru melalui analisis yang mendalam. The philosopher mampu membuat orang lain menjadi kuat melalui pengetahuannya.",
                "jobs" => "AI Engineers, Game Developer, Data Scientists, Data Analysts, Peneliti.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Arch-Wizard.",
                "image" => \App\Models\Archetype::getImageUrl("The Philosopher"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Arch-Wizard")
            ],

            "The Architect" => [
                "title" => "The Architect",
                "content" => "Ia adalah seseorang yang mampu merevolusi teknologi melalui keahliannya; mengubah batu menjadi kapak, dari kapak menjadi mesin, dan dari mesin menjadi LLMs. Pada era saat ini, builder adalah founder, developer, CTO, dan lain-lain. Inti keahliannya adalah mengubah sesuatu yang bukan apa-apa menjadi sesuatu yang berharga.",
                "jobs" => "Software Engineers, Web Developer, System Architects, Android Developers.",
                "evolution" => "Ketika kamu telah mencapai Level 10, kamu dapat meningkatkan kelas kamu menjadi The Master.",
                "image" => \App\Models\Archetype::getImageUrl("The Architect"),
                "evolution_image" => \App\Models\Archetype::getImageUrl("The Master")
            ]
        ];
    }

    public function getArticle($archetype)
    {
        $this->modal = $this->modalText[$archetype];

        $this->dispatch('openArchetypeModal');
    }

    public function changeArchetype($archetype_name)
    {
        $userStatistic = Auth::user()->userStatistic;

        $userStatistic->archetype_id = \App\Models\Archetype::where('name', $archetype_name)->first()->id;

        $userStatistic->save();

        $this->toast('success', 'Archetype berhasil diubah');

        return redirect()->route('home');
    }
}
