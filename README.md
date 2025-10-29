# 📌 API Clínica - Gestión de Usuarios, Pacientes y Citas

Este proyecto es una **API REST** desarrollada en **Laravel** que permite gestionar la autenticación de usuarios, pacientes, médicos, especialidades, consultorios y citas médicas.  
Incluye seguridad basada en **Laravel Sanctum** y control de acceso por **roles**.

---

## 🚀 Tecnologías utilizadas
- **PHP 8+**
- **Laravel 10+**
- **MySQL**
- **Laravel Sanctum** (autenticación con tokens personales)
- **Middleware de Roles**

---

## 📂 Estructura de la base de datos (tablas principales)

- **pacientes** → información de los pacientes (nombre, apellido, documento, teléfono, email, fecha de nacimiento, dirección).
- **medicos** → datos de los médicos y su especialidad.
- **especialidades** → lista de especialidades médicas.
- **consultorios** → número y ubicación del consultorio.
- **citas** → agenda de citas médicas, relacionada con pacientes, médicos y consultorios.
- **users** → tabla de usuarios para login y autenticación con Sanctum.

---

## 🔑 Autenticación
Todos los endpoints protegidos usan **Bearer Token** (Laravel Sanctum).

**Ejemplo de header:**

```http
Authorization: Bearer <token>
Content-Type: application/json
```

## 📌 Endpoints de Autenticación (AuthController)

| Método | Ruta                 | Descripción                              |
| ------ | -------------------- | ---------------------------------------- |
| POST   | /api/registrar        | Registrar un nuevo usuario (con rol)     |
| POST   | /api/login           | Iniciar sesión y obtener token JWT       |
| POST   | /api/logout          | Cerrar sesión e invalidar token          |
| GET    | /api/me              | Obtener información del usuario logueado |
| PUT    | /api/perfil        | Edita los perfiles de ambos roles        |

---

## 🌐 Endpoints principales

### 🔹Citas

| Método | Ruta                      | Descripción             |
| ------ | ------------------------- | ----------------------- |
| GET    | /api/listarCitas          | Lista todas las citas   |
| POST   | /api/crearCitas           | Crear una nueva cita    |
| GET    | /api/citas/{id}           | Ver detalle de una cita |
| PUT    | /api/actualizarCitas/{id} | Actualizar una cita     |
| DELETE | /api/eliminarCitas/{id}   | Eliminar una cita       |

### 🔹Ejemplo - Crear cita

**POST /api/crearCitas**

**Body:**
```json
{
  "id_pacientes": 1,
  "id_medicos": 2,
  "id_consultorios": 1,
  "fecha": "2025-09-10",
  "hora": "10:30",
  "estado": "Confirmada",
  "motivo": "Chequeo general"
}
```

**Respuesta 201:**
```json
{
  "id": 12,
  "id_pacientes": 1,
  "id_medicos": 2,
  "id_consultorios": 1,
  "fecha": "2025-09-10",
  "hora": "10:30",
  "estado": "Confirmada",
  "motivo": "Chequeo general",
  "created_at": "2025-09-04T17:00:00Z",
  "updated_at": "2025-09-04T17:00:00Z"
}
```

---

### 🔹Consultorios
| Método | Ruta                             | Descripción                  |
| ------ | -------------------------------- | ---------------------------- |
| GET    | /api/listarConsultorios          | Lista todos los consultorios |
| POST   | /api/crearConsultorios           | Crear consultorio            |
| GET    | /api/consultorios/{id}           | Ver consultorio por id       |
| PUT    | /api/actualizarConsultorios/{id} | Actualizar consultorio       |
| DELETE | /api/eliminarConsultorios/{id}   | Eliminar consultorio         |

### 🔹Especialidades
| Método | Ruta                               | Descripción                    |
| ------ | ---------------------------------- | ------------------------------ |
| GET    | /api/listarEspecialidades          | Lista todas las especialidades |
| POST   | /api/crearEspecialidades           | Crear especialidad             |
| GET    | /api/especialidades/{id}           | Ver especialidad por id        |
| PUT    | /api/actualizarEspecialidades/{id} | Actualizar especialidad        |
| DELETE | /api/eliminarEspecialidades/{id}   | Eliminar especialidad          |

### 🔹Médicos
| Método | Ruta                        | Descripción             |
| ------ | --------------------------- | ----------------------- |
| GET    | /api/listarMedicos          | Lista todos los médicos |
| POST   | /api/crearMedicos           | Crear médico            |
| GET    | /api/medicos/{id}           | Ver médico por id       |
| PUT    | /api/actualizarMedicos/{id} | Actualizar médico       |
| DELETE | /api/eliminarMedicos/{id}   | Eliminar médico         |

### 🔹Pacientes
| Método | Ruta                          | Descripción               |
| ------ | ----------------------------- | ------------------------- |
| GET    | /api/listarPacientes          | Lista todos los pacientes |
| POST   | /api/crearPacientes           | Crear paciente            |
| GET    | /api/pacientes/{id}           | Ver paciente por id       |
| PUT    | /api/actualizarPacientes/{id} | Actualizar paciente       |
| DELETE | /api/eliminarPacientes/{id}   | Eliminar paciente         |

---

## 📊 Consultas adicionales

- `GET /api/listarCitasPaciente` → Lista todas las citas asociadas a un paciente específico.
- `GET /api/listarCitasMedico` → Lista todas las citas asignadas a un médico determinado.
- `GET /api/pacientePorEmail` → Busca y muestra la información de un paciente a partir de su correo electrónico.
- `GET /api/medicoPorEmail` → Busca y muestra la información de un médico según su correo electrónico.
- `PUT /api/actualizarPacienteEmail` → Permite actualizar el correo electrónico de un paciente existente.
- `PUT /api/actualizarMedicoEmail` → Permite actualizar el correo electrónico de un médico registrado.

---

## ⚙️ Instalación y ejecución

### Clonar el repositorio:
```bash
git clone https://github.com/Tatis1615/citasApi.git
```

### Instalar dependencias:
```bash
composer install
```

### Configurar variables de entorno (.env):
```env
DB_DATABASE=citas
DB_USERNAME=root
DB_PASSWORD=
```

### Ejecutar migraciones:
```bash
php artisan migrate
```

### Iniciar servidor:
```bash
php artisan serve
```

---

## ✅ Notas

- Usar **Bearer Token** en los endpoints protegidos, esta verificación se realizó por medio de Postman.
- Los controladores implementan validación con **Validator** para evitar datos inválidos.
- La API devuelve respuestas en formato **JSON** con mensajes de error claros.
