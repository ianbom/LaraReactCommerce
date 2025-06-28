<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight; // Pastikan ini diimpor jika digunakan

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $modelLabel = 'Product';

    protected static ?string $pluralModelLabel = 'Products';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('brand')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->step(1000),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('thumbnail_url')
                            ->label('Thumbnail Image')
                            ->image()
                            ->directory('products/thumbnails')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->nullable()
                            ->openable()
                            ->deletable(true)
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('Upload a thumbnail image for the product. You can remove it anytime.')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Stock & Rating')
                    ->schema([
                        Forms\Components\TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(1),

                        Forms\Components\TextInput::make('avg_rating')
                            ->label('Average Rating')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5)
                            ->nullable(),

                        Forms\Components\TextInput::make('total_stars')
                            ->label('Total Stars')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),

                        Forms\Components\TextInput::make('rating_count')
                            ->label('Rating Count')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Product Images')
                    ->schema([
                        Forms\Components\Repeater::make('productImages')
                            ->label('Additional Images')
                            ->relationship('productImages')
                            ->schema([
                                Forms\Components\FileUpload::make('image_url')
                                    ->label('Image')
                                    ->image()
                                    ->directory('products/gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '16:9',
                                    ])
                                    ->openable()
                                    ->required(),
                                // Anda bisa menambahkan field lain di sini jika dibutuhkan,
                                // misalnya Forms\Components\TextInput::make('caption')
                            ])
                            ->columns(1)
                            ->collapsed(false)
                            ->itemLabel(function (array $state): ?string {
                                // Ambil nilai image_url, pastikan itu string atau null
                                $imageUrl = $state['image_url'] ?? null;

                                if (is_null($imageUrl) || (is_array($imageUrl) && empty($imageUrl))) {
                                    // Jika null, array kosong, atau belum diisi
                                    return 'New Image';
                                }

                                // Jika ini adalah string (path gambar yang sudah disimpan)
                                if (is_string($imageUrl)) {
                                    return 'Image: ' . basename($imageUrl);
                                }

                                // Jika ini adalah array (misalnya, saat upload baru, atau multiple file upload)
                                // Handle kasus di mana $imageUrl mungkin array dari string atau objek File
                                if (is_array($imageUrl)) {
                                    // Coba ambil nama file pertama dari array, jika ada
                                    $firstImage = reset($imageUrl); // Mengambil elemen pertama tanpa error jika array kosong
                                    if (is_string($firstImage)) {
                                        return 'Image: ' . basename($firstImage);
                                    }
                                    // Jika elemen pertama bukan string (misal objek UploadedFile)
                                    return 'Image: Uploaded';
                                }

                                return 'Image: Unknown'; // Fallback jika tidak sesuai semua kondisi
                            })
                            ->addActionLabel('Add Image')
                            ->reorderable()
                            ->collapsible()
                            ->minItems(0)
                            ->maxItems(10),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Image')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(fn (): string => asset('images/no-image-placeholder.png'))
                    ->checkFileExistence(false),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('avg_rating')
                    ->label('Rating')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn (?float $state): string =>
                        $state ? number_format($state, 1) . ' ⭐' : 'No rating'
                    ),

                Tables\Columns\TextColumn::make('product_images_count')
                    ->label('Images')
                    ->counts('productImages')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (int $state): string =>
                        $state . ' ' . str($state === 1 ? 'image' : 'images')->plural()
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->options(function () {
                        return Product::distinct('brand')
                            ->whereNotNull('brand')
                            ->orderBy('brand')
                            ->pluck('brand', 'brand')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('stock_status')
                    ->form([
                        Forms\Components\Select::make('stock_level')
                            ->options([
                                'in_stock' => 'In Stock',
                                'low_stock' => 'Low Stock (≤10)',
                                'out_of_stock' => 'Out of Stock',
                            ])
                            ->placeholder('Select stock level')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['stock_level'] === 'out_of_stock',
                            fn (Builder $query): Builder => $query->where('stock', '<=', 0),
                        )->when(
                            $data['stock_level'] === 'low_stock',
                            fn (Builder $query): Builder => $query->where('stock', '>', 0)->where('stock', '<=', 10),
                        )->when(
                            $data['stock_level'] === 'in_stock',
                            fn (Builder $query): Builder => $query->where('stock', '>', 10),
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['stock_level']) {
                            return null;
                        }

                        return 'Stock: ' . match ($data['stock_level']) {
                            'in_stock' => 'In Stock',
                            'low_stock' => 'Low Stock',
                            'out_of_stock' => 'Out of Stock',
                        };
                    }),

                Tables\Filters\Filter::make('price_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price_from')
                                    ->label('Price From')
                                    ->numeric()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('price_to')
                                    ->label('Price To')
                                    ->numeric()
                                    ->prefix('Rp'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn (Builder $query, $price): Builder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['price_to'],
                                fn (Builder $query, $price): Builder => $query->where('price', '<=', $price),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['price_from'] && ! $data['price_to']) {
                            return null;
                        }

                        $from = $data['price_from'] ? 'Rp ' . number_format($data['price_from'], 0, ',', '.') : null;
                        $to = $data['price_to'] ? 'Rp ' . number_format($data['price_to'], 0, ',', '.') : null;

                        if ($from && $to) {
                            return "Price: {$from} - {$to}";
                        }

                        return $from ? "Price: ≥ {$from}" : "Price: ≤ {$to}";
                    }),

                Tables\Filters\Filter::make('has_rating')
                    ->label('Has Rating')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('avg_rating')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
