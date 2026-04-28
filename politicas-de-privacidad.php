<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latticework | Política de Privacidad</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    
    <meta name="description" content="Política de privacidad y protección de datos personales de Latticework.">
    <meta name="robots" content="index, follow">

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
                            blue: '#003366',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Project Styles -->
    <link rel="stylesheet" href="css/main.css">
    
    <!-- Global Rule CSS -->
    <link rel="stylesheet" href="../shared/css/vanguard-master.css">

    <style>
        .nav-glassmorphism {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(209, 213, 219, 0.3);
        }
        .btn-gbm {
            transition: opacity 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }
        .btn-gbm:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body class="bg-white text-gbm-dark antialiased selection:bg-gbm-black selection:text-white overflow-x-hidden">

    <!-- Header / Navigation -->
    <header class="fixed w-full top-0 z-50 nav-glassmorphism transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <a href="index.php"><img src="assets/logos/latticework-logo-h-dark.svg" alt="Latticework" class="h-8 md:h-10 w-auto"></a>
                </div>

                <nav class="hidden md:flex space-x-10">
                    <a href="index.php#solutions" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Soluciones</a>
                    <a href="index.php#flexibilidad" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Flexibilidad</a>
                    <a href="index.php#security" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Seguridad</a>
                    <a href="index.php#faqs" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">FAQs</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="index.php" class="text-gbm-black hover:text-gray-600 transition font-semibold text-sm">Volver al inicio</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobileMenuBtn" class="text-gbm-black hover:text-gray-600 focus:outline-none transition-transform active:scale-95 p-2 bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-[0_10px_20px_rgba(0,0,0,0.05)] rounded-b-3xl transform transition-transform duration-300 origin-top">
            <div class="px-8 py-6 space-y-2 flex flex-col">
                <a href="index.php#solutions" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Soluciones</a>
                <a href="index.php#flexibilidad" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Flexibilidad</a>
                <a href="index.php#security" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Seguridad</a>
                <a href="index.php#faqs" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">FAQs</a>
                <div class="pt-6 pb-2">
                    <a href="index.php" class="w-full block text-center bg-gbm-black text-white hover:bg-gray-800 rounded-full py-3.5 font-bold text-base transition-colors btn-gbm shadow-md">Volver al inicio</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-32 pb-20">
        <div class="max-w-4xl mx-auto px-6 sm:px-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gbm-black mb-8 tracking-tight">Política de Privacidad</h1>
            <p class="text-gray-500 mb-12">Última actualización: Mayo de 2026</p>

            <div class="prose prose-lg text-gray-600 max-w-none space-y-6">
                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">1. Introducción</h3>
                <p>
                    Bienvenido a Latticework, S.A.P.I. de C.V. ("nosotros", "nuestro" o "nuestra"). Esta Política de Privacidad rige tu visita y uso de nuestros servicios y sitio web, y explica cómo recopilamos, salvaguardamos y divulgamos la información que resulta de tu uso de nuestro Servicio.
                </p>

                <p>
                    Usamos tus datos para proporcionar y mejorar el Servicio. Al utilizar el Servicio, aceptas la recopilación y el uso de información de acuerdo con esta política. A menos que se defina lo contrario en esta Política de Privacidad, los términos utilizados en ella tienen los mismos significados que en nuestros Términos y Condiciones.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">2. Definiciones</h3>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>SERVICIO</strong> significa el sitio web y las plataformas operadas por Latticework, S.A.P.I. de C.V.</li>
                    <li><strong>DATOS PERSONALES</strong> significa los datos sobre un individuo vivo que puede ser identificado a partir de esos datos (o a partir de esos y otra información ya sea en nuestra posesión o probable que entre en nuestra posesión).</li>
                    <li><strong>DATOS DE USO</strong> son los datos recopilados automáticamente, ya sea generados por el uso del Servicio o de la propia infraestructura del Servicio (por ejemplo, la duración de una visita a la página).</li>
                    <li><strong>COOKIES</strong> son pequeños archivos almacenados en tu dispositivo (computadora o dispositivo móvil).</li>
                </ul>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">3. Tipos de Datos Recopilados</h3>
                <p class="font-bold text-gray-800 mt-4">Datos Personales</p>
                <p>
                    Mientras utilizas nuestro Servicio, es posible que te pidamos que nos proporciones cierta información de identificación personal que puede ser utilizada para contactarte o identificarte. La información de identificación personal puede incluir, pero no se limita a: dirección de correo electrónico, nombre, número de teléfono, dirección postal e información de la entidad comercial.
                </p>

                <p class="font-bold text-gray-800 mt-4">Datos de Uso</p>
                <p>
                    También podemos recopilar información que tu navegador envía cada vez que visitas nuestro Servicio o cuando accedes al Servicio mediante un dispositivo móvil.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">4. Retención de Datos</h3>
                <p>
                    Retendremos tus Datos Personales solo durante el tiempo que sea necesario para los fines establecidos en esta Política de Privacidad. Retendremos y utilizaremos tus Datos Personales en la medida en que sea necesario para cumplir con nuestras obligaciones legales, resolver disputas y hacer cumplir nuestros acuerdos legales y políticas.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">5. Seguridad de los Datos</h3>
                <p>
                    Para proteger tus Datos Personales, empleamos una variedad de medidas de seguridad, incluyendo encriptación, firewalls y servidores seguros. Nuestras prácticas de seguridad están diseñadas para proporcionar un nivel de seguridad apropiado al riesgo del procesamiento de tu información personal. Recuerda que ningún método de transmisión por Internet, o método de almacenamiento electrónico es 100% seguro.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">6. Contacto</h3>
                <p>
                    Si tienes preguntas sobre esta Política de Privacidad, por favor siéntete libre de contactarnos vía correo electrónico a:
                </p>
                <ul class="list-none space-y-2">
                    <li><strong>Dudas Legales:</strong> <a href="mailto:juridico@latticework.mx" class="text-blue-600 hover:underline">juridico@latticework.mx</a></li>
                    <li><strong>Información General:</strong> <a href="mailto:info@latticework.mx" class="text-blue-600 hover:underline">info@latticework.mx</a></li>
                    <li><strong>Soporte General:</strong> <a href="mailto:contacto@latticework.mx" class="text-blue-600 hover:underline">contacto@latticework.mx</a></li>
                    <li><strong>Transacciones (Comprobantes):</strong> <a href="mailto:transacciones@latticework.mx" class="text-blue-600 hover:underline">transacciones@latticework.mx</a></li>
                </ul>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-gbm-dark pt-16 pb-12 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-16">
                
                <div class="col-span-2 lg:col-span-2 pr-8">
                    <img src="assets/logos/latticework-logo-h-dark.svg" alt="Latticework" class="h-10 w-auto mb-8">
                    <p class="text-gray-600 text-sm mb-6 max-w-sm leading-relaxed">
                        Latticework is the first B2B cryptocurrency exchange designed for international businesses.
                    </p>
                    <p class="text-gray-400 text-xs mb-2">Oficina corporativa: C. Montes Urales 424, Lomas - Virreyes, Lomas de Chapultepec V Secc., Miguel Hidalgo, CDMX</p>
                    <p class="text-gray-400 text-xs mb-2">Teléfono: <a href="callto:5671144938" class="hover:text-gbm-black transition">5671144938</a></p>
                </div>

                <div>
                    <h4 class="font-bold text-gbm-black mb-6">Plataforma</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="index.php#solutions" class="hover:text-gbm-black transition">Cómo funciona</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gbm-black mb-6">Empresa</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="index.php#flexibilidad" class="hover:text-gbm-black transition">Nosotros</a></li>
                        <li><a href="callto:5671144938" class="hover:text-gbm-black transition">Agendar llamada</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gbm-black mb-6">Legal</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="terminos-y-condiciones.php" class="hover:text-gbm-black transition">Términos de servicio</a></li>
                        <li><a href="politicas-de-privacidad.php" class="hover:text-gbm-black transition">Privacidad</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
                <p>Copyright &copy; 2026 Latticework. Todos los derechos reservados.</p>
                <div class="flex space-x-6 mt-6 md:mt-0 font-medium text-gray-500">
                    <a href="https://wa.me/525529067289?text=Hola.%20Me%20interesa%20invertir,%20por%20favor%20comun%C3%ADquense%20conmigo." target="_blank" class="hover:text-gbm-black transition">WhatsApp</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.remove('hidden');
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    } else {
                        mobileMenu.classList.add('hidden');
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
                    }
                });
            }
        });
    </script>
</body>
</html>
