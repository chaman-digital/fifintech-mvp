<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latticework | Banca digital para empresas mayoristas</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <meta name="description" content="Latticework is the first B2B cryptocurrency exchange designed for international businesses. Access a US-based virtual bank account to buy, sell, and transfer crypto.">
    <meta property="og:title" content="Latticework | Banca digital para empresas mayoristas">
    <meta property="og:description" content="Latticework is the first B2B cryptocurrency exchange designed for international businesses.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://latticework.mx/">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T86XKJ8JCP"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-T86XKJ8JCP');
    </script>

    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "wifbyshsrw");
    </script>

    <!-- JSON-LD SEO/GEO Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FinancialService",
      "name": "Latticework",
      "url": "https://latticework.mx/",
      "logo": "https://latticework.mx/assets/logos/latticework-logo-h-dark.svg",
      "description": "Latticework is the first B2B cryptocurrency exchange designed for international businesses.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "C. Montes Urales 424, Lomas - Virreyes",
        "addressLocality": "Miguel Hidalgo",
        "addressRegion": "CDMX",
        "addressCountry": "MX"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+52-55-2906-7289",
        "contactType": "Customer Service"
      }
    }
    </script>

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
        
        .progressive-blur {
            position: relative;
        }
        .progressive-blur::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            right: 0;
            height: 30px;
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            pointer-events: none;
        }

        .dark-progressive-blur::after {
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
        }
        
        /* Flat Hover Design */
        .btn-gbm {
            transition: opacity 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }
        .btn-gbm:hover {
            opacity: 0.9;
        }

        /* Carousel animation */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-250px * 5)); }
        }
        .carousel-track {
            animation: scroll 40s linear infinite;
            display: flex;
            width: calc(250px * 10);
        }
        .carousel-track:hover {
            animation-play-state: paused;
        }
        .slide {
            width: 250px;
        }
        
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-white text-gbm-dark antialiased selection:bg-gbm-black selection:text-white overflow-x-hidden">

    <!-- Header / Navigation -->
    <header class="fixed w-full top-0 z-50 nav-glassmorphism transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <img src="assets/logos/latticework-logo-h-dark.svg" alt="Latticework" class="h-8 md:h-10 w-auto">
                </div>

                <nav class="hidden md:flex space-x-10">
                    <a href="#solutions" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Soluciones</a>
                    <a href="#flexibilidad" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Flexibilidad</a>
                    <a href="#security" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">Seguridad</a>
                    <a href="#faqs" class="text-gray-600 hover:text-gbm-black transition font-medium text-sm">FAQs</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="#" onclick="document.getElementById('modalLogin').classList.remove('hidden')" class="text-gbm-black hover:text-gray-600 transition font-semibold text-sm">Iniciar Sesión</a>
                    <a href="#" onclick="gtag('event', 'generate_lead', {'event_category': 'Cuenta', 'event_label': 'Nav_Abrir_Cuenta'}); document.getElementById('modalLogin').classList.remove('hidden')" class="bg-gbm-black text-white hover:bg-gray-800 px-6 py-2.5 rounded-full font-bold text-sm btn-gbm">Abrir cuenta</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobileMenuBtn" class="text-gbm-black hover:text-gray-600 focus:outline-none transition-transform active:scale-95 p-2 bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu (oculto por defecto) -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-[0_10px_20px_rgba(0,0,0,0.05)] rounded-b-3xl transform transition-transform duration-300 origin-top">
            <div class="px-8 py-6 space-y-2 flex flex-col">
                <a href="#solutions" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Soluciones</a>
                <a href="#flexibilidad" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Flexibilidad</a>
                <a href="#security" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">Seguridad</a>
                <a href="#faqs" class="text-gray-600 hover:text-gbm-black font-medium text-lg border-b border-gray-50 py-3 transition-colors">FAQs</a>
                <div class="mt-8 flex flex-col space-y-4">
                    <a href="#" onclick="document.getElementById('mobileMenu').classList.add('hidden'); document.getElementById('modalLogin').classList.remove('hidden')" class="w-full block text-center text-gbm-black bg-gray-100 hover:bg-gray-200 rounded-full py-3.5 font-bold text-base transition-colors mb-4">Iniciar Sesión</a>
                    <a href="#" onclick="gtag('event', 'generate_lead', {'event_category': 'Cuenta', 'event_label': 'MobileMenu_Abrir_Cuenta'}); document.getElementById('mobileMenu').classList.add('hidden'); document.getElementById('modalLogin').classList.remove('hidden')" class="w-full block text-center bg-gbm-black text-white hover:bg-gray-800 rounded-full py-3.5 font-bold text-base transition-colors btn-gbm shadow-md">Abrir cuenta</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-24 pb-10">
        
        <!-- Boxed Panoramic Hero Section -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto h-[85vh] min-h-[600px] rounded-[2.5rem] overflow-hidden relative mb-6 md:mb-8 shadow-sm">
            <!-- Background Image (V2 to break cache) -->
            <div class="absolute inset-0 z-0 bg-black">
                <img src="assets/images/latticework_hero_v2.png" alt="Latticework Hero" class="w-full h-full object-cover opacity-60">
                <!-- Dark Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
            </div>

            <!-- Hero Content Left Aligned -->
            <div class="relative z-10 h-full flex flex-col justify-center px-6 sm:px-12 md:px-20 text-left max-w-4xl">
                <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-extrabold text-white tracking-tight mb-6 sm:mb-8 leading-[1.1] md:leading-[1.05] dark-progressive-blur">
                    Banca digital rápida y segura para empresas mayoristas.
                </h1>

                <p class="text-lg sm:text-xl md:text-2xl text-gray-300 mb-8 sm:mb-10 max-w-2xl leading-relaxed">
                    Elimina las barreras del comercio internacional: acepta USDT y recibe transferencias bancarias el mismo día directamente en tu cuenta.
                </p>

                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="#" onclick="gtag('event', 'generate_lead', {'event_category': 'Cuenta', 'event_label': 'Hero_Abrir_Cuenta'}); document.getElementById('modalLogin').classList.remove('hidden')" class="bg-white text-gbm-black hover:bg-gray-100 font-bold px-8 py-3.5 sm:py-4 rounded-full btn-gbm text-center text-base sm:text-lg">
                        Abre tu cuenta B2B
                    </a>
                    <a href="#solutions" class="bg-transparent border border-white/50 text-white hover:bg-white/10 font-bold px-8 py-3.5 sm:py-4 rounded-full transition text-center flex items-center justify-center text-base sm:text-lg">
                        Conoce más sobre Latticework <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Boxed Transacciones Rápidas / Alert Section -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-dark text-white p-10 md:p-20 relative overflow-hidden mb-6 md:mb-8 shadow-sm">
            <!-- Background SVG texture -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('assets/logos/latticework-dark-bg.svg'); background-size: cover; background-position: center;"></div>
            
            <div class="relative z-10 text-center">
                <!-- Banner Alerta
                <div class="bg-white/5 border border-white/10 rounded-full py-3 px-6 mb-12 backdrop-blur-sm inline-flex flex-col md:flex-row items-center justify-center">
                    <span class="text-sm font-medium mr-2">Latticework anunció recientemente una ronda de financiación de 5 millones de dólares.</span>
                    <a href="https://getshield.xyz" target="_blank" class="text-blue-400 hover:text-blue-300 text-sm font-bold underline underline-offset-4">Lee la historia completa aquí.</a>
                </div>
                -->

                <h2 class="text-3xl md:text-5xl font-extrabold leading-tight mb-10 max-w-4xl mx-auto tracking-tight">
                    Transacciones rápidas • Transferencias el mismo día • Apertura gratuita • Sin cuotas mensuales
                </h2>

                <!-- Call to action button WhatsApp -->
                <div class="mt-10 md:mt-16 text-center">
                    <a href="https://wa.me/525529067289?text=Hola.%20Me%20interesa%20invertir,%20por%20favor%20comun%C3%ADquense%20conmigo." onclick="gtag('event', 'generate_lead', {'event_category': 'WhatsApp', 'event_label': 'Mid_CTA'});" target="_blank" class="inline-flex items-center justify-center bg-[#25D366] hover:bg-[#128C7E] text-white font-bold px-8 py-4 rounded-full transition text-lg btn-gbm mb-12">
                        Contactar por WhatsApp
                    </a>
                </div>

                <div class="max-w-2xl mx-auto border-t border-white/10 pt-8 mt-4">
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Latticework está registrada como empresa de servicios monetarios (MSB) ante el Departamento del Tesoro de EE. UU. y cuenta con una cobertura de hasta 1 millón de dólares contra pérdidas, fraudes o robos.
                    </p>
                </div>
            </div>
        </section>

        <!-- Boxed Carousels (Medios & VCs) -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-light overflow-hidden mb-6 md:mb-8 shadow-sm border border-gray-100 flex flex-col">
            <!-- Medios -->
            <div class="py-12 border-b border-gray-200">
                <div class="text-center mb-8">
                    <p class="text-gray-500 font-medium text-sm tracking-widest uppercase">Con el respaldo de</p>
                </div>
                <div class="relative w-full overflow-hidden">
                    <div class="carousel-track items-center">
                        <!-- Original 5 -->
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-serif font-bold text-black">Forbes</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-extrabold tracking-tighter text-black">TC</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-serif font-bold text-black italic">WSJ</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-2xl font-serif font-black text-blue-800">Miami Herald</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-bold text-purple-700">yahoo!<span class="text-xl font-medium">finance</span></h3></div>
                        <!-- Duplicate 5 -->
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-serif font-bold text-black">Forbes</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-extrabold tracking-tighter text-black">TC</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-serif font-bold text-black italic">WSJ</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-2xl font-serif font-black text-blue-800">Miami Herald</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-40 hover:opacity-100 transition"><h3 class="text-3xl font-bold text-purple-700">yahoo!<span class="text-xl font-medium">finance</span></h3></div>
                    </div>
                </div>
            </div>

            <!-- VCs -->
            <div class="py-12 bg-gbm-dark text-white relative">
                <div class="text-center mb-8 px-6">
                    <p class="text-gray-400 font-medium text-sm tracking-widest uppercase">Con el respaldo de fondos de capital riesgo e inversores ángeles</p>
                </div>
                <div class="relative w-full overflow-hidden">
                    <div class="carousel-track items-center" style="animation-direction: reverse; animation-duration: 45s;">
                        <!-- Original 5 -->
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold border border-white rounded-full px-5 py-1">GIANT<span class="text-[0.65rem] block text-center font-normal">VENTURES</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold text-orange-500">a16z <span class="text-white text-sm">CRYPTO</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold text-purple-400">kraken <span class="font-normal text-white text-lg">VENTURES</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-3xl font-bold tracking-tight text-white flex items-center"><span class="w-5 h-5 rounded-full bg-white mr-2"></span> MoonPay</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-light tracking-widest text-white">FACTOR <span class="font-bold block text-[0.7rem]">CAPITAL</span></h3></div>
                        <!-- Duplicate 5 -->
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold border border-white rounded-full px-5 py-1">GIANT<span class="text-[0.65rem] block text-center font-normal">VENTURES</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold text-orange-500">a16z <span class="text-white text-sm">CRYPTO</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-bold text-purple-400">kraken <span class="font-normal text-white text-lg">VENTURES</span></h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-3xl font-bold tracking-tight text-white flex items-center"><span class="w-5 h-5 rounded-full bg-white mr-2"></span> MoonPay</h3></div>
                        <div class="slide flex justify-center items-center px-8 opacity-60 hover:opacity-100 transition"><h3 class="text-2xl font-light tracking-widest text-white">FACTOR <span class="font-bold block text-[0.7rem]">CAPITAL</span></h3></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Boxed Solutions Section -->
        <section id="solutions" class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-white p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm">
            <div class="max-w-3xl mb-16 text-left">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gbm-black tracking-tight mb-6">Accede a mercados globales con pagos en stablecoins</h2>
                <p class="text-lg text-gray-600">Impulsa tu negocio con conversiones de divisa sin fricción, cuentas multidivisa y opciones de pago flexibles.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full text-left">
                    <div class="w-14 h-14 rounded-full bg-gbm-light border border-gray-200 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-gbm-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gbm-black mb-4">Acepta USDT y otros pagos digitales</h3>
                    <p class="text-gray-600 flex-grow leading-relaxed">Ofrecemos botones de pago, links y direcciones para integrarse fácilmente con tu checkout.</p>
                </div>

                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full text-left">
                    <div class="w-14 h-14 rounded-full bg-gbm-light border border-gray-200 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-gbm-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gbm-black mb-4">Cuenta bancaria en USD / EUR</h3>
                    <p class="text-gray-600 flex-grow leading-relaxed">Envía y recibe transferencias desde EE.UU. y Europa sin complicaciones.</p>
                </div>

                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full text-left">
                    <div class="w-14 h-14 rounded-full bg-gbm-light border border-gray-200 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-gbm-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gbm-black mb-4">Exchange B2B</h3>
                    <p class="text-gray-600 flex-grow leading-relaxed">Compra, vende o intercambia activos digitales desde una cuenta empresarial unificada.</p>
                </div>
            </div>
        </section>

        <!-- Boxed Elige tu camino Section -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-dark text-white p-10 md:p-20 relative overflow-hidden mb-6 md:mb-8 shadow-sm">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('assets/logos/latticework-dark-bg.svg'); background-size: cover; background-position: center;"></div>
            
            <div class="relative z-10">
                <div class="text-left max-w-2xl mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Elige tu camino</h2>
                    <p class="text-lg text-gray-400">¿Quién eres? Selecciona la experiencia adecuada para ti:</p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition text-left">
                        <h3 class="text-2xl font-bold mb-3">Exportadores en EE.UU.</h3>
                        <p class="text-gray-400 mb-8">Envía y recibe pagos internacionales sin fricción.</p>
                        <a href="#" onclick="document.getElementById('modalLogin').classList.remove('hidden')" class="text-white font-semibold underline decoration-gray-500 hover:decoration-white transition">Empezar a enviar pagos →</a>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition text-left">
                        <h3 class="text-2xl font-bold mb-3">Compradores internacionales</h3>
                        <p class="text-gray-400 mb-8">Paga a empresas en EE.UU. con total confianza.</p>
                        <a href="#" onclick="document.getElementById('modalLogin').classList.remove('hidden')" class="text-white font-semibold underline decoration-gray-500 hover:decoration-white transition">Realizar un pago seguro →</a>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition text-left">
                        <h3 class="text-2xl font-bold mb-3">Otras empresas</h3>
                        <p class="text-gray-400 mb-8">Conecta con Latticework y simplifica tus operaciones.</p>
                        <a href="#solutions" class="text-white font-semibold underline decoration-gray-500 hover:decoration-white transition">Explorar soluciones →</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Boxed Stats Section -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-light p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm text-center">
            <h2 class="text-4xl font-extrabold text-gbm-black tracking-tight mb-4">Nuestro desempeño habla por sí solo</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-16">
                <div class="p-4">
                    <p class="text-6xl font-black text-gbm-black mb-4">$400m+</p>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-widest">Volumen procesado</p>
                </div>
                <div class="p-4 md:border-l border-gray-200">
                    <p class="text-6xl font-black text-gbm-black mb-4">9.000+</p>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-widest">Transacciones</p>
                </div>
                <div class="p-4 md:border-l border-gray-200">
                    <p class="text-6xl font-black text-gbm-black mb-4">100k+</p>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-widest">Millas en eventos globales</p>
                </div>
            </div>
        </section>

        <!-- Boxed Security Section -->
        <section id="security" class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-white p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative rounded-[2rem] overflow-hidden bg-gbm-light w-full aspect-square md:aspect-auto md:h-full md:min-h-[400px]">
                    <img src="assets/images/shield_security.png" alt="Institutional Security" class="absolute inset-0 w-full h-full object-cover">
                </div>
                
                <div class="order-1 lg:order-2 text-left">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gbm-black tracking-tight mb-8">Seguridad de nivel institucional.</h2>
                    <p class="text-xl text-gray-600 mb-12">Protección de nivel bancario y monitoreo en tiempo real para operaciones globales.</p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="mt-1 mr-4">
                                <div class="w-8 h-8 rounded-full bg-gbm-black text-white flex items-center justify-center font-bold">✓</div>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gbm-black mb-2">SOC 2 Tipo I (en proceso)</h4>
                                <p class="text-gray-600">Monitoreo continuo y controles automatizados.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="mt-1 mr-4">
                                <div class="w-8 h-8 rounded-full bg-gbm-black text-white flex items-center justify-center font-bold">✓</div>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gbm-black mb-2">Seguro de activos hasta $1M</h4>
                                <p class="text-gray-600">Protección respaldada por Lloyd's of London y AmTrust.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="mt-1 mr-4">
                                <div class="w-8 h-8 rounded-full bg-gbm-black text-white flex items-center justify-center font-bold">✓</div>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gbm-black mb-2">Monitoreo AML en tiempo real</h4>
                                <p class="text-gray-600">Detección y bloqueo de activos sancionados.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Boxed Flexibilidad Section -->
        <section id="flexibilidad" class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-light p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm text-left">
            <div class="flex flex-col lg:flex-row gap-16 items-start">
                <div class="lg:w-1/3">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gbm-black tracking-tight mb-6">Revolucionando la flexibilidad en pagos</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        En la economía digital actual, cada vez más clientes prefieren pagar con stablecoins. Latticework permite a tu negocio acceder a este mercado y atraer nuevos clientes a nivel global.
                    </p>
                </div>
                <div class="lg:w-2/3 grid sm:grid-cols-2 gap-x-12 gap-y-12">
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-200">
                        <h4 class="text-xl font-bold text-gbm-black mb-3">Casos de uso flexibles</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Operamos como proveedor VASP licenciado. Acepta stablecoins y recibe fiat, o viceversa.</p>
                    </div>
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-200">
                        <h4 class="text-xl font-bold text-gbm-black mb-3">Procesamiento rápido</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Operamos a velocidad blockchain: recibes los fondos el mismo día.</p>
                    </div>
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-200">
                        <h4 class="text-xl font-bold text-gbm-black mb-3">Experiencia simple</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Botones de pago, links tipo Stripe o direcciones directas — nos integramos a tu flujo.</p>
                    </div>
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-200">
                        <h4 class="text-xl font-bold text-gbm-black mb-3">Tarifas competitivas</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Sin costo de integración. Desde 1% por transacción, con descuentos por volumen.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Boxed Testimonials Trustpilot -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-white pt-20 pb-16 mb-6 md:mb-8 border border-gray-100 shadow-sm overflow-hidden text-center">
            <div class="mb-12 px-10">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gbm-black tracking-tight">Las empresas confían en nosotros</h2>
                <div class="flex justify-center items-center mt-6">
                    <span class="text-yellow-400 text-2xl tracking-widest">★★★★★</span>
                    <span class="ml-3 font-bold text-gray-800 text-lg">4.9/5 en Trustpilot</span>
                </div>
            </div>
            
            <!-- Emulated Trustpilot Carousel -->
            <div id="testimonials-slider" class="flex overflow-x-auto pb-10 snap-x scroll-smooth px-10 gap-6 hide-scrollbar text-left relative">
                <!-- Testimonial 1 -->
                <div class="min-w-[280px] max-w-[320px] md:max-w-[350px] bg-gbm-light rounded-[2rem] p-6 sm:p-8 border border-gray-100 snap-center flex-shrink-0">
                    <div class="text-yellow-400 text-lg mb-4 tracking-widest">★★★★★</div>
                    <p class="text-gray-800 font-medium mb-6 text-sm sm:text-base">"Latticework ha transformado nuestra manera de operar internacionalmente. Procesamiento rápido y transparente."</p>
                    <p class="text-sm font-bold text-gray-900">CEO, Tech Corp</p>
                    <p class="text-xs text-gray-500">hace 2 días</p>
                </div>
                <!-- Testimonial 2 -->
                <div class="min-w-[280px] max-w-[320px] md:max-w-[350px] bg-gbm-light rounded-[2rem] p-6 sm:p-8 border border-gray-100 snap-center flex-shrink-0">
                    <div class="text-yellow-400 text-lg mb-4 tracking-widest">★★★★★</div>
                    <p class="text-gray-800 font-medium mb-6 text-sm sm:text-base">"La mejor pasarela B2B que hemos utilizado. Soporte excepcional y facilidad para recibir USDT en nuestra cuenta corporativa."</p>
                    <p class="text-sm font-bold text-gray-900">Directora Financiera</p>
                    <p class="text-xs text-gray-500">hace 1 semana</p>
                </div>
                <!-- Testimonial 3 -->
                <div class="min-w-[280px] max-w-[320px] md:max-w-[350px] bg-gbm-light rounded-[2rem] p-6 sm:p-8 border border-gray-100 snap-center flex-shrink-0">
                    <div class="text-yellow-400 text-lg mb-4 tracking-widest">★★★★★</div>
                    <p class="text-gray-800 font-medium mb-6 text-sm sm:text-base">"Pagar a proveedores en EE.UU. nunca fue tan sencillo. Eliminamos los dolores de cabeza de las transferencias Swift tradicionales."</p>
                    <p class="text-sm font-bold text-gray-900">Director de Compras</p>
                    <p class="text-xs text-gray-500">hace 2 semanas</p>
                </div>
                <!-- Testimonial 4 -->
                <div class="min-w-[280px] max-w-[320px] md:max-w-[350px] bg-gbm-light rounded-[2rem] p-6 sm:p-8 border border-gray-100 snap-center flex-shrink-0">
                    <div class="text-yellow-400 text-lg mb-4 tracking-widest">★★★★★</div>
                    <p class="text-gray-800 font-medium mb-6 text-sm sm:text-base">"Increíble interfaz y seguridad de nivel institucional. Todo lo que una empresa moderna necesita para transacciones globales."</p>
                    <p class="text-sm font-bold text-gray-900">Fundador, Startup Fintech</p>
                    <p class="text-xs text-gray-500">hace 1 mes</p>
                </div>
            </div>
        </section>

        <!-- Boxed Video Testimonial -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-dark text-white p-10 md:p-20 mb-6 md:mb-8 relative overflow-hidden text-center">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('assets/logos/latticework-dark-bg.svg'); background-size: cover; background-position: center;"></div>
            
            <div class="relative z-10 max-w-4xl mx-auto">
                <h2 class="text-4xl font-extrabold tracking-tight mb-4">Testimonios de clientes</h2>
                <p class="text-lg text-gray-400 mb-12">Conoce de primera mano cómo impulsamos sus negocios a nivel mundial.</p>
                
                <div class="relative rounded-[2rem] overflow-hidden bg-black aspect-video border border-gray-800">
                    <iframe 
                        class="absolute inset-0 w-full h-full" 
                        src="https://www.youtube.com/embed/MN58hN6FXys?si=H5BaU9H6PI8XBSP4&rel=0" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </section>

        <!-- Boxed Nuestros Clientes & Dónde nos han visto -->
        <section class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-gbm-light p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm text-center">
            
            <div class="mb-24">
                <h2 class="text-4xl font-extrabold text-gbm-black tracking-tight mb-4">Nuestros clientes</h2>
                <p class="text-lg text-gray-600 mb-12">Empresas que ya operan en el mercado global con nosotros.</p>
                
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm flex flex-col items-center justify-center aspect-[4/3]">
                        <h3 class="text-3xl font-bold text-gray-900 mb-1">Eze</h3>
                        <p class="text-gray-400 font-medium text-sm tracking-widest uppercase">Technologies</p>
                    </div>
                    <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm flex flex-col items-center justify-center aspect-[4/3]">
                        <h3 class="text-4xl font-extrabold text-blue-600">RecirQ</h3>
                    </div>
                    <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm flex flex-col items-center justify-center aspect-[4/3]">
                        <h3 class="text-2xl font-serif font-bold text-gray-800">Mannapov LLC</h3>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-20 max-w-5xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-400 tracking-widest uppercase mb-12">Dónde nos han visto</h2>
                <div class="flex flex-wrap justify-center items-center gap-10 md:gap-20">
                    <h3 class="text-3xl font-bold text-[#bad7e4]">yahoo!<span class="text-xl font-medium">finance</span></h3>
                    <h3 class="text-3xl font-serif font-bold text-[#15272F] italic">WSJ</h3>
                    <h3 class="text-3xl font-extrabold tracking-tighter text-[#15272F]">TC</h3>
                    <h3 class="text-3xl font-serif font-bold text-[#15272F]">Forbes</h3>
                </div>
            </div>

        </section>

        <!-- Boxed FAQs Section -->
        <section id="faqs" class="w-[calc(100%-1.5rem)] md:w-[calc(100%-2.5rem)] max-w-7xl mx-auto rounded-[2.5rem] bg-white p-10 md:p-20 mb-6 md:mb-8 border border-gray-100 shadow-sm text-left">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gbm-black tracking-tight mb-16 text-center">Preguntas Frecuentes</h2>
                
                <div class="space-y-4">
                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Es legal? ¿Mi banco puede bloquear mi cuenta? ¿Qué pasa con los impuestos?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Latticework opera en estricto cumplimiento normativo (MSB). Nuestro marco legal protege tus operaciones internacionales de manera transparente y segura.</p>
                    </details>
                    
                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Por qué aceptar stablecoins como método de pago?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Las stablecoins ofrecen liquidación casi instantánea y con comisiones mucho menores comparadas a las transferencias SWIFT tradicionales, eliminando el riesgo de volatilidad.</p>
                    </details>

                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Tienen algún tipo de seguro?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Sí, los fondos fiduciarios están resguardados por instituciones bancarias reguladas en EE.UU., ofreciendo seguro FDIC hasta $250,000 USD aplicable a los saldos en dólares.</p>
                    </details>

                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Qué pasa si no puedo aceptar pagos de terceros? ¿Mi cliente puede pagarme directamente?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Con Latticework recibes una cuenta bancaria virtual a nombre de tu empresa (FBO). Así, los pagos que recibes provienen directamente de las cuentas de tus clientes sin intermediarios de terceros visibles.</p>
                    </details>

                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Quién está detrás de Latticework y por qué puedo confiar en ustedes?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Somos un equipo de expertos financieros y tecnológicos operando bajo estrictas regulaciones KYC/AML y sólidas alianzas con instituciones financieras reguladas en Estados Unidos.</p>
                    </details>

                    <details class="group border border-gray-100 rounded-[2rem] p-8 hover:bg-gbm-light transition bg-white cursor-pointer shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="text-xl font-bold text-gbm-black flex justify-between items-center outline-none list-none">
                            <span>¿Cuánto cuesta usar Latticework?</span>
                            <span class="transition group-open:rotate-180 text-gbm-accent">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-4 leading-relaxed text-sm">Nuestra estructura de comisiones es completamente transparente: sin costos de apertura ni cuotas de mantenimiento mensual. Solo pagas una pequeña comisión variable al momento de liquidar divisas.</p>
                    </details>
                </div>
            </div>
        </section>

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
                    <p class="text-gray-400 text-xs max-w-sm leading-relaxed">
                        Servicios de transmisión de dinero para residentes en EE.UU. son proporcionados por Bridge Building Inc. NMLS # 2450917. Servicios para residentes fuera del EEE son proporcionados por Shield Security Inc.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-gbm-black mb-6">Plataforma</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#solutions" class="hover:text-gbm-black transition">Cómo funciona</a></li>
                        <li><a href="#" onclick="document.getElementById('modalLogin').classList.remove('hidden')" class="hover:text-gbm-black transition">Abre tu cuenta</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gbm-black mb-6">Empresa</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#flexibilidad" class="hover:text-gbm-black transition">Nosotros</a></li>
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

    <!-- Modal de Login (Preserved intact for backend) -->
    <div id="modalLogin" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('modalLogin').classList.add('hidden')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-[2rem] shadow-2xl p-8 border border-gray-100">
            <div class="text-center mb-6">
                <img src="assets/logos/latticework-logo-h-dark.svg" alt="Latticework" class="h-6 mx-auto mb-4">
                <h3 class="text-2xl font-bold text-gbm-black tracking-tight">Iniciar Sesión</h3>
                <p class="text-sm text-gray-500 mt-1">Accede a tu cuenta operativa</p>
            </div>
            <form id="loginForm" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                    <input type="email" id="loginEmail" required placeholder="correo@ejemplo.com" class="w-full bg-gbm-light border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gbm-black focus:border-transparent text-base transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                    <input type="password" id="loginPassword" required placeholder="••••••••" class="w-full bg-gbm-light border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gbm-black focus:border-transparent text-base transition">
                </div>

                <button id="loginSubmitBtn" type="submit" class="w-full bg-gbm-black text-white font-bold py-3.5 rounded-full btn-gbm shadow-none mt-6 flex justify-center items-center">
                    Ingresar
                </button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-600">
                ¿Aún no tienes cuenta? <br>
                <a href="https://wa.me/525529067289?text=Hola.%20Me%20interesa%20invertir,%20por%20favor%20comun%C3%ADquense%20conmigo." target="_blank" class="text-gbm-black font-bold hover:underline">Contacta a un asesor para abrir una</a>
            </div>
            <div class="mt-4 text-center">
                <button type="button" onclick="document.getElementById('modalLogin').classList.add('hidden')" class="text-sm font-medium text-gray-500 hover:text-black transition">Cancelar</button>
            </div>
        </div>

    </div>

    <script src="js/api.js?v=2"></script>
    <script src="js/app.js"></script>
    <script src="js/shield.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.remove('hidden');
                        // Reset icon to X
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    } else {
                        mobileMenu.classList.add('hidden');
                        // Reset icon to Hamburger
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
                    }
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
                    }
                });

                // Close menu when clicking a link
                mobileMenu.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function () {
                        mobileMenu.classList.add('hidden');
                        mobileMenuBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
                    });
                });
            }

            // Testimonials Auto-Slide
            const slider = document.getElementById('testimonials-slider');
            if (slider) {
                let autoPlayInterval;
                const startAutoPlay = () => {
                    autoPlayInterval = setInterval(() => {
                        // Calcula si ha llegado al final (con un pequeño margen de 10px)
                        if (slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 10)) {
                            slider.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            slider.scrollBy({ left: 340, behavior: 'smooth' }); // Ancho aprox de la tarjeta + gap
                        }
                    }, 3500);
                };
                
                // Pausar en interacción
                slider.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
                slider.addEventListener('mouseleave', startAutoPlay);
                slider.addEventListener('touchstart', () => clearInterval(autoPlayInterval));
                slider.addEventListener('touchend', startAutoPlay);
                
                startAutoPlay();
            }
        });
    </script>
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/525529067289?text=Hola.%20Me%20interesa%20invertir,%20por%20favor%20comun%C3%ADquense%20conmigo." onclick="gtag('event', 'generate_lead', {'event_category': 'WhatsApp', 'event_label': 'Floating_Button'});" target="_blank" class="fixed bottom-6 left-6 z-[100] bg-[#25D366] text-white p-4 rounded-full shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-300 flex items-center justify-center group">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.388 0 12.04c0 2.115.548 4.188 1.587 6.012L.05 24l6.095-1.597c1.785.952 3.791 1.453 5.882 1.453h.004c6.645 0 12.031-5.388 12.031-12.04C24.062 5.388 18.675 0 12.031 0zm0 21.905c-1.802 0-3.558-.485-5.11-1.406l-.366-.217-3.8.995 1.014-3.705-.238-.38c-1.01-1.611-1.543-3.483-1.543-5.418 0-5.632 4.582-10.218 10.218-10.218 5.632 0 10.218 4.586 10.218 10.218 0 5.633-4.586 10.218-10.218 10.218zm5.6-7.653c-.307-.154-1.818-.899-2.1-1.002-.282-.103-.487-.154-.693.154-.205.308-.795 1.002-.975 1.208-.18.205-.359.231-.667.077-1.411-.703-2.529-1.53-3.51-2.906-.255-.357.256-.328.847-1.503.076-.154.038-.282-.038-.436-.077-.154-.693-1.67-.949-2.287-.25-.6-.505-.519-.693-.529-.18-.01-.385-.01-.591-.01-.205 0-.539.077-.821.385-.282.308-1.077 1.052-1.077 2.566s1.103 2.977 1.257 3.182c.154.205 2.169 3.31 5.253 4.641.733.316 1.305.505 1.752.646.736.233 1.405.2 1.933.12.593-.089 1.818-.744 2.074-1.463.256-.718.256-1.334.18-1.463-.077-.128-.282-.205-.59-.359z"></path></svg>
    </a>
</body>
</html>