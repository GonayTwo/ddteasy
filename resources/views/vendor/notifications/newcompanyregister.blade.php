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
 
Agora é sua vez 😉.
 
<x-mail::button url="{{ route('site.partners.index') }}" color="primary">
{{ $actionText  ?? "Ir para o painel"}}
</x-mail::button>
 
</x-mail::message>