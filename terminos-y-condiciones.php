<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latticework | Términos de Servicio</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    
    <meta name="description" content="Términos y condiciones de los servicios financieros de Latticework.">
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
            <h1 class="text-4xl md:text-5xl font-extrabold text-gbm-black mb-8 tracking-tight">Términos de Servicio</h1>
            <p class="text-gray-500 mb-12">Última actualización: Mayo de 2026</p>

            <div class="prose prose-lg text-gray-600 max-w-none space-y-6">
                <p class="font-bold text-gray-800">
                    POR FAVOR, ASEGÚRATE DE LEER Y ENTENDER COMPLETAMENTE ESTOS TÉRMINOS Y GUÁRDALOS PARA FUTURAS REFERENCIAS. ESTOS TÉRMINOS INCLUYEN UNA RENUNCIA A TU DERECHO DE PARTICIPAR EN DEMANDAS COLECTIVAS O REPRESENTATIVAS Y UN ACUERDO PARA RESOLVER DISPUTAS MEDIANTE ARBITRAJE DE FORMA INDIVIDUAL.
                </p>

                <p>
                    Los Términos y Condiciones (los “Términos”) son un contrato legalmente vinculante entre (a) tú, el usuario final (“tú”, “tu”, “usuario”); y (b) Latticework, S.A.P.I. de C.V., y sus filiales y afiliadas aplicables (conjuntamente, “Latticework”, “nosotros” o “nuestro”).
                </p>

                <p>
                    Estos Términos rigen tu acceso al software, servicios, sitios web y aplicaciones (colectivamente, los “Servicios”) ofrecidos por Latticework a través de nuestro sitio web (“Sitio”). Estos Términos reemplazan y anulan cualquier Término anterior relacionado con tu uso de los Servicios de Latticework.
                </p>

                <p>
                    Al utilizar los Servicios, aceptas que tienes al menos la mayoría de edad legal en la jurisdicción en la que resides. Los Servicios solo se ofrecen y están disponibles para usuarios que tengan al menos dieciocho (18) años de edad. Al acceder, navegar o utilizar los Servicios, reconoces y aceptas los Términos. Si no estás de acuerdo con estos Términos, por favor no accedas ni utilices los Servicios. Al utilizar los Servicios, reconoces haber leído, entendido y estar de acuerdo, sin limitación ni calificación, a estar obligado por estos Términos, incluyendo nuestra Política de Privacidad, la cual se incorpora a estos Términos por referencia.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">Registro</h3>
                <p>
                    Para tener acceso a los Servicios, primero debes crear una cuenta con Latticework proporcionando una dirección de correo electrónico válida y creando una contraseña. Debes pasar exitosamente la Verificación de Identidad para utilizar los Servicios.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">Verificación de Identidad</h3>
                <p>
                    Al usar nuestros Servicios, reconoces y aceptas que para acceder a las características de Latticework, debes completar un proceso de verificación de identidad. Este proceso puede requerir que proporciones varios detalles, incluyendo pero no limitado a:
                </p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Información de la Entidad: Nombre, RFC o número de identificación fiscal, URL del sitio web, número de teléfono, correo electrónico, región y fecha de constitución, estructura legal, dirección postal, propósito comercial, naturaleza de las operaciones y volumen de transacciones previsto.</li>
                    <li>Documentación: Documentos constitutivos, comprobantes de domicilio, certificaciones regulatorias si aplican y programas de prevención de lavado de dinero (PLD) si aplicara a tu entidad.</li>
                    <li>Información de Billeteras: Todas las direcciones de billeteras (wallets) que utilizarás con Latticework.</li>
                    <li>Propietarios y Personal Clave: Nombres de los individuos o entidades que posean al menos el 25% de propiedad ("Propietarios Beneficiarios") y detalles de los directivos, representantes legales y usuarios autorizados.</li>
                </ul>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">Suspensión y Terminación de la Cuenta</h3>
                <p>
                    Latticework se reserva el derecho, a su discreción, de tomar acción con respecto a tu cuenta si: violas cualquier término de estos Términos; proporcionas información falsa o engañosa a Latticework; te involucras en comportamiento fraudulento, inapropiado u ofensivo; tienes cualquiera de tus transacciones denegadas; o participas en cualquier actividad que se considere contraria a las prácticas comerciales justas, viole la ley o sea perjudicial para los intereses de Latticework.
                </p>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">Usos Prohibidos</h3>
                <p>
                    Está prohibido utilizar el Sitio para las siguientes actividades ("Usos Prohibidos"). Si no estás seguro de si tu uso constituye un Uso Prohibido, contáctanos en <a href="mailto:juridico@latticework.mx" class="text-blue-600 hover:underline">juridico@latticework.mx</a>. Confirmas que no harás lo siguiente:
                </p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Violar cualquier ley aplicable, incluyendo leyes contra el lavado de dinero y sanciones (ej. OFAC).</li>
                    <li>Infringir derechos de propiedad intelectual, incluyendo el uso no autorizado del nombre o logo de Latticework.</li>
                    <li>Interrumpir o perjudicar la funcionalidad del Sitio o el uso de otros.</li>
                    <li>Proporcionar información falsa o engañosa, o involucrarte en actividades fraudulentas.</li>
                    <li>Transmitir o intercambiar activos provenientes de actividades criminales (ej. terrorismo, evasión fiscal).</li>
                </ul>

                <h3 class="text-2xl font-bold text-gbm-black mt-8 mb-4">Preguntas y Contacto</h3>
                <p>
                    Si tienes preguntas sobre el sitio web, los Servicios, o estos Términos, por favor siéntete libre de contactarnos vía correo electrónico a:
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
