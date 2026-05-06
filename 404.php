<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | Latticework</title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        gbm: {
                            black: '#15272F',
                            dark: '#0a0a0a',
                            light: '#F9FAFB',
                            accent: '#00C853',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gbm-dark text-white antialiased min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Texture -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('/assets/logos/latticework-dark-bg.svg'); background-size: cover; background-position: center;"></div>

    <div class="relative z-10 max-w-md w-full text-center">
        <!-- Logo -->
        <a href="/">
            <img src="/assets/logos/latticework-logo-h-dark.svg" alt="Latticework" class="h-10 mx-auto mb-10 filter invert brightness-0 saturate-100">
        </a>
        
        <h1 class="text-7xl font-extrabold mb-4 text-white tracking-tighter">404</h1>
        <h2 class="text-2xl font-bold mb-6">Página no encontrada</h2>
        <p class="text-gray-400 mb-10">La página que buscas no existe o ha sido movida. Te redirigiremos al inicio en unos segundos.</p>
        
        <a href="/" class="inline-flex items-center justify-center bg-white text-gbm-black hover:bg-gray-100 font-bold px-8 py-3.5 rounded-full transition w-full shadow-lg">
            Regresar al Inicio
        </a>
        
        <div class="mt-8 text-sm text-gray-500 flex justify-center items-center gap-2">
            <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span id="countdown">Redirigiendo en 5s...</span>
        </div>
    </div>

    <script>
        let timeLeft = 5;
        const countdownEl = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            timeLeft--;
            if (countdownEl) {
                countdownEl.innerText = `Redirigiendo en ${timeLeft}s...`;
            }
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.replace('/');
            }
        }, 1000);
    </script>
</body>
</html>
