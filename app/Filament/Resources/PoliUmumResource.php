<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoliUmumResource\Pages;
use App\Models\PoliUmum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;

class PoliUmumResource extends Resource
{
    protected static ?string $model = PoliUmum::class;
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $pluralModelLabel = 'Data antrian Poli Umum';

    public static function getNavigationGroup(): ?string
    {
        return 'Data antrian';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pasien')->required(),
                Forms\Components\TextInput::make('nomor_antrian')
                    ->disabled()
                    ->default(PoliUmum::generateNomorAntrian()),
                Forms\Components\Select::make('poli')
                    ->options([
                        'poli 1' => 'Poli 1',
                        'poli 2' => 'Poli 2',
                        'poli 3' => 'Poli 3',
                    ])
                    ->required()
                    ->default('poli_1'),
                Forms\Components\Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ])
                    ->default('menunggu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_antrian')->sortable(),
                Tables\Columns\TextColumn::make('nama_pasien')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('poli')->sortable(),
                BadgeColumn::make('status')
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'dipanggil' => 'primary',
                        'selesai' => 'success',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\Action::make('panggil')
                    ->label('Panggil')
                    ->form([
                        Forms\Components\Select::make('poli_tujuan')
                            ->options([
                                'poli 1' => 'Poli 1',
                                'poli 2' => 'Poli 2',
                                'poli 3' => 'Poli 3',
                            ])
                            ->required()
                    ])
                    ->action(fn(PoliUmum $record, array $data) => $record->update(['status' => 'dipanggil', 'poli' => $data['poli_tujuan']]))
                    ->visible(fn(PoliUmum $record) => $record->status === 'menunggu'),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(function (PoliUmum $record) {
                        if ($record->poli === 'poli 1') {
                            $record->update(['poli' => 'poli 1', 'status' => 'selesai']);
                        } elseif ($record->poli === 'poli 2') {
                            $record->update(attributes: ['poli' => 'poli 2', 'status' => 'selesai']);
                        } elseif ($record->poli === 'poli 3') {
                            $record->update(['status' => 'selesai']);
                        }
                    })
                    ->visible(fn(PoliUmum $record) => $record->status === 'dipanggil'),
                Tables\Actions\Action::make('cetak_nomor_antrian')
                    ->label('Cetak Struk')
                    ->url(fn(PoliUmum $record) => route('poliumum.cetak', ['id' => $record->id]))
                    ->icon('heroicon-o-printer')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoliUmums::route('/'),
            'create' => Pages\CreatePoliUmum::route('/create'),
            'edit' => Pages\EditPoliUmum::route('/{record}/edit'),
        ];
    }
}
