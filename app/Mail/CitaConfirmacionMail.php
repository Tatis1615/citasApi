<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CitaConfirmacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $fecha;
    public $hora;
    public $eps;
    public $nombreMedico;
    public $motivo;

    public function __construct($nombre, $fecha, $hora, $eps, $nombreMedico, $motivo)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->eps = $eps;
        $this->nombreMedico = $nombreMedico;
        $this->motivo = $motivo;
    }

    public function build()
    {
        return $this->subject('Confirmación de tu cita médica')
                    ->view('emails.confirmacion_cita');
    }
}
