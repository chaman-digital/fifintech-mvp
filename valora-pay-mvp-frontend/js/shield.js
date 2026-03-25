// BANORTE SHIELD - Módulo de Seguridad Anti-Robo

(function() {
    // 1. Bloquear clic derecho
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // 2. Bloquear atajos de teclado
    document.addEventListener('keydown', function(e) {
        // F12
        if (e.key === 'F12') {
            e.preventDefault();
        }
        // Ctrl+S / Cmd+S
        if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
        }
        // Ctrl+U / Cmd+U
        if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
            e.preventDefault();
        }
        // Ctrl+Shift+I / Cmd+Option+I
        if ((e.ctrlKey || e.metaKey) && (e.shiftKey || e.altKey) && (e.key === 'i' || e.key === 'I')) {
            e.preventDefault();
        }
        // Ctrl+Shift+C / Cmd+Option+C
        if ((e.ctrlKey || e.metaKey) && (e.shiftKey || e.altKey) && (e.key === 'c' || e.key === 'C')) {
            e.preventDefault();
        }
    });

    // 3. Limpiar consola y mostrar advertencia restrictiva
    setInterval(function() {
        console.clear();
        console.log(
            '%c🛑 ACCESO DENEGADO 🛑', 
            'color: white; background: #E52E2E; font-size: 30px; font-weight: bold; padding: 10px; border-radius: 5px; font-family: Inter, sans-serif;'
        );
        console.log(
            '%cEste sistema está protegido. Las herramientas de desarrollador están restringidas por motivos de seguridad.',
            'color: #E52E2E; font-size: 16px; font-weight: bold; padding: 5px; font-family: Inter, sans-serif;'
        );
    }, 2000);
})();
