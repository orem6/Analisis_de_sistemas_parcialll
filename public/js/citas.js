const api = '/api';
const color = { pendiente: '#e39b21', confirmada: '#2670b8', cancelada: '#9a9a9a', atendida: '#23845a' };
const $ = (id) => document.getElementById(id);
const modal = $('cita-modal');
let calendar;

async function request(url, options = {}) {
    const response = await fetch(api + url, { headers: { Accept: 'application/json', 'Content-Type': 'application/json' }, ...options });
    const body = await response.json();
    if (!response.ok) throw new Error(body.message || 'No se pudo completar la solicitud.');
    return body.data;
}
function message(text = '') { $('mensaje').textContent = text; }
function options(items, select) { select.innerHTML = '<option value="">Seleccione</option>' + items.map((x) => `<option value="${x.id}">${x.nombre} ${x.apellido}</option>`).join(''); }
function toInput(date) { return date.replace(' ', 'T').slice(0, 16); }
function openForm(cita = null, start = null) {
    $('cita-form').reset(); $('cita-id').value = cita?.id || ''; $('modal-titulo').textContent = cita ? 'Detalle de cita' : 'Nueva cita';
    const inicio = cita?.inicio || start?.toISOString().slice(0, 16); const fin = cita?.fin || inicio;
    if (inicio) { const value = toInput(inicio); $('fecha').value = value.slice(0, 10); $('hora-inicio').value = value.slice(11); $('hora-fin').value = toInput(fin).slice(11); }
    if (cita) { $('paciente-id').value = cita.paciente_id; $('doctor-id').value = cita.doctor_id; $('motivo').value = cita.motivo; $('estado').value = cita.estado; }
    modal.showModal();
}
async function loadEvents(info, success, failure) {
    try { const doctor = $('doctor-filtro').value; const data = await request(`/citas?desde=${info.startStr}&hasta=${info.endStr}${doctor ? `&doctor_id=${doctor}` : ''}`); success(data.map((cita) => ({ id: cita.id, title: `${cita.paciente.nombre} ${cita.paciente.apellido}`, start: cita.inicio, end: cita.fin, backgroundColor: color[cita.estado], extendedProps: { cita } }))); } catch (error) { failure(error); message(error.message); }
}
async function save() {
    const data = { paciente_id: Number($('paciente-id').value), doctor_id: Number($('doctor-id').value), fecha: $('fecha').value, hora_inicio: $('hora-inicio').value, hora_fin: $('hora-fin').value, motivo: $('motivo').value };
    const id = $('cita-id').value;
    try { await request(id ? `/citas/${id}` : '/citas', { method: id ? 'PUT' : 'POST', body: JSON.stringify(data) }); if (id) await request(`/citas/${id}/estado`, { method: 'PATCH', body: JSON.stringify({ estado: $('estado').value }) }); modal.close(); calendar.refetchEvents(); message(); } catch (error) { message(error.message); }
}
document.addEventListener('DOMContentLoaded', async () => {
    const [doctores, pacientes] = await Promise.all([request('/doctores'), request('/pacientes')]); options(doctores, $('doctor-filtro')); options(doctores, $('doctor-id')); options(pacientes, $('paciente-id'));
    calendar = new FullCalendar.Calendar($('calendar'), { initialView: 'dayGridMonth', headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' }, editable: true, selectable: true, events: loadEvents, select: (info) => openForm(null, info.start), eventClick: (info) => openForm(info.event.extendedProps.cita), eventDrop: async (info) => { const cita = info.event.extendedProps.cita; const start = info.event.start, end = info.event.end; try { await request(`/citas/${cita.id}`, { method: 'PUT', body: JSON.stringify({ paciente_id: cita.paciente_id, doctor_id: cita.doctor_id, fecha: start.toISOString().slice(0, 10), hora_inicio: start.toTimeString().slice(0, 5), hora_fin: end.toTimeString().slice(0, 5), motivo: cita.motivo }) }); calendar.refetchEvents(); } catch (error) { info.revert(); message(error.message); } } }); calendar.render();
    $('nueva-cita').onclick = () => openForm(); $('cancelar-modal').onclick = () => modal.close(); $('cita-form').onsubmit = (event) => { event.preventDefault(); save(); }; $('doctor-filtro').onchange = () => calendar.refetchEvents();
});
