<?php

namespace App\Filament\Resources\ProductRequests\Pages;

use App\Filament\Resources\ProductRequests\ProductRequestResource;
use App\Models\ProductInbound;
use App\Models\ProductOutbound;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ProcessProductRequest extends Page implements HasSchemas, HasTable
{
    use InteractsWithRecord, InteractsWithSchemas, InteractsWithTable;

    protected static string $resource = ProductRequestResource::class;

    protected string $view = 'filament.resources.product-requests.pages.process-product-request';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->form->fill();
    }

    public function scan($barcode)
    {
        if (! $barcode) {
            return;
        }

        $inbound = ProductInbound::where('barcode', $barcode)->first();

        if (! $inbound) {
            Notification::make()
                ->title('Barcode tidak ditemukan')
                ->danger()
                ->send();

            return;
        }

        // Refresh record dulu sebelum semua pengecekan
        $this->record->refresh();

        $item = $this->record
            ->items()
            ->where('product_id', $inbound->product_id)
            ->first();

        if (! $item) {
            Notification::make()
                ->title('Produk tidak ada dalam request')
                ->danger()
                ->send();

            return;
        }

        if ($item->quantity_fulfilled >= $item->quantity_requested) {
            // Cek apakah semua item sudah terpenuhi, lalu redirect
            $remaining = $this->record
                ->items()
                ->whereColumn('quantity_requested', '>', 'quantity_fulfilled')
                ->exists();

            if (! $remaining) {
                $this->record->update(['status' => 'completed']);

                Notification::make()
                    ->title('Request selesai')
                    ->body('Semua barang telah dipenuhi')
                    ->success()
                    ->send();

                $this->redirect(ProductRequestResource::getUrl('index'));

                return;
            }

            Notification::make()
                ->title('Jumlah produk sudah terpenuhi')
                ->warning()
                ->send();

            return;
        }

        try {
            DB::transaction(function () use ($inbound, $item) {
                $inbound = ProductInbound::lockForUpdate()->find($inbound->id);
                $item = $this->record
                    ->items()
                    ->lockForUpdate()
                    ->where('id', $item->id)
                    ->first();

                if ($inbound->quantity_remaining <= 0) {
                    throw new \Exception('stock_habis');
                }

                ProductOutbound::create([
                    'product_request_item_id' => $item->id,
                    'product_inbound_id' => $inbound->id,
                    'quantity_out' => 1,
                    'outbound_date' => now(),
                ]);

                $inbound->decrement('quantity_remaining');
                $item->increment('quantity_fulfilled');
            });
        } catch (\Exception $e) {
            if ($e->getMessage() === 'stock_habis') {
                Notification::make()
                    ->title('Stock batch sudah habis')
                    ->danger()
                    ->send();
            } else {
                Notification::make()
                    ->title('Terjadi kesalahan')
                    ->body($e->getMessage())
                    ->danger()
                    ->send();
            }

            return;
        }

        $this->record->refresh();

        $remaining = $this->record
            ->items()
            ->whereColumn('quantity_requested', '>', 'quantity_fulfilled')
            ->exists();

        if (! $remaining) {
            $this->record->update(['status' => 'completed']);

            Notification::make()
                ->title('Request selesai')
                ->body('Semua barang telah dipenuhi')
                ->success()
                ->send();

            $this->redirect(ProductRequestResource::getUrl('index'));

            return;
        }

        Notification::make()
            ->title('Scan berhasil')
            ->success()
            ->send();

        $this->form->fill(['barcode' => null]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('barcode')
                            ->live(debounce: 300)
                            ->afterStateUpdated(fn ($state) => $this->scan($state)),

                    ]),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->record->items())
            ->columns([
                TextColumn::make('product.name'),
                TextColumn::make('quantity_fulfilled'),
                TextColumn::make('quantity_requested'),
            ])
            ->paginated(false);
    }
}
