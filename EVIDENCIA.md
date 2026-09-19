# Evidencia de entrega

## Git y Pull Requests

```powershell
git remote -v
git branch -a
git status
git log --oneline --graph --decorate --all
```

Features integradas mediante PR hacia `develop`:

- PR #1: `feature/api-rest-citas -> develop`
- PR #2: `feature/docker-mysql-schema -> develop`
- PR #3: `feature/validacion-conflictos-estados -> develop`
- PR #4: `feature/fullcalendar-ui -> develop`

## Docker y MySQL

```powershell
docker compose up -d --build
docker compose ps
docker ps
docker compose exec app php artisan migrate --seed --force
```

MySQL 8.4 se ejecuta exclusivamente en Docker, en el servicio `mysql`, y persiste en el volumen `mysql_data`.

## API REST

```bash
curl http://localhost:8000/api/citas
curl http://localhost:8000/api/doctores
curl http://localhost:8000/api/pacientes
curl -X POST http://localhost:8000/api/citas -H "Content-Type: application/json" -d '{"paciente_id":1,"doctor_id":1,"fecha":"2026-09-25","hora_inicio":"09:00","hora_fin":"09:30","motivo":"Control"}'
curl http://localhost:8000/api/citas/1
curl -X PUT http://localhost:8000/api/citas/1 -H "Content-Type: application/json" -d '{"paciente_id":1,"doctor_id":1,"fecha":"2026-09-25","hora_inicio":"10:00","hora_fin":"10:30","motivo":"Reprogramada"}'
curl -X PATCH http://localhost:8000/api/citas/1/estado -H "Content-Type: application/json" -d '{"estado":"cancelada"}'
```

Un horario que cumpla `nuevo_inicio < fin_existente` y `nuevo_fin > inicio_existente` para el mismo doctor responde `409 Conflict` con JSON. Las citas canceladas permanecen como historial.

## FullCalendar

Abrir `http://localhost:8000` para visualizar las vistas mensual y semanal, crear citas, consultar detalle, filtrar por doctor, reprogramar por drag and drop y cambiar/cancelar estados. Los colores indican pendiente, confirmada, cancelada y atendida.
