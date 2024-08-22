<?php

namespace App\Filament\Widgets;

use App\Enums\ContactStatus;
use App\Filament\Resources\Contacts\ContactResource;
use App\Models\Contacts\Contact;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContacts extends BaseWidget
{
    protected static ?string $heading = 'Contatos';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Contact::orderByDesc('created_at')->where('status', ContactStatus::New))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->formatStateUsing(fn (?string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                Tables\Columns\TextColumn::make('message')
                    ->label('Mensagem')
                    ->limit(25),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Contact $record): string => ContactResource::getUrl('view', ['record' => $record])),
            ])
            ->headerActions([
                Tables\Actions\Action::make('all')
                    ->label('Ver Mais')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(ContactResource::getUrl('index')),
            ]);
    }
}
