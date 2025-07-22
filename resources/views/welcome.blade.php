<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelcon - Servicios de Internet de Alta Velocidad</title>
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

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #0066cc;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .logo i {
            margin-right: 0.5rem;
            color: #00ccff;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
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

        .hero {
            padding: 8rem 0 6rem;
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
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .speed-showcase {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin: 2rem 0;
            animation: slideInUp 1s ease-out 0.4s both;
        }

        .speed-meter {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .speed-number {
            font-size: 3rem;
            font-weight: bold;
            color: #00ccff;
            display: block;
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

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .service-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 204, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .service-card:hover::before {
            left: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 102, 204, 0.15);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
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
            position: relative;
            z-index: 2;
        }

        .plans {
            background: #f8f9fa;
            padding: 6rem 0;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .plan-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
            position: relative;
        }

        .plan-card.featured {
            border-color: #00ccff;
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 204, 255, 0.2);
        }

        .plan-card.featured::before {
            content: 'Más Popular';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #00ccff;
            color: white;
            padding: 0.5rem 2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .plan-price {
            font-size: 3rem;
            font-weight: bold;
            color: #0066cc;
            margin: 1rem 0;
        }

        .plan-speed {
            font-size: 2rem;
            color: #00ccff;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .plan-features {
            list-style: none;
            margin: 2rem 0;
        }

        .plan-features li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features i {
            color: #28a745;
            margin-right: 0.5rem;
        }

        .coverage {
            background: linear-gradient(135deg, #0066cc 0%, #004499 100%);
            color: white;
            padding: 6rem 0;
            text-align: center;
        }

        .coverage-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .stat-item {
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #00ccff;
            display: block;
            margin-bottom: 0.5rem;
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

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        footer {
            background: #1a1a1a;
            color: white;
            text-align: center;
            padding: 3rem 0;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #00ccff;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .speed-showcase { flex-direction: column; gap: 1rem; }
            .cta-buttons { flex-direction: column; align-items: center; }
            .nav-links { display: none; }
            .services-grid { grid-template-columns: 1fr; }
            .plans-grid { grid-template-columns: 1fr; }
            .plan-card.featured { transform: none; }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo de Intelcon" style="height: 125px; margin-right: 10px; vertical-align: middle;">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#planes">Planes</a></li>
                <li><a href="#cobertura">Cobertura</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li>
                    <a href="{{ route('login') }}" class="btn-primary" style="border-radius: 30px; padding: 10px 20px;">
                        <i class="fas fa-right-to-bracket"></i> Iniciar Sesión
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="tech-gradient">
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="floating">Internet de Alta Velocidad</h1>
                    <p class="subtitle">Conectividad confiable para tu hogar y negocio</p>
                    
                    <div class="speed-showcase">
                        <div class="speed-meter pulse">
                            <span class="speed-number">100</span>
                            <span>Mbps</span>
                        </div>
                        <div class="speed-meter pulse">
                            <span class="speed-number">300</span>
                            <span>Mbps</span>
                        </div>
                        <div class="speed-meter pulse">
                            <span class="speed-number">500</span>
                            <span>Mbps</span>
                        </div>
                    </div>

                    <div class="cta-buttons">
                        {{-- Botón para Iniciar Sesión --}}
                        <a href="{{ route('login') }}" class="btn-primary">
                            <i class="fas fa-right-to-bracket"></i> Iniciar Sesión
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
            <h2 class="section-title">Nuestros Servicios</h2>
            <p style="text-align: center; font-size: 1.2rem; margin-bottom: 2rem;">Soluciones de conectividad para cada necesidad</p>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Internet Residencial</h3>
                    <p>Planes de internet de alta velocidad para tu hogar. Navega, transmite y juega sin límites con nuestra fibra óptica de última generación.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Internet Empresarial</h3>
                    <p>Soluciones corporativas con ancho de banda dedicado, IP fija y soporte técnico 24/7 para mantener tu negocio siempre conectado.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Soporte Técnico</h3>
                    <p>Atención personalizada las 24 horas del día, los 7 días de la semana. Nuestro equipo de expertos está aquí para ayudarte.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="plans" id="planes">
        <div class="container">
            <h2 class="section-title">Planes de Internet</h2>
            <p style="text-align: center; font-size: 1.2rem; margin-bottom: 2rem;">Elige el plan perfecto para ti</p>
            
            <div class="plans-grid">
                <div class="plan-card">
                    <h3>Plan Básico</h3>
                    <div class="plan-price">$25</div>
                    <div class="plan-speed">100 Mbps</div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Velocidad hasta 100 Mbps</li>
                        <li><i class="fas fa-check"></i> Navegación ilimitada</li>
                        <li><i class="fas fa-check"></i> Soporte técnico básico</li>
                        <li><i class="fas fa-check"></i> Instalación gratuita</li>
                    </ul>
                    <a href="#contacto" class="btn-primary">Contratar</a>
                </div>

                <div class="plan-card featured">
                    <h3>Plan Premium</h3>
                    <div class="plan-price">$40</div>
                    <div class="plan-speed">300 Mbps</div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Velocidad hasta 300 Mbps</li>
                        <li><i class="fas fa-check"></i> Navegación ilimitada</li>
                        <li><i class="fas fa-check"></i> Soporte técnico 24/7</li>
                        <li><i class="fas fa-check"></i> Instalación gratuita</li>
                        <li><i class="fas fa-check"></i> Router WiFi 6 incluido</li>
                    </ul>
                    <a href="#contacto" class="btn-primary">Contratar</a>
                </div>

                <div class="plan-card">
                    <h3>Plan Ultra</h3>
                    <div class="plan-price">$60</div>
                    <div class="plan-speed">500 Mbps</div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Velocidad hasta 500 Mbps</li>
                        <li><i class="fas fa-check"></i> Navegación ilimitada</li>
                        <li><i class="fas fa-check"></i> Soporte técnico prioritario</li>
                        <li><i class="fas fa-check"></i> Instalación gratuita</li>
                        <li><i class="fas fa-check"></i> Router WiFi 6 Pro incluido</li>
                        <li><i class="fas fa-check"></i> IP fija gratuita</li>
                    </ul>
                    <a href="#contacto" class="btn-primary">Contratar</a>
                </div>
            </div>
        </div>
    </section>

    <section class="coverage" id="cobertura">
        <div class="container">
            <h2 class="section-title" style="color: white;">Nuestra Cobertura</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Llevamos internet de alta velocidad a toda la región</p>
            
            <div class="coverage-stats">
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span>Municipios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">200+</span>
                    <span>Barrios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">10K+</span>
                    <span>Clientes Satisfechos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">99.9%</span>
                    <span>Tiempo de Actividad</span>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contacto">
        <div class="container">
            <h2 class="section-title">Contáctanos</h2>
            <p style="text-align: center; font-size: 1.2rem; margin-bottom: 2rem;">¿Listo para mejorar tu conexión? Estamos aquí para ayudarte</p>
            
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Teléfono</h3>
                    <p>+57 300 123 4567</p>
                    <p>Línea de atención 24/7</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>info@intelcon.com</p>
                    <p>ventas@intelcon.com</p>
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
                    <p>+57 300 123 4567</p>
                    <p>Chat directo</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Intelcon</h3>
                    <p>Tu proveedor de confianza para internet de alta velocidad. Conectamos tu mundo digital.</p>
                </div>
                <div class="footer-section">
                    <h3>Servicios</h3>
                    <p>Internet Residencial<br>Internet Empresarial<br>Soporte Técnico</p>
                </div>
                <div class="footer-section">
                    <h3>Síguenos</h3>
                    <p>
                        <i class="fab fa-facebook" style="margin: 0 0.5rem;"></i>
                        <i class="fab fa-instagram" style="margin: 0 0.5rem;"></i>
                        <i class="fab fa-twitter" style="margin: 0 0.5rem;"></i>
                    </p>
                </div>
            </div>
            <div style="border-top: 1px solid #333; padding-top: 2rem; margin-top: 2rem;">
                <p>&copy; 2025 Intelcon. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navegación suave
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

        // Animación de contadores
        const animateCounters = () => {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/\D/g, ''));
                const suffix = counter.textContent.replace(/[\d.]/g, '');
                let count = 0;
                const increment = target / 100;
                
                const updateCounter = () => {
                    if (count < target) {
                        count += increment;
                        counter.textContent = Math.ceil(count) + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target + suffix;
                    }
                };
                updateCounter();
            });
        };

        // Observer para animaciones
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('coverage')) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observar elementos para animación
        document.querySelectorAll('.service-card, .plan-card, .contact-card, .coverage').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
