# Separación del proyecto monolítico

## Objetivo
Este proyecto se separó en dos capas: 
- Backend: Laravel (API + lógica de negocio + gestión de datos)
- Frontend: React + Vite (interfaz del usuario y estilos)

## Cambios realizados

### 1) Backend Laravel
Se mantuvo la app principal en la raíz del proyecto, ya que allí sigue existiendo:
- `app/`
- `routes/`
- `database/`
- `config/`
- `public/`
- `resources/` (vista Blade del backend)

Esto deja el backend desacoplado del frontend para que Laravel pueda seguir respondiendo como API y manejar las vistas de administración / panel.

### 2) Frontend React
Se creó la carpeta `frontend/` con una estructura de React moderna:
- `frontend/package.json`
- `frontend/vite.config.js`
- `frontend/index.html`
- `frontend/src/main.jsx`
- `frontend/src/styles.css`

Esto permite que la interfaz del cliente se construya en React y se sirva con Vite.

### 3) Estilos y gestión
- Los estilos del frontend quedaron en `frontend/src/styles.css`
- La lógica de la interfaz quedó en `frontend/src/main.jsx`
- La gestión del backend permanece en Laravel dentro de la raíz del proyecto

## Recomendación de uso
- Ejecuta Laravel en su puerto usual: `php artisan serve`
- Ejecuta React con: `cd frontend && npm install && npm run dev`

## Nota importante
La separación completa de una app real suele implicar:
- mover las rutas de API a `routes/api.php`
- crear un cliente React que consuma la API desde Laravel
- dejar las vistas Blade solo como panel administrativo si se quiere mantener monolítico
