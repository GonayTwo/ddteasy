<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\BoringAvatarsProvider;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets;
use App\Http\Middleware\Auth\AdminMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\PriveServicesAdm;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->passwordReset()
            ->colors([
                'primary' => '#F28A20',
            ])
            ->defaultAvatarProvider(BoringAvatarsProvider::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                
            ])
            ->widgets([
                Widgets\PlataformOverview::class,
                Widgets\CompanyChart::class,
                Widgets\ActiveCompaniesChart::class,
                Widgets\LatestContacts::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                AdminMiddleware::class,
            ])
            ->navigationItems([
                NavigationItem::make('Carteira Digital')
                    ->icon('heroicon-o-credit-card')
                    ->url('https://id.pagar.me/signin')
                    ->openUrlInNewTab(),
            ])
            ->navigationGroups([
                NavigationGroup::make('Clientes'),
                NavigationGroup::make('Parceiros'),
                NavigationGroup::make('Serviços'),
                NavigationGroup::make('Institucional'),
                NavigationGroup::make('Contatos'),
                NavigationGroup::make('Termos'),
                NavigationGroup::make('Configurações'),
            ])
            ->sidebarCollapsibleOnDesktop();
    }
}
