@php
    $id = uniqid('radar-');
    $userStatistic = \App\Models\UserStatistic::where('user_id', $user_id)->first();
    $user = \App\Models\User::find($user_id);
@endphp

<canvas id="{{ $id }}" class="my-auto w-32"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                label: 'Performa {{ $user->name }}',
                data: @json($userStatistic->performance),
                fill: true,
                backgroundColor: 'rgb(255, 229, 0, 0.7)',
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
        new Chart(ctx, config);
    });
</script>