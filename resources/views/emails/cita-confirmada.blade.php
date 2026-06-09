<x-mail::message>
# Confirmación de Cita Médica

Hola **{{ $cita->paciente->user->name }}**,

Tu cita ha sido confirmada con éxito en la **Clínica Los Mollos**.

<x-mail::panel>
**Detalles de tu cita:**

- **Médico:** Dr. {{ $cita->medico->user->name }}
- **Especialidad:** {{ $cita->especialidad->nombre }}
- **Fecha y hora:** {{ $cita->fecha_hora->format('d/m/Y') }} a las {{ $cita->fecha_hora->format('h:i A') }}
- **Motivo:** {{ $cita->motivo }}
</x-mail::panel>

Por favor, llegá 10 minutos antes de tu turno. Si necesitás cancelar o reprogramar, contactate con la recepción.

Muchas gracias,<br>
**Clínica Los Mollos**
</x-mail::message>
