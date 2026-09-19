<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Medica</title>
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
</head>
<body>
    <main class="agenda">
        <header><div><p class="eyebrow">CLINICA CENTRAL</p><h1>Agenda de citas</h1></div><button id="nueva-cita">Nueva cita</button></header>
        <section class="toolbar"><label>Doctor <select id="doctor-filtro"><option value="">Todos los doctores</option></select></label><span id="mensaje" role="status"></span></section>
        <div id="calendar"></div>
    </main>
    <dialog id="cita-modal"><form id="cita-form" method="dialog"><h2 id="modal-titulo">Nueva cita</h2><input id="cita-id" type="hidden"><label>Paciente <select id="paciente-id" required></select></label><label>Doctor <select id="doctor-id" required></select></label><label>Fecha <input id="fecha" type="date" required></label><div class="horas"><label>Inicio <input id="hora-inicio" type="time" required></label><label>Fin <input id="hora-fin" type="time" required></label></div><label>Motivo <textarea id="motivo" required></textarea></label><label>Estado <select id="estado"><option value="pendiente">Pendiente</option><option value="confirmada">Confirmada</option><option value="cancelada">Cancelada</option><option value="atendida">Atendida</option></select></label><menu><button type="button" id="cancelar-modal">Cerrar</button><button value="submit">Guardar</button></menu></form></dialog>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
    <script src="{{ asset('js/citas.js') }}"></script>
</body>
</html>
