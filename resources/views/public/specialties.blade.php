@extends('layouts.public')

@section('title', 'Formación Técnica - CTP Roberto Gamboa Valverde')

@section('content')
<!-- Encabezado con animación -->
    <header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Formación Técnica</h1>
            <p>Preparamos profesionales técnicos competitivos para el mundo laboral</p>
        </div>
    </header>

    <!-- Introducción -->
    <section class="intro-section">
        <div class="container">
            <h2>Nuestra Oferta Educativa</h2>
            <p>En el CTP Roberto Gamboa Valverde, ofrecemos formación técnica de alta calidad que combina conocimientos teóricos con habilidades prácticas para preparar a nuestros estudiantes para el mercado laboral actual y futuro. Todas nuestras especialidades cuentan con certificación del Ministerio de Educación Pública y están diseñadas en colaboración con el sector empresarial.</p>
        </div>
    </section>

    <!-- Section separator -->
    <div class="section-separator">
        <i class="fas fa-graduation-cap"></i> Especialidades Técnicas
    </div>
    
    <!-- Selector de especialidades -->
    <div class="specialty-selector">
        <ul class="specialty-tabs">
            <li class="active" data-specialty="redes">Redes de Computadoras</li>
            <li data-specialty="contabilidad">Contabilidad y Finanzas</li>
            <li data-specialty="logistica">Logística y Distribución</li>
            <li data-specialty="electrotecnia">Electrotecnia</li>
            <li data-specialty="ejecutivo">Ejecutivo para Centros de Servicio</li>
            <li data-specialty="dibujo">Dibujo Técnico</li>
        </ul>
    </div>
    
    <!-- Contenido detallado de especialidades -->
    <section class="specialty-details">
        <!-- Redes de Computadoras -->
        <div class="specialty-content active" id="redes">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Redes de Computadoras</h2>
                <p class="specialty-description">Especialidad enfocada en el diseño, implementación y administración de sistemas de redes de comunicación, preparando técnicos capaces de gestionar la infraestructura tecnológica moderna.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Fundamentos de redes</li>
                            <li><i class="fas fa-check-circle"></i> Protocolos de comunicación</li>
                            <li><i class="fas fa-check-circle"></i> Seguridad informática</li>
                            <li><i class="fas fa-check-circle"></i> Administración de servidores</li>
                            <li><i class="fas fa-check-circle"></i> Tecnologías de virtualización</li>
                            <li><i class="fas fa-check-circle"></i> Soporte técnico</li>
                            <li><i class="fas fa-check-circle"></i> Cableado estructurado</li>
                            <li><i class="fas fa-check-circle"></i> Configuración de equipos de red</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico en Redes de Computadoras será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Diseñar e implementar redes LAN y WAN</li>
                            <li><i class="fas fa-arrow-right"></i> Administrar dispositivos de networking</li>
                            <li><i class="fas fa-arrow-right"></i> Implementar medidas de seguridad informática</li>
                            <li><i class="fas fa-arrow-right"></i> Gestionar servidores y servicios de red</li>
                            <li><i class="fas fa-arrow-right"></i> Realizar diagnóstico y solución de problemas</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones internacionales como CCNA, CompTIA Network+ y Microsoft Certified.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-user-tie"></i>
                            <h4>Técnico de Redes</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Analista de Seguridad</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-server"></i>
                            <h4>Administrador de Sistemas</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-headset"></i>
                            <h4>Soporte Técnico</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contabilidad y Finanzas -->
        <div class="specialty-content" id="contabilidad">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Contabilidad y Finanzas</h2>
                <p class="specialty-description">Formación especializada en procesos contables y financieros, desarrollando profesionales capaces de gestionar la información económica y tributaria de organizaciones.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Contabilidad general</li>
                            <li><i class="fas fa-check-circle"></i> Análisis financiero</li>
                            <li><i class="fas fa-check-circle"></i> Legislación tributaria</li>
                            <li><i class="fas fa-check-circle"></i> Gestión de costos</li>
                            <li><i class="fas fa-check-circle"></i> Sistemas contables computarizados</li>
                            <li><i class="fas fa-check-circle"></i> Presupuestos empresariales</li>
                            <li><i class="fas fa-check-circle"></i> Auditoría básica</li>
                            <li><i class="fas fa-check-circle"></i> Contabilidad administrativa</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico en Contabilidad y Finanzas será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Elaborar estados financieros</li>
                            <li><i class="fas fa-arrow-right"></i> Gestionar procesos tributarios</li>
                            <li><i class="fas fa-arrow-right"></i> Realizar análisis de costos</li>
                            <li><i class="fas fa-arrow-right"></i> Manejar software contable especializado</li>
                            <li><i class="fas fa-arrow-right"></i> Aplicar normativa contable vigente</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones como Técnico en Contabilidad por el Colegio de Contadores Privados de Costa Rica.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <h4>Asistente Contable</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-coins"></i>
                            <h4>Auxiliar Financiero</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-percentage"></i>
                            <h4>Asistente Tributario</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-chart-line"></i>
                            <h4>Analista de Costos</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Logística y Distribución -->
        <div class="specialty-content" id="logistica">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-truck"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Logística y Distribución</h2>
                <p class="specialty-description">Preparación integral en gestión de cadenas de suministro, almacenamiento y distribución para formar técnicos capaces de optimizar los procesos logísticos empresariales.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Fundamentos de logística</li>
                            <li><i class="fas fa-check-circle"></i> Gestión de inventarios</li>
                            <li><i class="fas fa-check-circle"></i> Transporte y distribución</li>
                            <li><i class="fas fa-check-circle"></i> Almacenamiento</li>
                            <li><i class="fas fa-check-circle"></i> Comercio internacional</li>
                            <li><i class="fas fa-check-circle"></i> Tecnologías aplicadas a logística</li>
                            <li><i class="fas fa-check-circle"></i> Servicio al cliente</li>
                            <li><i class="fas fa-check-circle"></i> Optimización de procesos</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico en Logística y Distribución será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Gestionar cadenas de suministro</li>
                            <li><i class="fas fa-arrow-right"></i> Optimizar procesos de almacenamiento</li>
                            <li><i class="fas fa-arrow-right"></i> Coordinar operaciones de transporte</li>
                            <li><i class="fas fa-arrow-right"></i> Implementar sistemas de control de inventarios</li>
                            <li><i class="fas fa-arrow-right"></i> Analizar costos logísticos</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones como Técnico en Logística y posibilidad de validación para estudios superiores.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-warehouse"></i>
                            <h4>Encargado de Almacén</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-shipping-fast"></i>
                            <h4>Coordinador de Distribución</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-boxes"></i>
                            <h4>Gestor de Inventarios</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-clipboard-check"></i>
                            <h4>Asistente de Operaciones</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Electrotecnia -->
        <div class="specialty-content" id="electrotecnia">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-bolt"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Electrotecnia</h2>
                <p class="specialty-description">Especialidad dedicada al estudio y aplicación de sistemas eléctricos, preparando técnicos capacitados para diseñar, instalar y mantener instalaciones eléctricas seguras y eficientes.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Electricidad básica</li>
                            <li><i class="fas fa-check-circle"></i> Instalaciones eléctricas</li>
                            <li><i class="fas fa-check-circle"></i> Electrónica aplicada</li>
                            <li><i class="fas fa-check-circle"></i> Máquinas eléctricas</li>
                            <li><i class="fas fa-check-circle"></i> Automatización industrial</li>
                            <li><i class="fas fa-check-circle"></i> Interpretación de planos</li>
                            <li><i class="fas fa-check-circle"></i> Sistemas de potencia</li>
                            <li><i class="fas fa-check-circle"></i> Normativa eléctrica</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico en Electrotecnia será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Diseñar instalaciones eléctricas</li>
                            <li><i class="fas fa-arrow-right"></i> Instalar circuitos residenciales e industriales</li>
                            <li><i class="fas fa-arrow-right"></i> Realizar mantenimiento de equipos eléctricos</li>
                            <li><i class="fas fa-arrow-right"></i> Implementar sistemas de automatización</li>
                            <li><i class="fas fa-arrow-right"></i> Aplicar normativas de seguridad eléctrica</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones del Colegio de Ingenieros Electricistas y del Código Eléctrico Nacional.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-plug"></i>
                            <h4>Electricista Residencial</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-industry"></i>
                            <h4>Técnico Industrial</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-tools"></i>
                            <h4>Mantenimiento Eléctrico</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-solar-panel"></i>
                            <h4>Instalador de Sistemas</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ejecutivo para Centros de Servicio -->
        <div class="specialty-content" id="ejecutivo">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Ejecutivo para Centros de Servicio</h2>
                <p class="specialty-description">Formación integral en gestión administrativa y atención al cliente, preparando técnicos capacitados para coordinar servicios y brindar atención de excelencia.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Servicio al cliente</li>
                            <li><i class="fas fa-check-circle"></i> Comunicación empresarial</li>
                            <li><i class="fas fa-check-circle"></i> Gestión documental</li>
                            <li><i class="fas fa-check-circle"></i> Administración de recursos</li>
                            <li><i class="fas fa-check-circle"></i> Herramientas informáticas</li>
                            <li><i class="fas fa-check-circle"></i> Relaciones públicas</li>
                            <li><i class="fas fa-check-circle"></i> Técnicas de negociación</li>
                            <li><i class="fas fa-check-circle"></i> Inglés técnico</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico Ejecutivo para Centros de Servicio será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Coordinar servicios administrativos</li>
                            <li><i class="fas fa-arrow-right"></i> Brindar atención al cliente de calidad</li>
                            <li><i class="fas fa-arrow-right"></i> Gestionar documentación empresarial</li>
                            <li><i class="fas fa-arrow-right"></i> Manejar herramientas tecnológicas de gestión</li>
                            <li><i class="fas fa-arrow-right"></i> Implementar mejoras en procesos de servicio</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones en Servicio al Cliente y posibilidad de validación para estudios superiores en Administración.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-user-tie"></i>
                            <h4>Ejecutivo de Servicio</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-headset"></i>
                            <h4>Coordinador de Atención</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-clipboard-list"></i>
                            <h4>Asistente Administrativo</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-users"></i>
                            <h4>Gestor de Clientes</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dibujo Técnico -->
        <div class="specialty-content" id="dibujo">
            <div class="specialty-header-img">
                <div class="specialty-icon">
                    <i class="fas fa-drafting-compass"></i>
                </div>
            </div>
            
            <div class="specialty-info">
                <h2>Dibujo Técnico</h2>
                <p class="specialty-description">Especialidad centrada en el desarrollo de habilidades de representación gráfica y diseño asistido por computadora para formar técnicos con capacidad de interpretar y crear planos técnicos.</p>
                
                <div class="info-columns">
                    <div class="column">
                        <h3>Plan de Estudios</h3>
                        <ul class="curriculum-list">
                            <li><i class="fas fa-check-circle"></i> Dibujo técnico manual</li>
                            <li><i class="fas fa-check-circle"></i> Diseño asistido por computadora (CAD)</li>
                            <li><i class="fas fa-check-circle"></i> Modelado 3D</li>
                            <li><i class="fas fa-check-circle"></i> Dibujo arquitectónico</li>
                            <li><i class="fas fa-check-circle"></i> Dibujo mecánico</li>
                            <li><i class="fas fa-check-circle"></i> Interpretación de planos</li>
                            <li><i class="fas fa-check-circle"></i> Renderización</li>
                            <li><i class="fas fa-check-circle"></i> Normativa técnica</li>
                        </ul>
                    </div>
                    
                    <div class="column">
                        <h3>Perfil Profesional</h3>
                        <p>El técnico en Dibujo Técnico será capaz de:</p>
                        <ul class="skills-list">
                            <li><i class="fas fa-arrow-right"></i> Elaborar planos arquitectónicos y mecánicos</li>
                            <li><i class="fas fa-arrow-right"></i> Manejar software especializado de diseño</li>
                            <li><i class="fas fa-arrow-right"></i> Crear modelos tridimensionales</li>
                            <li><i class="fas fa-arrow-right"></i> Interpretar planos técnicos</li>
                            <li><i class="fas fa-arrow-right"></i> Aplicar normativas de representación gráfica</li>
                        </ul>
                        
                        <div class="certification-box">
                            <h4><i class="fas fa-award"></i> Certificaciones</h4>
                            <p>Preparación para certificaciones en AutoCAD, SolidWorks y otras herramientas de diseño asistido por computadora.</p>
                        </div>
                    </div>
                </div>
                
                <div class="opportunities-section">
                    <h3>Oportunidades Laborales</h3>
                    <div class="job-opportunities">
                        <div class="job-card">
                            <i class="fas fa-building"></i>
                            <h4>Dibujante Arquitectónico</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-cogs"></i>
                            <h4>Dibujante Mecánico</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-cube"></i>
                            <h4>Modelador 3D</h4>
                        </div>
                        <div class="job-card">
                            <i class="fas fa-ruler-combined"></i>
                            <h4>Asistente de Diseño</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
 <!-- Sección de ventajas de estudiar en el CTP -->
<div class="section-separator">
    <i class="fas fa-medal"></i> Ventajas de nuestras especialidades
</div>

<section class="benefits-section features">
    <div class="container">
        <div class="benefits-grid">
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3>Certificación Oficial</h3>
                <p>Nuestros graduados reciben un título técnico medio reconocido por el MEP y valorado por empleadores a nivel nacional.</p>
            </div>
            
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3>Práctica Profesional</h3>
                <p>400 horas de práctica en empresas para que los estudiantes apliquen sus conocimientos en entornos laborales reales.</p>
            </div>
            
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Docentes Especializados</h3>
                <p>Contamos con profesores con experiencia laboral y formación específica en cada especialidad técnica.</p>
            </div>
            
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <h3>Tecnología Actualizada</h3>
                <p>Laboratorios equipados con tecnología moderna para un aprendizaje práctico y alineado con las demandas actuales.</p>
            </div>
            
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Convenios Empresariales</h3>
                <p>Alianzas con empresas locales y nacionales que facilitan la inserción laboral de nuestros graduados.</p>
            </div>
            
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Continuidad Académica</h3>
                <p>Posibilidad de continuar estudios superiores en universidades con reconocimiento de créditos académicos.</p>
            </div>
            
            <!-- Nuevo recuadro en la parte inferior derecha -->
            <div class="benefit-card feature-card">
                <div class="benefit-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3>Proyección Internacional</h3>
                <p>Oportunidades de intercambio y pasantías internacionales para ampliar horizontes profesionales y culturales.</p>
            </div>
        </div>
    </div>
</section>
            <!-- Estadísticas de empleabilidad -->
            <section class="stats-section">
                <div class="container">
                    <h2>Datos de Empleabilidad</h2>
                    <p>Nuestros graduados tienen un alto índice de inserción laboral gracias a la formación de calidad y los convenios empresariales</p>
                    
                    <div class="stats-container">
                        <div class="stat-card">
                            <div class="stat-number">88%</div>
                            <div class="stat-description">Empleabilidad en el primer año</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">65%</div>
                            <div class="stat-description">Continúan estudios superiores</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">75+</div>
                            <div class="stat-description">Empresas colaboradoras</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">12</div>
                            <div class="stat-description">Años de experiencia</div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Banner call to action -->
            <div class="cta-banner">
                <div class="container">
                    <h2>¿Listo para construir tu futuro profesional?</h2>
                    <p>Únete a nuestra comunidad educativa y prepárate para el mundo laboral con una formación técnica de calidad.</p>
                    <a href="{{ route('contact') }}" class="cta-button">
                        SOLICITA INFORMACIÓN
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Preguntas frecuentes -->
            <section class="faq-section">
                <div class="container">
                    <h2>Preguntas Frecuentes</h2>
                    
                    <div class="faq-container">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>¿Cuánto dura la formación técnica?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>La formación técnica tiene una duración de tres años, donde los dos primeros se centran en la formación académica y técnica, y el último año incluye la práctica profesional en empresas.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>¿Qué requisitos necesito para ingresar?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Para ingresar al CTP Roberto Gamboa Valverde se requiere haber completado el noveno año de educación básica y participar en el proceso de admisión que incluye pruebas de aptitud y entrevistas.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>¿Cómo se realiza la práctica profesional?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>La práctica profesional se realiza en el último año de formación, con una duración de 400 horas en empresas vinculadas a la especialidad. El estudiante es supervisado por un profesor tutor y un mentor de la empresa.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>¿Puedo continuar estudios universitarios después?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Sí, los graduados de nuestro colegio obtienen el título de Bachiller en Educación Media y el título de Técnico Medio, lo que les permite continuar estudios universitarios y muchas universidades reconocen créditos por la formación técnica recibida.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection

@push('scripts')
<script>
                // JavaScript para la interactividad de las pestañas de especialidades
                document.addEventListener('DOMContentLoaded', function() {
                    const tabItems = document.querySelectorAll('.specialty-tabs li');
                    const contentItems = document.querySelectorAll('.specialty-content');
                    
                    tabItems.forEach(tab => {
                        tab.addEventListener('click', function() {
                            // Remover clase active de todas las pestañas
                            tabItems.forEach(item => item.classList.remove('active'));
                            // Agregar clase active a la pestaña seleccionada
                            this.classList.add('active');
                            
                            // Ocultar todos los contenidos
                            contentItems.forEach(content => content.classList.remove('active'));
                            
                            // Mostrar el contenido correspondiente
                            const specialty = this.getAttribute('data-specialty');
                            document.getElementById(specialty).classList.add('active');
                        });
                    });
                    
                    // Para las FAQ
                    const faqItems = document.querySelectorAll('.faq-question');
                    
                    faqItems.forEach(item => {
                        item.addEventListener('click', function() {
                            const parent = this.parentElement;
                            parent.classList.toggle('active');
                        });
                    });
                });
            </script>
@endpush

