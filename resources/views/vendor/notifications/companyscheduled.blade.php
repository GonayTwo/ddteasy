<x-mail::message>
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif
 
@foreach ($introLines as $line)
{{ $line }}
@endforeach
 
<x-mail::button url="{{ route('filament.partner.auth.login') }}" color="primary">
{{ $actionText  ?? "Ir para o painel"}}
</x-mail::button>
 
</x-mail::message>