<canvas class="w-full h-full {{ $class ?? '' }}" id="{{ $this->id }}"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let bar_data = {!! json_encode($data ?? []) !!};

        @if($sort)
        
            bar_data = Object.fromEntries(
                Object.entries(bar_data).sort(([,a],[,b]) => a - b)
            );
        @endif

        @if($descending)

            bar_data = Object.fromEntries(
                Object.entries(bar_data).reverse()
            );
        @endif

        const data = {
            labels: Object.keys(bar_data),
            datasets: [{
                label: 'Jumlah',
                backgroundColor: 'rgb(255, 229, 0, 0.7)',
                data: Object.values(bar_data),
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: '{{ $isVertical ? 'x' : 'y' }}',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        const options = {
            responsive: true,
            maintainAspectRatio: false,
        };

        const ctx = document.getElementById("{{ $this->id }}");
        new window.Chart(ctx, config, options);
    });
</script>