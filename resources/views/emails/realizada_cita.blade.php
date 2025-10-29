<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cita Médica Registrada</title>
</head>
<body style="margin:0; padding:0; background:#f7f4fb; font-family:'Segoe UI', Arial, sans-serif;">
  <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); overflow:hidden;">
    
    <!-- Encabezado -->
    <div style="background:linear-gradient(135deg,#d7b6f9,#b085f5); padding:25px; text-align:center; color:#fff;">
      <h1 style="margin:0; font-size:26px;">💜 ¡Tu cita ha sido registrada! 💜</h1>
      <p style="margin-top:8px; font-size:16px;">Gracias por agendar con <strong>{{ $eps }}</strong></p>
    </div>

    <!-- Contenido principal -->
    <div style="padding:30px;">
      <h2 style="color:#8b6ad8;">Hola, {{ $nombre }}</h2>
      <p style="font-size:15px; color:#555;">
        Hemos recibido tu solicitud de cita médica.  
        Actualmente <strong>tu cita está pendiente de confirmación</strong> por parte del médico o la EPS.
      </p>

      <div style="background:#f0e8fc; border-radius:10px; padding:15px; margin:20px 0;">
        <p style="margin:8px 0;"><strong> ❥ Fecha solicitada:</strong> {{ $fecha }}</p>
        <p style="margin:8px 0;"><strong> ❥ Hora aproximada:</strong> {{ $hora }}</p>
        <p style="margin:8px 0;"><strong> ❥ Médico solicitado:</strong> {{ $nombreMedico }}</p>
        <p style="margin:8px 0;"><strong> ❥ Motivo:</strong> {{ $motivo }}</p>
        <p style="margin:8px 0;"><strong> ❥ EPS:</strong> {{ $eps }}</p>
      </div>

      <p style="font-size:15px; color:#555; line-height:1.6;">
        En cuanto tu cita sea confirmada, te enviaremos otro correo con todos los detalles.  
        Si necesitas hacer algún cambio o cancelarla, puedes hacerlo desde tu cuenta.
      </p>

      <div style="text-align:center; margin-top:25px;">
        <a href="{{ $url ?? '#' }}" style="background:#b085f5; color:white; text-decoration:none; padding:12px 25px; border-radius:30px; font-weight:bold; display:inline-block;">
          Ver mi cita
        </a>
      </div>

      <hr style="margin:30px 0; border:none; border-top:1px solid #e0ccf9;">

      <p style="font-size:13px; color:#888; text-align:center;">
        Si tienes alguna duda, contáctanos o responde a este correo.  
        <br><br>💜 Gracias por confiar en <strong>{{ $eps }}</strong>.
      </p>
    </div>

    <!-- Pie de página -->
    <div style="background:#ede3fb; text-align:center; padding:15px; font-size:12px; color:#999;">
      &copy; {{ date('Y') }} {{ $eps }} — Todos los derechos reservados.
    </div>
  </div>
</body>
</html>
