@extends('layouts.public')

@section('title', 'Junta Administrativa - CTP Roberto Gamboa Valverde')

@section('content')
<header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Junta Administrativa</h1>
            <p>Gestión transparente y eficiente para nuestro centro educativo</p>
        </div>
    </header>
    
    <div class="section-separator">
        Telefono: 22151100                Correo: junta.administrativa@ctprgv.ed.cr                Horario de atención: L-V 8:00 AM - 4:00 PM
    </div>
    
    <section class="admin-section">
        <h2 class="section-title centered">Infraestructura</h2>
        <div class="card-container">
            <div class="admin-card">
                <div class="card-header">
                    <i class="fas fa-tools fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Proyectos Actuales</h3>
                    <p class="card-text">Conoce los proyectos de mejora y mantenimiento que se están realizando actualmente en nuestro centro educativo.</p>
                    <ul class="infrastructure-list">
                        <li><i class="fas fa-hard-hat"></i>Renovación del laboratorio de cómputo</li>
                        <li><i class="fas fa-paint-roller"></i>Pintura de aulas y pasillos</li>
                        <li><i class="fas fa-wrench"></i>Mantenimiento de instalaciones deportivas</li>
                        <li><i class="fas fa-plug"></i>Actualización del sistema eléctrico</li>
                        <li><i class="fas fa-wifi"></i>Mejora de la red de internet</li>
                    </ul>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="card-header">
                    <i class="fas fa-clipboard-check fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Proyectos Completados</h3>
                    <p class="card-text">Estos son los proyectos que hemos finalizado recientemente para mejorar la experiencia educativa de nuestros estudiantes.</p>
                    <ul class="infrastructure-list">
                        <li><i class="fas fa-check-circle"></i>Instalación de sistema de cámaras de seguridad</li>
                        <li><i class="fas fa-check-circle"></i>Remodelación de los servicios sanitarios</li>
                        <li><i class="fas fa-check-circle"></i>Acondicionamiento del comedor estudiantil</li>
                        <li><i class="fas fa-check-circle"></i>Construcción de rampa de accesibilidad</li>
                        <li><i class="fas fa-check-circle"></i>Implementación de paneles solares</li>
                    </ul>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="card-header">
                    <i class="far fa-calendar-alt fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Proyectos Futuros</h3>
                    <p class="card-text">Proyectos planificados para el próximo año que contribuirán al desarrollo y mejora continua de nuestra institución.</p>
                    <ul class="infrastructure-list">
                        <li><i class="fas fa-lightbulb"></i>Creación de nuevos talleres técnicos</li>
                        <li><i class="fas fa-tree"></i>Áreas verdes y jardines educativos</li>
                        <li><i class="fas fa-solar-panel"></i>Expansión del sistema de energía solar</li>
                        <li><i class="fas fa-water"></i>Sistema de recolección de agua de lluvia</li>
                        <li><i class="fas fa-recycle"></i>Centro de reciclaje y compostaje</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <section class="admin-section" style="background-color: #f9f9f9;">
        <h2 class="section-title centered">Uniformes y Materiales</h2>
        <div class="card-container">
            <div class="admin-card">
                <div class="card-header">
                    <i class="fas fa-tshirt fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Uniformes Escolares</h3>
                    <p class="card-text">Disponemos de todos los elementos del uniforme escolar oficial con la mejor calidad y precios accesibles.</p>
                    <ul class="uniform-list">
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Camisas oficiales - <span class="price-tag">₡8,500</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Pantalones/Enaguas - <span class="price-tag">₡11,000</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Suéter institucional - <span class="price-tag">₡12,500</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Uniforme de educación física - <span class="price-tag">₡9,800</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Insignias y distintivos - <span class="price-tag">₡1,500</span></span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="card-header">
                    <i class="fas fa-book fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Cuadernos y Materiales</h3>
                    <p class="card-text">Ofrecemos cuadernos y materiales escolares con el logo institucional a precios accesibles para nuestros estudiantes.</p>
                    <ul class="uniform-list">
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Cuaderno universitario - <span class="price-tag">₡1,800</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Cuaderno de dibujo técnico - <span class="price-tag">₡2,200</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Agenda institucional - <span class="price-tag">₡3,500</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Paquete de útiles básicos - <span class="price-tag">₡5,000</span></span>
                        </li>
                        <li>
                            <i class="fas fa-tag"></i>
                            <span>Materiales específicos por especialidad - <span class="price-tag">Consultar</span></span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="card-header">
                    <i class="fas fa-info-circle fa-3x"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Información de Compra</h3>
                    <p class="card-text">Todo lo que necesitas saber para adquirir uniformes y materiales en nuestra institución.</p>
                    <ul class="uniform-list">
                        <li><i class="far fa-clock"></i>Horario de venta: Lunes a Viernes 8:00 AM - 2:00 PM</li>
                        <li><i class="fas fa-map-marker-alt"></i>Ubicación: Oficina administrativa (planta baja)</li>
                        <li><i class="far fa-credit-card"></i>Formas de pago: Efectivo, SINPE Móvil</li>
                        <li><i class="fas fa-phone"></i>Consultas: 2215-1100 ext. 107</li>
                        <li><i class="fas fa-percentage"></i>Programa de becas disponible para estudiantes de bajos recursos</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <section class="admin-section">
        <h2 class="section-title centered">Licitaciones</h2>
        <div class="card-body">
            <div class="tender-card">
                <div class="tender-header">
                    <h4>Licitación #CTPRGV-2025-003</h4>
                    <span class="tender-status">Abierta</span>
                </div>
                <div class="tender-body">
                    <h3 class="tender-title">Equipamiento de Laboratorio de Robótica</h3>
                    <div class="tender-info">
                        <i class="far fa-calendar-alt"></i>
                        <span>Fecha límite: 30 de Mayo, 2025</span>
                    </div>
                    <div class="tender-info">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Presupuesto estimado: ₡15.000.000</span>
                    </div>
                    <p class="tender-desc">
                        Se solicitan ofertas para la adquisición de equipos de robótica educativa incluyendo kits de robótica, 
                        componentes electrónicos, herramientas y mobiliario especializado para el nuevo laboratorio de robótica.
                    </p>
                    <a href="#" class="tender-btn">Ver detalles y requisitos</a>
                </div>
            </div>
            
            <div class="tender-card">
                <div class="tender-header">
                    <h4>Licitación #CTPRGV-2025-002</h4>
                    <span class="tender-status process">En proceso</span>
                </div>
                <div class="tender-body">
                    <h3 class="tender-title">Servicio de Mantenimiento de Zonas Verdes</h3>
                    <div class="tender-info">
                        <i class="far fa-calendar-alt"></i>
                        <span>Fecha límite: 15 de Abril, 2025</span>
                    </div>
                    <div class="tender-info">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Presupuesto estimado: ₡8.500.000 (anual)</span>
                    </div>
                    <p class="tender-desc">
                        Contratación de servicios para el mantenimiento de zonas verdes, jardines y áreas deportivas 
                        de la institución por un período de un año, con posibilidad de prórroga.
                    </p>
                    <a href="#" class="tender-btn">Ver estado actual</a>
                </div>
            </div>
            
            <div class="tender-card">
                <div class="tender-header">
                    <h4>Licitación #CTPRGV-2025-001</h4>
                    <span class="tender-status closed">Finalizada</span>
                </div>
                <div class="tender-body">
                    <h3 class="tender-title">Remodelación de Servicios Sanitarios</h3>
                    <div class="tender-info">
                        <i class="far fa-calendar-alt"></i>
                        <span>Fecha: 10 de Febrero, 2025</span>
                    </div>
                    <div class="tender-info">
                        <i class="fas fa-user-check"></i>
                        <span>Adjudicado a: Constructora Educativa S.A.</span>
                    </div>
                    <p class="tender-desc">
                        Proyecto de remodelación completa de los servicios sanitarios del pabellón oeste, 
                        incluyendo cambio de tuberías, instalación de nuevos sanitarios y lavamanos, 
                        y mejora en la accesibilidad.
                    </p>
                    <a href="#" class="tender-btn">Ver resultados</a>
                </div>
            </div>
        </div>
    </section>
@endsection

