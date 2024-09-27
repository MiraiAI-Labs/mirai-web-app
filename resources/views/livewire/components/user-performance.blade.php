<div class="relative overflow-hidden rounded-lg flex flex-col shadow bg-base-100 p-2 gap-1 {{ $class ?? '' }}">
    <h1 class="text-xl font-bold text-white text-center">Performa</h1>
    <canvas id="{{ $id }}" class="my-auto"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = {
                labels: [
                    'Kognitif',
                    'Skolastik',
                    'Teknis',
                    'Interpersonal',
                    'EQ',
                    'Kreativitas',
                    'Adaptabilitas',
                    'Motivasi'
                ],
                datasets: [{
                    label: 'Performa Anda',
                    data: @json(auth()->user()->userStatistic->performance),
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            };

            const config = {
                type: 'radar',
                data: data,
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    },
                    scales: {
                        r: {
                            suggestedMin: 0,
                            suggestedMax: 10,
                            angleLines: {
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'gray' : 'black'
                            },
                            grid: {
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'gray' : 'black'
                            },
                            pointLabels: { // https://www.chartjs.org/docs/latest/axes/radial/#point-labels
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'white' : 'black'
                            },
                            ticks: { // https://www.chartjs.org/docs/latest/axes/radial/#ticks
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'white' : 'black',
                                backdropColor: 'transparent' // https://www.chartjs.org/docs/latest/axes/_common_ticks.html
                            }
                        }
                    }
                },
            };

            var ctx = document.getElementById('{{ $id }}').getContext('2d');
            new window.Chart(ctx, config);
        });
    </script>
</div>