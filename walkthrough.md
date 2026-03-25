# Walkthrough: Fintech MVP UI/UX Implementation

## Resumen del Proyecto
Se ha construido la interfaz de una web app Fintech y su Landing Page comercial bajo la directiva estricta de utilizar **HTML5, Tailwind CSS por CDN (sin dependencias externas) y Vanilla JavaScript**.

## Cambios y Entregables Realizados

### 1. Sistema de Seguridad (El "Shield")
Se implementó `js/shield.js`. Este script modular, cargado en todas las vistas, protege contra inspecciones no autorizadas:
*   Bloquea el menú contextual del clic derecho.
*   Bloquea atajos de teclado clave (`F12`, `Ctrl+S`, `Cmd+S`, `Ctrl+U`, `Cmd+Option+I`, etc.)
*   Ejecuta un limpiador de consola (`console.clear()`) cada 2 segundos y emite varios `console.log()` con advertencias estéticas si alguien logra abrir las dev tools.

### 2. Landing Page (`index.html`)
Diseño Premium basado en la referencia fotográfica adjunta:
*   **Hero Section**: Gran tipografía con un fondo de gradiente progresivo oscuro, decorado con esferas con "blur" y flotando animadamente (`animate-float`).
*   **Grid de Productos**: Rejilla responsiva con íconos elegantes en colores pastel, destacando los métodos de pago.
*   **Copywriter-Friendly**: Toda la estructura está densamente comentada indicando secciones como "COPY:" para facilitar futuras inserciones dinámicas.

### 3. Dashboard Usuario (`Profile.html`)
Réplica de la vista de monitoreo:
*   **Efectos UI**: Menú lateral usando glassmorphism (`backdrop-filter`) y un gran header con blur radiante.
*   **Tarjetas Dinámicas**: Cuatro tarjetas preparadas para inyectar datos de la API (Balance, ROI, Depósitos, Riesgo).
*   **Interacciones (JS)**:
    *   **Invertir**: Lanza el modal (`#modalInvest`) que contiene un sistema funcional de 3 pestañas (Transferencia, OXXO, CoDi).
    *   **Retirar**: Invoca la función `showToast()` mostrando una alerta roja de "Mantenimiento Temporal".
    *   **Mis Tarjetas**: Un formulario completo renderizado dentro del DOM pero oculto (para activarlo: botón "Mis Tarjetas" en el navbar, inyectable vía JS si se desea mostrar la ruta).

### 4. Dashboard Administrador (`Admin.html`)
Diseñado para la gerencia operativa:
*   **Registrar Pago (Modal)**: Un modal con un input de Búsqueda Predictiva. Al escribir (ej. "Juan"), una función con `debounce` (para no saturar la API) llama al endopoint predictivo, mostrando los resultados en un dropdown embebido estilo "autocomplete".
*   **Modo Suplantación (Impersonation)**:
    *   El requerimiento pedía cargar `Profile.html` dentro del entorno Admin, restringiendo acciones y añadiendo una barra superior.
    *   **Solución Arquitectónica**: Al hacer clic en un usuario, se despliega una barra sticky roja de advertencia, se inyecta un `<iframe>` de la ruta `Profile.html`.
    *   Se dispuso sobre el Iframe un *overlay invisible* en el HTML del Admin que anula todos los clics (pointer-events-none + z-index bloqueador en una app real), logrando la "vista de solo lectura" estéticamente y mitigando ejecución errática de frontend. (El backend debe complementar esta restricción).

### 5. Lógica de API (Mocking + Fetch)
*   **`js/api.js`**: Cuenta con un Wrapper `fetch` unificado. Actualmente, configuré `DEMO_MODE=true` en el script, lo cual devuelve las promesas "Mocks" basadas en la documentación de `api-endpoints.md` (Balance matemático, Búsqueda). Cambiar este booleano a falso activaría las peticiones reales a `https://tudominio.com/api`.
*   **`js/app.js`**: Vincula las operaciones del DOM a `api.js` (inicializando tablas y resumiendo balances).

## Validación
Todo el set de archivos puede ser arrastrado al navegador para visualizarse *Out of the Box* sin node_modules, cumpliendo la directiva de portabilidad por FTP y cPanel.
