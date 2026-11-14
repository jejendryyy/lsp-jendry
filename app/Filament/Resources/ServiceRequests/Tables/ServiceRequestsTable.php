<?php

namespace App\Filament\Resources\ServiceRequests\Tables;

use App\Models\ServiceRequest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sender_name')
                    ->label('Nama pemohon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sender_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label('Layanan')
                    ->searchable(),
                TextColumn::make('sender_phone')
                    ->label('Nomor telepon')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        ServiceRequest::STATUS_WAITING => 'Menunggu',
                        ServiceRequest::STATUS_APPROVED => 'Disetujui',
                        ServiceRequest::STATUS_ACTIVE => 'Aktif',
                        ServiceRequest::STATUS_NONACTIVE => 'Non Aktif',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        ServiceRequest::STATUS_WAITING => 'warning',
                        ServiceRequest::STATUS_APPROVED => 'success',
                        ServiceRequest::STATUS_ACTIVE => 'success',
                        ServiceRequest::STATUS_NONACTIVE => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
