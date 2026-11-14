<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Models\ServiceRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sender_name')
                    ->label('Nama pemohon')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('sender_email')
                    ->label('Email pemohon')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('sender_phone')
                    ->label('Nomor telepon')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('product_id')
                    ->label('Layanan')
                    ->formatStateUsing(fn (?string $state, ServiceRequest $record): string => $record->product->name)
                    ->disabled()
                    ->dehydrated(false),
                Textarea::make('message')
                    ->label('Pesan')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        ServiceRequest::STATUS_WAITING => 'Menunggu',
                        ServiceRequest::STATUS_APPROVED => 'Disetujui',
                        ServiceRequest::STATUS_ACTIVE => 'Aktif',
                        ServiceRequest::STATUS_NONACTIVE => 'Non Aktif',
                    ])
                    ->required(),
            ]);
    }
}
