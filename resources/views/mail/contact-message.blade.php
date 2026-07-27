<h1>Nueva consulta desde el sitio web</h1>
<p><strong>Nombre:</strong> {{ $contactMessage->name }}</p>
<p><strong>Correo:</strong> {{ $contactMessage->email }}</p>
@if($contactMessage->phone)<p><strong>Teléfono:</strong> {{ $contactMessage->phone }}</p>@endif
<p><strong>Asunto:</strong> {{ $contactMessage->subject }}</p>
<p><strong>Mensaje:</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
<p>Consulte y gestione esta solicitud desde el panel administrativo.</p>
