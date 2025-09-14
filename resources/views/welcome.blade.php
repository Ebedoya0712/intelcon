<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelcom - Servicios de Internet de Alta Velocidad</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Estilos para el link del teléfono */
        .contact-card a {
            text-decoration: none;
            color: #333;
        }

        .tech-gradient {
            background: linear-gradient(135deg, #0066cc 0%, #004499 50%, #002266 100%);
            position: relative;
        }

        .tech-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(0,255,255,0.1)" opacity="0.6"><animate attributeName="r" values="2;4;2" dur="3s" repeatCount="indefinite"/></circle><circle cx="80" cy="30" r="1.5" fill="rgba(0,255,255,0.08)" opacity="0.8"><animate attributeName="r" values="1.5;3;1.5" dur="4s" repeatCount="indefinite"/></circle><circle cx="60" cy="70" r="2.5" fill="rgba(255,255,255,0.06)" opacity="0.4"><animate attributeName="r" values="2.5;4.5;2.5" dur="5s" repeatCount="indefinite"/></circle></svg>');
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        header {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 125px; 
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #0066cc;
        }
        
        .hamburger, .close-menu {
            display: none;
            cursor: pointer;
            font-size: 1.8rem;
        }

        .hero {
            padding: 10rem 0 8rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 102, 204, 0.1), rgba(0, 204, 255, 0.1));
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #00ccff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideInUp 1s ease-out;
        }

        .hero .subtitle {
            font-size: 1.5rem;
            margin-bottom: 2.5rem; 
            opacity: 0.95;
            animation: slideInUp 1s ease-out 0.2s both;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            animation: slideInUp 1s ease-out 0.6s both;
        }

        .btn-primary {
            background: linear-gradient(45deg, #00ccff, #0099cc);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 204, 255, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 204, 255, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border: 2px solid white;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: white;
            color: #0066cc;
            transform: translateY(-3px);
        }

        .services {
            background: white;
            padding: 6rem 0;
            position: relative;
        }

        .services::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            right: 0;
            height: 100px;
            background: white;
            transform: skewY(-2deg);
        }
        
        .section-title {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, #0066cc, #00ccff);
            border-radius: 2px;
        }
        
        .section-subtitle {
            text-align: center; 
            font-size: 1.2rem; 
            margin-bottom: 4rem;
            color: #555;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 800px; 
            margin: 0 auto;
        }

        .service-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 102, 204, 0.15);
        }

        .service-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #0066cc, #00ccff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
        }

        .plans {
            background: #f8f9fa;
            padding: 6rem 0;
            text-align: center;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            margin-bottom: 4rem;
        }

        .benefit-item {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #dee2e6;
        }
        
        .benefit-item i {
            font-size: 2.5rem;
            color: #0066cc;
            margin-bottom: 1rem;
        }

        .benefit-item h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .why-us {
            background: linear-gradient(135deg, #0066cc 0%, #004499 100%);
            color: white;
            padding: 6rem 0;
            text-align: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature-item {
            padding: 2.5rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .feature-item i {
            font-size: 3rem;
            color: #00ccff;
            margin-bottom: 1.5rem;
        }

        .feature-item h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }

        .contact-section {
            background: white;
            padding: 6rem 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .contact-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            background: #e9ecef;
            transform: translateY(-5px);
        }

        .contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0066cc, #00ccff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: white;
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            background: #1a1a1a;
            color: white;
            text-align: center;
            padding: 3rem 0;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        .footer-section h3 {
            color: #00ccff;
            margin-bottom: 1rem;
        }
        
        .copyright {
            border-top: 1px solid #333; 
            padding-top: 2rem; 
            margin-top: 2rem;
            text-align: center;
        }

        @media (max-width: 992px) {
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                max-width: 320px;
                height: 100vh;
                background: #fff;
                flex-direction: column;
                padding: 5rem 2rem 2rem;
                gap: 2.5rem;
                justify-content: flex-start;
                align-items: flex-start;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                transition: right 0.4s ease-in-out;
            }

            .nav-links.active {
                right: 0;
            }
            
            .hamburger {
                display: block;
            }

            .close-menu {
                display: block;
                position: absolute;
                top: 1.5rem;
                right: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.8rem; }
            .section-title { font-size: 2.5rem; }
            .cta-buttons { flex-direction: column; align-items: center; }
            .services-grid, .plans-grid, .features-grid, .footer-content { 
                grid-template-columns: 1fr; 
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="/">
                     <img src="{{ asset('images/logo.png') }}" alt="Logo de Intelcom">
                </a>
            </div>
            
            <ul class="nav-links" id="nav-menu">
                <div class="close-menu" id="close-btn"><i class="fas fa-times"></i></div>
                <li><a href="#servicios">Soluciones</a></li>
                <li><a href="#planes">Planes</a></li>
                <li><a href="#porque-intelcom">Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li>
                    <a href="{{ route('login') }}" class="btn-primary" style="padding: 10px 25px;">
                        <i class="fas fa-right-to-bracket"></i> Iniciar Sesión
                    </a>
                </li>
            </ul>

            <div class="hamburger" id="hamburger-btn">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <div class="tech-gradient">
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="floating">Internet de Alta Velocidad</h1>
                    <p class="subtitle">Conectividad confiable y a tu medida, donde quiera que estés.</p>
                    
                    <div class="cta-buttons">
                        <a href="#planes" class="btn-primary">
                            <i class="fas fa-wifi"></i> Conoce Más
                        </a>
                        <a href="#contacto" class="btn-secondary">
                            <i class="fas fa-phone"></i> Contactar
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="services" id="servicios">
        <div class="container">
            <h2 class="section-title">Nuestras Soluciones</h2>
            <p class="section-subtitle">Conectividad para cada necesidad.</p>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Internet Residencial</h3>
                    <p>Conexión estable y veloz para tu hogar. Navega, transmite contenido y mantente conectado sin interrupciones.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Internet Empresarial</h3>
                    <p>Soluciones de conectividad robustas para asegurar la productividad y continuidad de tu negocio.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="plans" id="planes">
        <div class="container">
            <h2 class="section-title">Planes Flexibles para Ti</h2>
            <p class="section-subtitle">
                Ofrecemos una variedad de planes que se adaptan a tu ubicación y necesidades.
                <br><strong>Tenemos velocidades desde 10 megas en adelante.</strong>
            </p>
            
            <div class="benefits-grid">
                <div class="benefit-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <h3>Alta Velocidad</h3>
                    <p>Disfruta de una conexión rápida para todas tus actividades en línea.</p>
                </div>
                 <div class="benefit-item">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Precios Justos</h3>
                    <p>Planes competitivos adaptados a la oferta de tu zona.</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-broadcast-tower"></i>
                    <h3>Conexión Estable</h3>
                    <p>Navega con la confianza de una red robusta y con mínimo de interrupciones.</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Amplia Cobertura</h3>
                    <p>Llegamos a cada vez más sectores para mantenerte conectado.</p>
                </div>
            </div>

            <a href="#contacto" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Consulta los Planes en tu Zona
            </a>

        </div>
    </section>

    <section class="why-us" id="porque-intelcom">
        <div class="container">
            <h2 class="section-title" style="color: white;">Por Qué Elegir Intelcom</h2>
            <p class="section-subtitle" style="color: #eee;">Comprometidos con ofrecerte la mejor conexión y un servicio de calidad.</p>
            
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-rocket"></i>
                    <h3>Tecnología de Punta</h3>
                    <p>Utilizamos redes de fibra óptica de última generación para garantizarte una conexión veloz y de baja latencia.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-map-signs"></i>
                    <h3>Cobertura en Expansión</h3>
                    <p>Trabajamos día a día para llevar nuestro servicio a más zonas. ¡Consulta si ya estamos en la tuya!</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-tools"></i>
                    <h3>Instalación Profesional</h3>
                    <p>Nuestro equipo técnico se encarga de todo para que empieces a navegar sin complicaciones.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contacto">
        <div class="container">
            <h2 class="section-title">Contáctanos</h2>
            <p class="section-subtitle">¿Listo para mejorar tu conexión? Consulta la cobertura y planes en tu zona.</p>
            
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Teléfono</h3>
                    <a href="tel:+584128202071">
                        <p>+58 412-8202071</p>
                    </a>
                    <p>Línea de atención</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>info@intelcom.com</p>
                    <p>ventas@intelcom.com</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Ubicación</h3>
                    <p>Oficina Central</p>
                    <p>Centro de la ciudad</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp</h3>
                    <a href="https://wa.me/584126304159">
                        <p>+58 412-6304159</p>
                    </a>
                    <p>Chatea con un asesor</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Intelcom</h3>
                    <p>Tu proveedor de confianza para internet de alta velocidad. Conectamos tu mundo digital.</p>
                </div>
                <div class="footer-section">
                    <h3>Servicios</h3>
                    <p>Internet Residencial<br>Internet Empresarial</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Intelcom. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // --- Lógica para el Menú Responsive ---
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const navMenu = document.getElementById('nav-menu');
        const closeBtn = document.getElementById('close-btn');
        const navLinks = document.querySelectorAll('#nav-menu a');

        hamburgerBtn.addEventListener('click', () => {
            navMenu.classList.add('active');
        });

        closeBtn.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });


        // --- Navegación suave ---
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // --- Efecto del Header al hacer scroll ---
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>