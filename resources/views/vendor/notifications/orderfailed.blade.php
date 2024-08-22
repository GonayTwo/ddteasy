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

Houve um erro de autorização da cobrança

 
</x-mail::message>