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
 
<x-mail::button url="{{config('app.url')}}/parceiros/{{$slug}}/agendamentos/{{$pedidoId}}" color="primary">
{{ $actionText  ?? "Ir para o pedido"}}
</x-mail::button>
 
</x-mail::message>