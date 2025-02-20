<?php

namespace App\Filament\Resources\Partners;

use App\Enums\CompanyStatus;
use App\Filament\Resources\Partners\CompanyResource\Pages;
use App\Models\Partners\Company;
use App\Models\Partners\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $recordTitleAttribute = 'fantasy_name';

    protected static ?string $modelLabel = 'empresa';

    protected static ?string $navigationGroup = 'Parceiros';

    protected static ?string $slug = 'empresas';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->columnSpan(3)
                            ->schema([
                                Forms\Components\Placeholder::make('fantasy_name')
                                    ->label('Nome Fantasia:')
                                    ->content(fn ($state) => $state),
                                Forms\Components\Placeholder::make('corporate_name')
                                    ->label('Razão Social:')
                                    ->content(fn ($state) => $state),

                                Forms\Components\Placeholder::make('cnpj')
                                    ->label('CNPJ:')
                                    ->content(fn ($state) => $state)
                                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $state)),
                                Forms\Components\Select::make('status')
                                    ->label('Status:')
                                    ->options(CompanyStatus::class)
                                    ->native(false),

                                // Forms\Components\FileUpload::make('social_contract')
                                //     ->label('Contrato Social:')
                                //     ->disabled()
                                //     ->deletable(false)
                                //     ->openable(),
                                Forms\Components\FileUpload::make('sanitary_license')
                                    ->label('Licença Sanitária:')
                                    ->disabled()
                                    ->deletable(false)
                                    ->openable(),
                            ]),

                        Forms\Components\Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo:')
                                    ->disabled()
                                    ->columnSpanFull()
                                    ->deletable(false),
                            ]),

                        Forms\Components\Fieldset::make('Endereço')
                            ->columns(3)
                            ->columnSpanFull()
                            ->relationship('address')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Placeholder::make('street')
                                    ->label('Endereço')
                                    ->content(fn ($state) => $state)
                                    ->columnSpan(2),
                                Forms\Components\Placeholder::make('number')
                                    ->label('Número')
                                    ->content(fn ($state) => $state),
                                Forms\Components\Placeholder::make('complement')
                                    ->label('Complemento')
                                    ->content(fn ($state) => $state),
                                Forms\Components\Placeholder::make('cep')
                                    ->label('CEP')
                                    ->content(fn ($state) => $state)
                                    ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{5})(\d{3})/", '$1-$2', $state)),
                                Forms\Components\Placeholder::make('district')
                                    ->label('Bairro')
                                    ->content(fn ($state) => $state),
                                Forms\Components\Placeholder::make('city')
                                    ->label('Cidade')
                                    ->content(fn ($state) => $state),
                                Forms\Components\Placeholder::make('state')
                                    ->label('Estado')
                                    ->content(fn ($state) => $state),
                            ]),

                        Forms\Components\Fieldset::make('Informações Bancárias')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\Placeholder::make('bank')
                                    ->label('Banco')
                                    ->content(fn (Company $record): ?string => $record?->bank),
                                Forms\Components\Placeholder::make('agency')
                                    ->label('Agência')
                                    ->content(fn (Company $record): ?string => $record?->agency),
                                Forms\Components\Placeholder::make('checking_account')
                                    ->label('Conta Corrente')
                                    ->content(fn (Company $record): ?string => $record?->checking_account),
                            ]),

                        Forms\Components\Fieldset::make('Informações Adicionais')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Criado em:')
                                    ->content(fn (Company $record): ?string => $record?->created_at?->format('d/m/Y H:i') ?? 'Nunca'),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Atualizado em:')
                                    ->content(fn (Company $record): ?string => $record?->updated_at?->format('d/m/Y H:i') ?? 'Nunca'),
                                Forms\Components\Placeholder::make('deleted_at')
                                    ->label('Excluído em:')
                                    ->content(fn (Company $record): ?string => $record?->deleted_at?->format('d/m/Y H:i') ?? 'Nunca'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('corporate_name')
                    ->label('Razão Social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnpj')
                    ->label('CNPJ')
                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address.city')
                    ->label('Cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address.state')
                    ->label('UF')
                    ->badge()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->defaultImageUrl(fn (?Company $record): string => "https://ui-avatars.com/api/?name={$record->fantasy_name}&background=4a1d96&color=f28a20&bold=true")
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->color('secondary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->color('secondary')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->color('secondary')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label(' '),
                Tables\Actions\EditAction::make()->label(' '),
            ])
            ->bulkActions([])
            ->emptyStateActions([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns(4)
                    ->schema([
                        Infolists\Components\Group::make()
                            ->columns(3)
                            ->columnSpan(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('fantasy_name')
                                    ->label('Nome Fantasia'),

                                Infolists\Components\TextEntry::make('corporate_name')
                                    ->label('Razão Social'),

                                Infolists\Components\TextEntry::make('cnpj')
                                    ->label('CNPJ')
                                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $state)),

                                // Infolists\Components\TextEntry::make('social_contract')
                                //     ->label('Contrato Social')
                                //     ->badge()
                                //     ->formatStateUsing(fn (): string => 'Contrato Social')
                                //     ->icon('heroicon-o-document')
                                //     ->url(fn (Company $record): string => Storage::url($record->social_contract))
                                //     ->openUrlInNewTab(),

                                Infolists\Components\TextEntry::make('sanitary_license')
                                    ->label('Licença Sanitária')
                                    ->badge()
                                    ->formatStateUsing(fn (): string => 'Licença Sanitária')
                                    ->icon('heroicon-o-document')
                                    ->url(fn (Company $record): string => Storage::url($record->sanitary_license))
                                    ->openUrlInNewTab(),

                                Infolists\Components\TextEntry::make('status')
                                    ->badge(),
                            ]),
                        Infolists\Components\Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Infolists\Components\ImageEntry::make('logo')
                                    ->label('Logo')
                                    ->circular()
                                    ->columnSpanFull(),
                            ]),

                        Infolists\Components\Fieldset::make('Endereço')
                            ->columns(3)
                            ->columnSpanFull()
                            ->relationship('address')
                            ->columns(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('cep')
                                    ->label('CEP')
                                    ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{5})(\d{3})/", '$1-$2', $state)),
                                Infolists\Components\TextEntry::make('street')
                                    ->label('Endereço'),
                                Infolists\Components\TextEntry::make('number')
                                    ->label('Número'),
                                Infolists\Components\TextEntry::make('complement')
                                    ->label('Complemento'),
                                Infolists\Components\TextEntry::make('district')
                                    ->label('Bairro'),
                                Infolists\Components\TextEntry::make('city')
                                    ->label('Cidade'),
                                Infolists\Components\TextEntry::make('state')
                                    ->label('Estado'),
                            ]),

                        Infolists\Components\Fieldset::make('Informações Bancárias')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                Infolists\Components\TextEntry::make('bank')
                                    ->label('Banco:'),
                                Infolists\Components\TextEntry::make('agency')
                                    ->label('Agência:'),
                                Infolists\Components\TextEntry::make('checking_account')
                                    ->label('Conta Corrente:'),
                            ]),

                        Infolists\Components\Fieldset::make('Informações Adicionais')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Criado em:')
                                    ->dateTime('d/m/Y H:i:s'),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Atualizado em:')
                                    ->dateTime('d/m/Y H:i:s'),
                                Infolists\Components\TextEntry::make('deleted_at')
                                    ->label('Excluído em:')
                                    ->dateTime('d/m/Y H:i:s'),
                            ]),
                    ]),
                Infolists\Components\Section::make('Parceiros')
                    ->description('Todos os parceiros pertencentes a esta empresa')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('partners')
                            ->label('')
                            ->columns(4)
                            ->schema([
                                Infolists\Components\ImageEntry::make('user.avatar')
                                    ->label('Avatar:')
                                    ->defaultImageUrl(fn (?Partner $record): string => "https://source.boringavatars.com/beam/120/{$record->full_name}?colors=f28a20,4a1d96")
                                    ->circular()
                                    ->size(50),
                                Infolists\Components\TextEntry::make('full_name')
                                    ->label('Nome:'),
                                Infolists\Components\TextEntry::make('role')
                                    ->label('Cargo:')
                                    ->formatStateUsing(fn (?Partner $record): string => $record->role->getLabel()),
                                Infolists\Components\TextEntry::make('cpf')
                                    ->label('CPF:')
                                    ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", '$1.$2.$3-$4', $state)),
                                Infolists\Components\TextEntry::make('user.email')
                                    ->label('Email:')
                                    ->copyable()
                                    ->copyMessage('Copiado para a área de transferência!')
                                    ->copyMessageDuration(1500),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Telefone:')
                                    ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{2})(\d{5})(\d{4})/", '($1) $2-$3', $state))
                                    ->copyable()
                                    ->copyMessage('Copiado para a área de transferência!')
                                    ->copyMessageDuration(1500),
                                Infolists\Components\TextEntry::make('consent')
                                    ->label('Consentimento:')
                                    ->badge()
                                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-hand-thumb-up' : 'heroicon-o-hand-thumb-down')
                                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                                Infolists\Components\TextEntry::make('contact_methods')
                                    ->label('Métodos de Contato:')
                                    ->badge(),
                            ]),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
            'view' => Pages\ViewCompany::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
