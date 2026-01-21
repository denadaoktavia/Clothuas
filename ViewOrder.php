<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Order Information')
                    ->schema([
                        Components\TextEntry::make('id')
                            ->label('Order ID'),
                        Components\TextEntry::make('name')
                            ->label('Customer Name'),
                        Components\TextEntry::make('phone')
                            ->label('Phone Number'),
                        Components\TextEntry::make('address')
                            ->label('Shipping Address')
                            ->columnSpanFull(),                        
                    ])->columns(3),
                
                Components\Section::make('Order Items')
                    ->schema([
                        Components\RepeatableEntry::make('orderItems')
                            ->label('')
                            ->schema([
                                Components\TextEntry::make('product_name')
                                    ->label('Product'),
                                Components\TextEntry::make('quantity')
                                    ->label('Qty'),
                                Components\TextEntry::make('price')
                                    ->money('IDR')
                                    ->label('Price'),
                                Components\TextEntry::make('subtotal')
                                    ->money('IDR')
                                    ->label('Subtotal'),
                            ])
                            ->columns(4)
                    ]),
                
                Components\Section::make('Order Summary')
                    ->schema([
                        Components\TextEntry::make('sub_total')
                            ->money('IDR')
                            ->label('Subtotal'),
                        Components\TextEntry::make('total')
                            ->money('IDR')
                            ->label('Total')
                            ->weight('bold'),
                        Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Order Date'),
                    ])->columns(3),
            ]);
    }
}