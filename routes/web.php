<?php

use App\Http\Controllers\PagarmeController;
use Illuminate\Support\Facades\Route;

Route::name('site.')->group(function () {
    Route::get('/', \App\Livewire\Web\Home::class)->name('index');
    Route::get('/home', \App\Livewire\Web\Home::class)->name('home');
    Route::get('/faq', \App\Livewire\Web\Faq::class)->name('faq');
    Route::get('/servicos', \App\Livewire\Web\Services::class)->name('services');
    Route::get('/como-funciona', \App\Livewire\Web\HowTo::class)->name('how-to');
    Route::get('/termos-de-uso', \App\Livewire\Web\TermsOfUse::class)->name('terms-of-use');
    Route::get('/politica-de-privacidade', \App\Livewire\Web\PrivacyPolicy::class)->name('privacy-policy');
    Route::get('/contrato-de-parceria', \App\Livewire\Web\PartnershipAgreement::class)->name('partnership-agreement');
    Route::get('/contrato-de-servico', \App\Livewire\Web\ServiceContract::class)->name('service-contract');

    Route::name('scheduling.')->prefix('agendamento')->group(function () {
        Route::get('/', \App\Livewire\Web\Order\Scheduling::class)->name('index');
        Route::middleware('customer')->group(function () {
            Route::get('/checkout', \App\Livewire\Web\Order\Checkout::class)->name('checkout');
            Route::get('/agradecimento', \App\Livewire\Web\Order\Greetings::class)->name('greetings');
        });
    });

    Route::prefix('perfil')->name('profile.')->middleware('customer')->group(function () {
        Route::get('/', \App\Livewire\Web\Customers\Profile::class)->name('index');
        Route::get('/enderecos', \App\Livewire\Web\Customers\Address::class)->name('address');
        Route::prefix('servicos')->name('services.')->group(function () {
            Route::get('/', \App\Livewire\Web\Customers\Services\Table::class)->name('index');
            Route::get('/{order}', \App\Livewire\Web\Customers\Services\See::class)->name('see');
        });

        Route::prefix('cartoes')->name('cards.')->group(function () {
            Route::get('/', \App\Livewire\Web\Customers\Cards::class)->name('index');
            Route::get('/novo', \App\Livewire\Web\Customers\Cards\Create::class)->name('create');
            Route::get('/{card_id}/atualizar/', \App\Livewire\Web\Customers\Cards\Edit::class)->name('edit');
        });
    });

    Route::prefix('seja-um-parceiro')->name('partners.')->group(function () {
        Route::get('/', \App\Livewire\Web\Partners\Container::class)->name('index');
        Route::get('/finalizar-cadastro/{pre_registration}', \App\Livewire\Web\Partners\FinishRegistration::class)->name('finish');
    });

    Route::post('/web-socket/notification', [PagarmeController::class, 'index']);
});

require __DIR__ . '/auth.php';
