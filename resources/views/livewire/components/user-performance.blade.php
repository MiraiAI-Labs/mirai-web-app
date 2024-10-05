<div class="relative overflow-hidden rounded-lg flex flex-col shadow bg-base-100 p-2 gap-1 {{ $class ?? '' }}">
    <h1 class="text-xl font-bold text-center">Performa</h1>
    <canvas id="{{ $id }}" class="my-auto max-h-64"></canvas>

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
                    backgroundColor: 'rgb(255, 229, 0, 0.7)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }, {
                    label: 'Performa Target {{ auth()->user()->position->name }}',
                    data: [
                        {{ $target['cognitive'] }},
                        {{ $target['scholastic'] }},
                        {{ $target['technical'] }},
                        {{ $target['interpersonal'] }},
                        {{ $target['eq'] }},
                        {{ $target['creativity'] }},
                        {{ $target['adaptability'] }},
                        {{ $target['motivation'] }}
                    ],
                    fill: true,
                    backgroundColor: 'rgba(255, 144, 0, 0.7)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            };

            const config = {
                type: 'radar',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                fontSize: 14,
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'white' : 'black',
                            }
                        }
                    },
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
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'gray' : 'gray'
                            },
                            grid: {
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'gray' : 'gray'
                            },
                            pointLabels: { // https://www.chartjs.org/docs/latest/axes/radial/#point-labels
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'white' : 'black'
                            },
                            ticks: { // https://www.chartjs.org/docs/latest/axes/radial/#ticks
                                color: (document.getElementsByTagName('html')[0].dataset.theme === 'dark') ? 'white' : 'black',
                                backdropColor: 'transparent', // https://www.chartjs.org/docs/latest/axes/_common_ticks.html
                                // only show the first and last ticks
                                callback: function(value, index, values) {
                                    return index === 0 || index === values.length - 1 ? value : '';
                                }
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