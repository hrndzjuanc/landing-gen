<x-mail::message>
# Nuevo formulario enviado

@foreach ($form_data as $key => $value)
    {{ $key }}: {{ $value }}
@endforeach


Gracias,<br>
# {{ config('app.name') }}
</x-mail::message>
