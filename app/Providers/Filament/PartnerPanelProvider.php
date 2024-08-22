<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\BoringAvatarsProvider;
use App\Filament\Partner\Pages\Auth\EditProfile;
use App\Filament\Partner\Pages\Auth\Login;
use App\Filament\Partner\Pages\Dashboard;
use App\Filament\Partner\Pages\Tenancy\EditCompanyProfile;
use App\Filament\Partner\Widgets;
use App\Filament\Widgets\CalendarWidget;
use App\Http\Middleware\Auth\PartnerMiddleware;
use App\Models\Partners\Company;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class PartnerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('partner')
            ->path('parceiros')
            ->tenant(Company::class, slugAttribute: 'slug')
            ->tenantProfile(EditCompanyProfile::class)
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->passwordReset()
            ->colors([
                'primary' => '#F28A20',
            ])
            ->defaultAvatarProvider(BoringAvatarsProvider::class)
            ->discoverResources(in: app_path('Filament/Partner/Resources'), for: 'App\\Filament\\Partner\\Resources')
            ->discoverPages(in: app_path('Filament/Partner/Pages'), for: 'App\\Filament\\Partner\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                CalendarWidget::class,
                Widgets\CompanyOverview::class,
                Widgets\LatestOrders::class,
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
                PartnerMiddleware::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('Agendamentos'),
                NavigationGroup::make('Empresa'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->selectable()
            );
    }
}
