<?php

namespace App\Filament\Partner\Resources\Partners;

use App\Filament\Partner\Resources\Partners\EmployeeResource\Pages;
use App\Models\Partners\Employee;
use App\Services\FindCep\FindCepService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'funcionário';

    protected static ?string $slug = 'funcionarios';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Informações')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\Group::make()->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Document::make('cpf')
                                    ->label('CPF')
                                    ->cpf()
                                    ->required(),
                                Forms\Components\Toggle::make('active')
                                    ->label('Ativo'),
                            ]),
                            Forms\Components\FileUpload::make('image')
                                ->label('Foto')
                                ->image()
                                ->imageEditor()
                                ->imageEditorMode(1)
                                ->imageCropAspectRatio('1:1')
                                ->disk('public'),
                        ])->columns(2),

                    Forms\Components\Section::make('Endereço')
                        ->icon('heroicon-o-map-pin')
                        ->relationship('address')
                        ->columns([
                            'sm' => 1,
                            'md' => 4,
                        ])
                        ->schema([
                            Forms\Components\TextInput::make('cep')
                                ->label('CEP')
                                ->mask('99999-999')
                                ->required()
                                ->dehydrateStateUsing(fn (string $state): string => str($state)->remove(['.', '-']))
                                ->suffixAction(
                                    fn ($state, Set $set) => Action::make('search-action')
                                        ->icon('heroicon-o-magnifying-glass')
                                        ->action(function () use ($state, $set) {
                                            $state = str($state)->remove(['.', '-']);
                                            if (blank($state)) {
                                                Notification::make()
                                                    ->warning()
                                                    ->title('Ops!')
                                                    ->body('Digite o CEP para buscar o endereço.')
                                                    ->color('warning')
                                                    ->send();

                                                return;
                                            }

                                            try {
                                                $addressData = FindCepService::cep()->get($state);
                                            } catch (\Exception) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Erro!')
                                                    ->body('Erro ao buscar pelo endereço.')
                                                    ->color('danger')
                                                    ->send();

                                                return;
                                            }

                                            $set('street', $addressData->street);
                                            $set('district', $addressData->district);
                                            $set('city', $addressData->city);
                                            $set('state', $addressData->state);
                                        })
                                ),
                            Forms\Components\TextInput::make('street')
                                ->label('Endereço')
                                ->readOnly()
                                ->columnSpan([
                                    'sm' => 'full',
                                    'md' => 2,
                                ]),
                            Forms\Components\TextInput::make('number')
                                ->label('Número')
                                ->required()->columnSpan([
                                    'sm' => 'full',
                                    'md' => 1,
                                ]),
                            Forms\Components\TextInput::make('complement')
                                ->label('Complemento'),
                            Forms\Components\TextInput::make('district')
                                ->label('Bairro')
                                ->readOnly(),
                            Forms\Components\TextInput::make('city')
                                ->label('Cidade')
                                ->readOnly(),
                            Forms\Components\TextInput::make('state')
                                ->label('Estado')
                                ->readOnly(),
                            Forms\Components\Hidden::make('country')
                                ->default('BR'),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Criado em')
                                ->content(fn ($record): string => $record?->created_at ? $record->created_at->format('d/m/Y H:i:s') : '-'),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Atualizado em')
                                ->content(fn ($record): string => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i:s') : '-'),
                            Forms\Components\Placeholder::make('deleted_at')
                                ->label('Excluído em')
                                ->content(fn ($record): string => $record?->deleted_at ? $record->deleted_at->format('d/m/Y H:i:s') : '-'),
                        ])
                        ->hidden(fn (?Employee $record) => $record === null),

                    Forms\Components\Section::make()->schema([
                        Forms\Components\Repeater::make('phones')
                            ->label('Telefones')
                            ->required()
                            ->columnSpanFull()
                            ->simple(PhoneNumber::make('phone')
                                ->format('(99) 99999-9999')
                                ->label('Número')
                                ->required()),

                    ]),
                ])->columnSpan(['lg' => 1]),
            ])->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->size(60),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Employee::count();
    }
}
