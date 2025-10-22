<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Confirmación de Cita Médica</title>
</head>
<body style="margin:0; padding:0; background:#ffeef3; font-family:'Segoe UI', Arial, sans-serif;">
  <div style="max-width:600px; margin:40px auto; background:#fff; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ffb6c1,#ff8fb0); padding:25px; text-align:center; color:white;">
      <h1 style="margin:0; font-size:26px;">✨ ¡Cita Confirmada! ✨</h1>
      <p style="margin-top:8px; font-size:16px;">Gracias por confiar en <strong>{{ $eps }}</strong></p>
    </div>

    <div style="padding:30px;">
      <h2 style="color:#ff6f91;">Hola, {{ $nombre }}</h2>
      <p style="font-size:15px; color:#555;">
        Tu cita médica ha sido programada con éxito. Aquí tienes los detalles:
      </p>

      <div style="background:#fff0f5; border-radius:10px; padding:15px; margin:20px 0;">
        <p style="margin:8px 0;"><strong> ❥ Fecha:</strong> {{ $fecha }}</p>
        <p style="margin:8px 0;"><strong> ❥ Hora:</strong> {{ $hora }}</p>
        <p style="margin:8px 0;"><strong> ❥ Médico:</strong> {{ $nombreMedico }}</p>
        <p style="margin:8px 0;"><strong> ❥ Motivo:</strong> {{ $motivo }}</p>
        <p style="margin:8px 0;"><strong> ❥ EPS:</strong> {{ $eps }}</p>
      </div>

      <p style="font-size:15px; color:#555; line-height:1.6;">
        Te recomendamos llegar con <strong>15 minutos de anticipación</strong> y llevar tus documentos personales.  
        Si no puedes asistir, puedes <strong>reprogramar o cancelar</strong> tu cita desde tu cuenta.
      </p>

      <div style="text-align:center; margin-top:25px;">
        <a href="{{ $url ?? '#' }}" style="background:#ff8fb0; color:white; text-decoration:none; padding:12px 25px; border-radius:30px; font-weight:bold; display:inline-block;">
          Ver mi cita
        </a>
      </div>

      <hr style="margin:30px 0; border:none; border-top:1px solid #ffd6e0;">

      <p style="font-size:13px; color:#888; text-align:center;">
        Si tienes alguna duda, contáctanos o responde a este correo.  
        <br><br>💗 Gracias por cuidar de tu salud con <strong>{{ $eps }}</strong>.
      </p>
    </div>

    <div style="background:#ffe6ec; text-align:center; padding:15px; font-size:12px; color:#999;">
      &copy; {{ date('Y') }} {{ $eps }} — Todos los derechos reservados.
    </div>
  </div>
</body>
</html>
