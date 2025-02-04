<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AntrianResource\Pages;
use App\Filament\Resources\AntrianResource\RelationManagers;
use App\Models\Antrian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\View;

class AntrianResource extends Resource
{
    protected static ?string $model = Antrian::class;

    protected static ?string $pluralModelLabel = 'Data antrian poli gigi';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function getNavigationGroup(): ?string
    {
        return 'Data antrian';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pasien')
                    ->required(),
                Forms\Components\TextInput::make('nomor_antrian')
                    ->disabled()
                    ->default(Antrian::generateNomorAntrian()),
                Forms\Components\Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ])->default('menunggu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_antrian')->sortable(),
                Tables\Columns\TextColumn::make('nama_pasien')->sortable()->searchable(),
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
                    ->action(fn(Antrian $record) => $record->update(['status' => 'dipanggil']))
                    ->visible(fn(Antrian $record) => $record->status === 'menunggu'),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(fn(Antrian $record) => $record->update(['status' => 'selesai']))
                    ->visible(fn(Antrian $record) => $record->status === 'dipanggil'),
                Action::make('cetak')
                    ->label('Cetak Struk')
                    ->action(function (Antrian $record) {
                        return redirect()->route('antrian.print', ['id' => $record->id]);
                    })
                    ->icon('heroicon-o-printer'),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAntrians::route('/'),
            'create' => Pages\CreateAntrian::route('/create'),
            'edit' => Pages\EditAntrian::route('/{record}/edit'),
        ];
    }
}
