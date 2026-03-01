<?php

namespace App\Filament\Pages;

use App\Models\Product;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class Checkout extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.checkout';

    public static string|BackedEnum|null $navigationIcon = LucideIcon::ScanBarcode;

    public ?array $cart = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('barcode_input')
                            ->autofocus()
                            ->live(debounce: 300)
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                if (empty($state)) {
                                    return;
                                }

                                $productCode = substr($state, 0, 4);
                                $product = Product::where('code', $productCode)->first();

                                if ($product) {
                                    $cart = $get('cart') ?? [];

                                    $existingIndex = collect($cart)->search(fn ($item) => $item['product_id'] === $product->id);

                                    if ($existingIndex !== false) {
                                        $cart[$existingIndex]['quantity'] += 1;
                                    } else {
                                        $cart[] = [
                                            'product_id' => $product->id,
                                            'product_name' => $product->name,
                                            'quantity' => 1,
                                        ];
                                    }

                                    $set('cart', $cart);
                                    $set('barcode_input', '');
                                } else {
                                    Notification::make()->warning()->title('Produk tidak ditemukan!')->send();
                                    $set('barcode_input', '');
                                }
                            }),
                    ]),

                Section::make()
                    ->schema([
                        Repeater::make('cart')
                            ->schema([
                                Hidden::make('product_id'),
                                TextInput::make('product_name')
                                    ->disabled()
                                    ->columnSpan(2),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->reorderable(false),
                    ]),
            ])
            ->statePath('cart');
    }
}
