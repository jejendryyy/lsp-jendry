<?php

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deskripsi')
                    ->label('Deskripsi Singkat')
                    ->limit(70)
                    ->wrap(),
                TextColumn::make('visi')
                    ->label('Visi')
                    ->limit(70)
                    ->wrap(),
                TextColumn::make('misi')
                    ->label('Misi')
                    ->limit(70)
                    ->wrap(),
            ])
            ->recordActions([
                EditAction::make(),
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
