<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Product Information')
                    ->schema([
                        // Thumbnail Image
                        Infolists\Components\ImageEntry::make('thumbnail_url')
                            ->label('Thumbnail')
                            ->size(200) // Ukuran gambar
                            ->square() // Memaksa rasio 1:1
                            ->extraAttributes(['class' => 'rounded-lg']) // Tambahan Tailwind CSS
                            ->disk('public') // Pastikan ini mengarah ke disk 'public' di config/filesystems.php
                            ->defaultImageUrl(url('/placeholder-image.jpg')), // Opsional: gambar placeholder jika tidak ada thumbnail

                        // Product Name
                        Infolists\Components\TextEntry::make('name')
                            ->label('Product Name')
                            ->size('lg')
                            ->weight('bold'),

                        // Brand (using relationship if applicable, otherwise direct column)
                        // Jika 'brand' adalah kolom langsung di tabel products
                        Infolists\Components\TextEntry::make('brand')
                             ->badge(),
                        // Jika 'brand' adalah relasi ke tabel brands (misal product->brand->name)
                        // Infolists\Components\TextEntry::make('brand.name')
                        //     ->label('Brand')
                        //     ->badge(),

                        // Description
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull()
                            ->markdown(), // Jika deskripsi adalah markdown

                        // Price
                        Infolists\Components\TextEntry::make('price')
                            ->money('IDR') // Format mata uang Rupiah Indonesia
                            ->size('lg')
                            ->weight('bold'),

                        // Stock
                        Infolists\Components\TextEntry::make('stock')
                            ->badge()
                            ->color(fn ($state): string => match (true) {
                                $state <= 0 => 'danger',
                                $state <= 10 => 'warning',
                                default => 'success',
                            }),
                    ])
                    ->columns(3), // Tata letak 3 kolom untuk section ini

                // Rating Information (visible only if avg_rating exists)
                Infolists\Components\Section::make('Rating Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('avg_rating')
                            ->label('Average Rating')
                            ->badge()
                            ->color('warning')
                            ->formatStateUsing(fn ($state): string =>
                                $state ? number_format((float) $state, 1) . ' ⭐' : 'No rating'
                            ),

                        Infolists\Components\TextEntry::make('total_stars')
                            ->label('Total Stars'),

                        Infolists\Components\TextEntry::make('rating_count')
                            ->label('Rating Count'),
                    ])
                    ->columns(3)
                    ->visible(fn ($record): bool => $record->avg_rating !== null),

                // Product Images (Gallery)
                Infolists\Components\Section::make('Product Images')
                    ->description('A comprehensive look at all product angles.') // Tambahkan deskripsi untuk konteks
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('productImages')
                            ->label('Product Gallery') // Label yang lebih deskriptif
                            ->schema([
                                Infolists\Components\ImageEntry::make('image_url')
                                    ->label('') // Label kosong karena setiap gambar akan memiliki judul di bawahnya
                                    ->size(150)
                                    ->square()
                                    ->extraAttributes(['class' => 'rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200']) // Tambahan shadow dan transisi
                                    ->disk('public'),

                                
                            ])
                            // Grid responsif: 4 kolom di layar besar, 2 di layar sedang, 1 di layar kecil
                            ->grid([
                                'default' => 1,
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                            ])
                            ->columns(4) // Ini mengatur default grid untuk repeatable entry itu sendiri
                            ->contained(false) // Memastikan konten repeatable entry tidak memiliki padding ekstra dari "card"
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record): bool => $record->productImages->count() > 0)
                    ->collapsible()
                    ->compact(), // Opsi: membuat section lebih ringkas
                // Timestamps
                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->collapsible(), // Section bisa dilipat
            ]);
    }
}
