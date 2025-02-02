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
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
                        'poli_1' => 'Poli 1',
                        'poli_2' => 'Poli 2',
                        'poli_3' => 'Poli 3',
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
            ->filters([
                Tables\Filters\SelectFilter::make('poli')
                    ->options([
                        'poli_1' => 'Poli 1',
                        'poli_2' => 'Poli 2',
                        'poli_3' => 'Poli 3',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('panggil')
                    ->label('Panggil')
                    ->form([
                        Forms\Components\Select::make('poli_tujuan')
                            ->options([
                                'poli_1' => 'Poli 1',
                                'poli_2' => 'Poli 2',
                                'poli_3' => 'Poli 3',
                            ])
                            ->required()
                    ])
                    ->action(fn(PoliUmum $record, array $data) => $record->update(['status' => 'dipanggil', 'poli' => $data['poli_tujuan']]))
                    ->visible(fn(PoliUmum $record) => $record->status === 'menunggu'),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(function (PoliUmum $record) {
                        if ($record->poli === 'poli_1') {
                            $record->update(['poli' => 'poli_2', 'status' => 'menunggu']);
                        } elseif ($record->poli === 'poli_2') {
                            $record->update(['poli' => 'poli_3', 'status' => 'menunggu']);
                        } else {
                            $record->update(['status' => 'selesai']);
                        }
                    })
                    ->visible(fn(PoliUmum $record) => $record->status === 'dipanggil'),
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
