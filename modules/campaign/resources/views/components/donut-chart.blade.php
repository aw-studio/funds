@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
@endPushOnce
<div
    x-data="{ chart: null }"
    x-init="chart = new Chart(document.getElementById('donutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Reward', 'Free'],
            datasets: [{
                label: '# of Donations',
                data: [
                    {{ $campaign->orderDonationCount() }},
                    {{ $campaign->noOrderDonationCount() }},
                ],
                backgroundColor: [
                    'rgb(163, 94, 236)',
                    'rgb(243, 142, 64)',
                ],
            }]
        },
        options: {}
    });"
>
    <canvas
        id="donutChart"
        width="400"
        height="400"
    ></canvas>
</div>
