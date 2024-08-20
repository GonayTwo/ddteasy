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

Seu pagamento foi confirmado via {{$payment}}
 
@foreach ($introLines as $line)
{{ $line }}
@endforeach

<x-mail::table>
|Serviço Estabelecido|    Data e Periodo    | Total R$  |
|:------------------:|:--------------------:|:---------:|
|    {{$descripton}} | {{$date}} {{$period}}|{{$amount}}|
</x-mail::table>

 
</x-mail::message>