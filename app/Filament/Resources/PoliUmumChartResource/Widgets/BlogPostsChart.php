<?php

namespace App\Filament\Resources\PoliUmumResource\Widgets;

use App\Models\PoliUmum;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Antrian Poli Umum';

    protected function getData(): array
    {
        $data = PoliUmum::selectRaw('LOWER(poli) as poli, status, COUNT(*) as total')
            ->groupBy('poli', 'status')
            ->get();

        $labels = ['poli 1', 'poli 2', 'poli 3'];
        $statusList = ['menunggu', 'dipanggil', 'selesai'];

        $datasets = [];

        foreach ($statusList as $status) {
            $dataSet = [];
            foreach ($labels as $poli) {
                $dataSet[] = $data->where('poli', $poli)->where('status', $status)->sum('total');
            }

            $datasets[] = [
                'label' => ucfirst($status),
                'data' => $dataSet,
                'backgroundColor' => match ($status) {
                    'menunggu' => '#fbbf24',
                    'dipanggil' => '#3b82f6',
                    'selesai' => '#10b981',
                    default => '#d1d5db',
                },
            ];
        }

        return [
            'labels' => array_map('ucfirst', $labels),
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                ],
            ],
        ];
    }
}
