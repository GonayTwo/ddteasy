<x-mail::message>

# ✔ Parabéns!
@foreach ($introLines as $line)
{{ $line }}
@endforeach
 
Seu login está autorizado em nosso painel, clique no botão 'Ir para o painel' abaixo.
<x-mail::button url="{{ route('filament.partner.auth.login') }}" color="primary">
{{ $actionText  ?? "Ir para o painel"}}
</x-mail::button>
 
</x-mail::message>