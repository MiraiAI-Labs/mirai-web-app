<canvas class="w-full h-full" id="{{ $this->id }}"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let line_data = {!! json_encode($data ?? []) !!};

        
        let labels = Object.keys(line_data);
        let values = Object.values(line_data);
        
        let datasets = [{
            label: 'Jumlah',
            data: values,
        }];
        
        @if($multiple)

            labels = null;
            datasets = [];

            for(key in line_data)
            {
                if(labels == null)
                {
                    labels = Object.keys(line_data[key]);
                }

                let dataset = {
                    label: key,
                    data: Object.values(line_data[key]),
                    tension: 0.1,
                    pointRadius: 0,
                };

                datasets.push(dataset);
            }
        @endif

        const data = {
            labels: labels,
            datasets: datasets,
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        const ctx = document.getElementById("{{ $this->id }}");
        new window.Chart(ctx, config);
    });
</script>