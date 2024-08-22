<?php

namespace App\Filament\Pages;

use App\Models\Content\TermsOfUse as TermsOfUseModel;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;

class TermsOfUse extends Page
{
    protected static string $view = 'filament.pages.terms-of-use';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Termos de Uso';

    protected static ?string $navigationLabel = 'Termos de Uso';

    protected static ?string $navigationGroup = 'Termos';

    protected static ?string $slug = 'termos-de-uso';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public ?TermsOfUseModel $model;

    public function mount(): void
    {
        $this->model = TermsOfUseModel::first();
        $this->form->fill([
            'title' => $this?->model->title,
            'update_date' => $this?->model->update_date,
            'text' => $this?->model->text,
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
            Notification::make()->title('Sucesso!')->body('Termos de usos atualizados com sucesso!')->success()->send();

            return;
        }

        $this->model = TermsOfUseModel::create($data);
        Notification::make()->title('Sucesso!')->body('Termos de usos criados com sucesso!')->success()->send();
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Gerencie aqui o texto sobre os termos de uso da plataforma.';
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

    public function getModel(): ?TermsOfUseModel
    {
        return $this?->model ?? null;
    }
}
