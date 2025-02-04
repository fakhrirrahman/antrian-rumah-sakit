<?php

namespace App\Filament\Resources\FarmasiResource\Widgets;

use App\Models\Farmasi;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Antrian Farmasi';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = Farmasi::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'labels' => ['Menunggu', 'Dipanggil', 'Selesai'],
            'datasets' => [
                [
                    'label' => 'Jumlah Antrian',
                    'data' => [
                        $data['menunggu'] ?? 0,
                        $data['dipanggil'] ?? 0,
                        $data['selesai'] ?? 0,
                    ],
                    'backgroundColor' => ['#fbbf24', '#3b82f6', '#10b981'],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
