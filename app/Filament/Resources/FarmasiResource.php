<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmasiResource\Pages;
use App\Filament\Resources\FarmasiResource\RelationManagers;
use App\Models\Farmasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;

class FarmasiResource extends Resource
{
    protected static ?string $model = Farmasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $pluralModelLabel = 'Data antrian farmasi';
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
                    ->default(Farmasi::generateNomorAntrian()),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('panggil')
                    ->label('Panggil')
                    ->action(fn(Farmasi $record) => $record->update(['status' => 'dipanggil']))
                    ->visible(fn(Farmasi $record) => $record->status === 'menunggu'),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(fn(Farmasi $record) => $record->update(['status' => 'selesai']))
                    ->visible(fn(Farmasi $record) => $record->status === 'dipanggil'),
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
            'index' => Pages\ListFarmasis::route('/'),
            'create' => Pages\CreateFarmasi::route('/create'),
            'edit' => Pages\EditFarmasi::route('/{record}/edit'),
        ];
    }
}
