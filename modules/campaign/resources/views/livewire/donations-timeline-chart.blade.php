<?php

use function Livewire\Volt\{state, computed};

state(['campaign']);

$chartData = computed(function () {
    $cacheKey = 'campaign_donations_chart_' . $this->campaign->id;

    $donations = cache()->remember($cacheKey, 300, function () {
        return $this->campaign->donations()
            ->select('created_at', 'amount')
            ->orderBy('created_at', 'ASC')
            ->get();
    });

    if ($donations->isEmpty()) {
        return ['timestamps' => [], 'data' => [], 'amountPerPeriod' => [], 'labelFormat' => 'L'];
    }

    $firstDonation = $donations->first()->created_at;
    $lastDonation = $donations->last()->created_at;
    $hoursDifference = $firstDonation->diffInHours($lastDonation);

    if ($hoursDifference <= 72) {
        $groupFormat = 'Y-m-d H:00:00';
        $labelFormat = 'L LT';
    } elseif ($hoursDifference <= 60 * 24) {
        $groupFormat = 'Y-m-d';
        $labelFormat = 'L';
    } else {
        $groupFormat = 'Y-W';
        $labelFormat = 'L';
    }

    $cumulativeTotal = 0;
    $grouped = [];
    $periodTotals = [];

    foreach ($donations as $donation) {
        $cumulativeTotal += $donation->amount->cents;
        $groupKey = $donation->created_at->format($groupFormat);

        if (!isset($periodTotals[$groupKey])) {
            $periodTotals[$groupKey] = 0;
        }
        $periodTotals[$groupKey] += $donation->amount->cents;

        $grouped[$groupKey] = [
            'total' => $cumulativeTotal,
            'periodAmount' => $periodTotals[$groupKey],
            'date' => $donation->created_at,
        ];
    }

    $timestamps = [];
    $data = [];
    $amountPerPeriod = [];

    foreach ($grouped as $item) {
        $timestamps[] = $item['date']->toIso8601String();
        $data[] = $item['total'] / 100;
        $amountPerPeriod[] = $item['periodAmount'] / 100;
    }

    return [
        'timestamps' => $timestamps,
        'data' => $data,
        'amountPerPeriod' => $amountPerPeriod,
        'labelFormat' => $labelFormat,
    ];
});

?>

@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endPushOnce

<div x-data="{
    chart: null,
    formatTimestamp(ts, format) {
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            ...(format.includes('LT') && {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            })
        };
        return new Date(ts).toLocaleString(undefined, options);
    },
    formatCurrency(v) {
        return new Intl.NumberFormat(undefined, { style: 'currency', currency: 'EUR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(v);
    },
    init() {
        const chartData = @js($this->chartData);
        const labels = chartData.timestamps.map(ts => this.formatTimestamp(ts, chartData.labelFormat));
        if (this.chart) chart.destroy();
        this.chart = new Chart(document.querySelector('#timeline-chart').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '{{ __('Total Donations') }} (€)',
                    data: chartData.data,
                    borderColor: 'rgb(163, 94, 236)',
                    yAxisID: 'right',
                }, {
                    label: '{{ __('Amount per Period') }} (€)',
                    data: chartData.amountPerPeriod,
                    borderColor: 'rgb(243, 142, 64)',
                    yAxisID: 'left',
                }]
            },
            options: {
                scales: {
                    left: {
                        position: 'left',
                        ticks: { callback: (v) => this.formatCurrency(v) }
                    },
                    right: {
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { callback: (v) => this.formatCurrency(v) }
                    },
                    x: { ticks: { maxRotation: 45, minRotation: 45 } }
                }
            }
        });
    }
}">
    <canvas width=" 400" height="120" id="timeline-chart"></canvas>
</div>
