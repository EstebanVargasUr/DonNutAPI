@component('mail::message')
# !Hola {{ $user->nombre }}!

Este correo fue enviado debido a que hemos recibido una solicitud
 de reinicio de contraseña para tu cuenta.

@component('mail::button', ['url' => url( "/reset-password/".$token )])
Reiniciar Contraseña
@endcomponent

Este enlace de reinicio de contraseña caducará en 60 minutos.<br><br>
Si no solicitastes un reinicio de contraseña, omita este correo electrónico.

Saludos,<br>
{{ config('app.name') }}
@endcomponent