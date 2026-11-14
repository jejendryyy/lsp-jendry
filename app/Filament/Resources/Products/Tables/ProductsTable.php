<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public'),
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->searchable(),
                TextColumn::make('server_specs')
                    ->label('Spesifikasi Hardware')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
            ])
            ->filters([
                //
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
