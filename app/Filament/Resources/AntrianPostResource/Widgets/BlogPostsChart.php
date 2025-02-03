<?php

namespace App\Filament\Resources\AntrianPostResource\Widgets;

use App\Models\Antrian;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Antrian Poli Gigi';

    protected function getData(): array
    {
        $menunggu = Antrian::where('status', 'menunggu')->count();
        $dipanggil = Antrian::where('status', 'dipanggil')->count();
        $selesai = Antrian::where('status', 'selesai')->count();

        return [
            'labels' => ['Menunggu', 'Dipanggil', 'Selesai'],
            'datasets' => [
                [
                    'label' => 'Jumlah Pasien',
                    'data' => [$menunggu, $dipanggil, $selesai],  // Data untuk setiap status antrian
                    'backgroundColor' => ['#fbbf24', '#3b82f6', '#10b981'],  // Warna untuk setiap dataset
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Bisa ganti dengan tipe chart lain seperti 'bar', 'line', dll.
    }
}
