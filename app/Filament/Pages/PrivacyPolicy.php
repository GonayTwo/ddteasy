<?php

namespace App\Filament\Pages;

use App\Models\Content\PrivacyPolicy as PrivacyPolicyModel;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;

class PrivacyPolicy extends Page
{
    protected static string $view = 'filament.pages.privacy-policy';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Política de Privacidade';

    protected static ?string $navigationLabel = 'Política de Privacidade';

    protected static ?string $navigationGroup = 'Termos';

    protected static ?string $slug = 'politica-de-privacidade';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public ?PrivacyPolicyModel $model;

    public function mount(): void
    {
        $this->model = PrivacyPolicyModel::first();
        $this->form->fill([
            'title' => $this->model?->title,
            'update_date' => $this->model?->update_date,
            'text' => $this->model?->text,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Components\Section::make('Informações Adicionais')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        Components\Placeholder::make('created_at')
                            ->label('Criado em:')
                            ->content($this->getModel() != null ? $this->getModel()->created_at?->format('d/m/Y H:i:s') : 'Nunca'),
                        Components\Placeholder::make('updated_at')
                            ->label('Atualizado em:')
                            ->content($this->getModel() != null ? $this->getModel()->updated_at?->format('d/m/Y H:i:s') : 'Nunca'),
                    ]),
                Components\Section::make($this->getNavigationLabel())
                    ->icon($this->getNavigationIcon())
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Título da Página')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),
                        Components\DatePicker::make('update_date')
                            ->label('Data de Atualização')
                            ->required(),
                        Components\RichEditor::make('text')
                            ->label('Texto')
                            ->required()
                            ->disableToolbarButtons(['attachFiles'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if ($this->getModel()) {
            $this->getModel()->update($data);
            Notification::make()->title('Sucesso!')->body('Contrato de Parceria atualizado com sucesso!')->success()->send();

            return;
        }

        $this->model = PrivacyPolicyModel::create($data);
        Notification::make()->title('Sucesso!')->body('Contrato de Parceria criado com sucesso!')->success()->send();
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Gerencie aqui o texto sobre as políticas de privacidade da plataforma.';
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('back')
            ->label('Voltar')
            ->url(filament()->getUrl())
            ->icon('heroicon-o-arrow-left')
            ->color('gray');
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::End;
    }

    public function getModel(): ?PrivacyPolicyModel
    {
        return $this?->model ?? null;
    }
}
