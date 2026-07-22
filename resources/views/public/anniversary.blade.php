@extends('layouts.public')

@section('title', '50 Aniversario - CTP Roberto Gamboa Valverde')

@section('content')
<header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>50 Aniversario</h1>
            <p>1975 - 2025</p>
        </div>
    </header>

    <section class="anniversary-intro">
        <div class="container">
            <h2>Medio siglo formando profesionales</h2>
            <p>En 1975, el Colegio Técnico Profesional Roberto Gamboa Valverde abrió sus puertas con la misión de formar técnicos que impulsaran el desarrollo de Costa Rica. Durante estos 50 años, nuestra institución ha sido testigo del crecimiento de San Rafael Abajo y ha contribuido significativamente a la formación de profesionales que hoy son parte fundamental del desarrollo del país.</p>
            <p>En esta sección conmemorativa, celebramos nuestra historia, logros y la comunidad educativa que ha hecho posible este recorrido de excelencia.</p>
        </div>
    </section>

    <section class="timeline-section">
        <div class="container">
            <h2>Nuestra Historia</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>1975</h3>
                        <p>Fundación del Colegio Técnico Profesional Roberto Gamboa Valverde, iniciando con las especialidades de Secretariado y Contabilidad.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>1985</h3>
                        <p>Expansión de la oferta educativa con la incorporación de nuevas especialidades técnicas para satisfacer las demandas del mercado laboral.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>1995</h3>
                        <p>Modernización de la infraestructura y equipamiento para mejorar la calidad educativa y el desarrollo de habilidades prácticas.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>2005</h3>
                        <p>Implementación de tecnologías de información en el proceso educativo y adaptación a las nuevas tendencias pedagógicas.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>2015</h3>
                        <p>Celebración del 40 aniversario con reconocimiento a exalumnos destacados y realización de proyectos comunitarios.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3>2025</h3>
                        <p>50 aniversario: Celebramos medio siglo de excelencia educativa, innovación y compromiso con nuestra comunidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimony-section">
        <div class="container">
            <h2>Testimonios de Nuestra Comunidad</h2>
            <div class="testimonies">
                <div class="testimony-card">
                    <div class="testimony-content">
                        <p>"Mi paso por el CTP Roberto Gamboa Valverde definió mi carrera profesional. Los conocimientos técnicos que adquirí me permitieron destacarme en mi campo laboral desde el primer día."</p>
                    </div>
                    <div class="testimony-author">
                        <h4>Carlos Jiménez</h4>
                        <p>Generación 1992 - Técnico en Contabilidad</p>
                    </div>
                </div>
                <div class="testimony-card">
                    <div class="testimony-content">
                        <p>"Como docente por más de 20 años, he visto la evolución constante de nuestra institución. El compromiso con la calidad educativa y el desarrollo integral de los estudiantes siempre ha sido nuestra prioridad."</p>
                    </div>
                    <div class="testimony-author">
                        <h4>María Fernanda Araya</h4>
                        <p>Profesora de Matemática desde 1998</p>
                    </div>
                </div>
                <div class="testimony-card">
                    <div class="testimony-content">
                        <p>"El colegio fue mi segunda casa. Aprendí no solo conocimientos técnicos sino valores que me acompañan hasta hoy. Estoy orgullosa de ser parte de la historia de esta gran institución."</p>
                    </div>
                    <div class="testimony-author">
                        <h4>Laura Méndez</h4>
                        <p>Generación 2005 - Técnica en Informática</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container">
            <h2>Galería Histórica</h2>
            <div class="gallery-filter">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="infraestructura">Infraestructura</button>
                <button class="filter-btn" data-filter="eventos">Eventos</button>
                <button class="filter-btn" data-filter="graduaciones">Graduaciones</button>
            </div>
            <div class="gallery-container">
                <div class="gallery-item" data-category="infraestructura">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Infraestructura antigua">
                        <div class="gallery-caption">Primeras instalaciones (1975)</div>
                    </div>
                </div>
                <div class="gallery-item" data-category="eventos">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Celebración de aniversario">
                        <div class="gallery-caption">Celebración 25 aniversario (2000)</div>
                    </div>
                </div>
                <div class="gallery-item" data-category="graduaciones">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Graduación antigua">
                        <div class="gallery-caption">Primera generación de graduados (1977)</div>
                    </div>
                </div>
                <div class="gallery-item" data-category="infraestructura">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Instalaciones modernas">
                        <div class="gallery-caption">Instalaciones actuales (2023)</div>
                    </div>
                </div>
                <div class="gallery-item" data-category="eventos">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Feria científica">
                        <div class="gallery-caption">Primera feria científica (1988)</div>
                    </div>
                </div>
                <div class="gallery-item" data-category="graduaciones">
                    <div class="gallery-placeholder">
                        <img src="/api/placeholder/400/300" alt="Graduación reciente">
                        <div class="gallery-caption">Promoción 2020</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="anniversary-videos">
        <div class="container">
            <h2>Videos Conmemorativos</h2>
            <div class="videos-container">
                <div class="video-item">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube.com/embed/01WulhAY6Ts?rel=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Historia del CTP Roberto Gamboa Valverde</h3>
                </div>
                <div class="video-item">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube.com/embed/01WulhAY6Ts?rel=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Testimonios de Exalumnos Destacados</h3>
                </div>
                <div class="video-item">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube.com/embed/01WulhAY6Ts?rel=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Mensaje del Director</h3>
                </div>
            </div>
        </div>
    </section>


    <section class="anniversary-events">
        <div class="container">
            <h2>Calendario de Eventos Conmemorativos</h2>
            <div class="events-container">
                <div class="event-card">
                    <div class="event-date">
                        <span class="month">Abril</span>
                        <span class="day">15</span>
                        <span class="year">2025</span>
                    </div>
                    <div class="event-info">
                        <h3>Inauguración de Celebraciones</h3>
                        <p>Acto oficial de apertura de las actividades conmemorativas del 50 aniversario con autoridades educativas y comunidad.</p>
                        <div class="event-details">
                            <span><i class="fas fa-clock"></i> 9:00 AM</span>
                            <span><i class="fas fa-map-marker-alt"></i> Gimnasio institucional</span>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="month">Mayo</span>
                        <span class="day">20</span>
                        <span class="year">2025</span>
                    </div>
                    <div class="event-info">
                        <h3>Feria de Logros</h3>
                        <p>Exposición de proyectos destacados de todas las especialidades técnicas a lo largo de estos 50 años.</p>
                        <div class="event-details">
                            <span><i class="fas fa-clock"></i> 8:00 AM - 4:00 PM</span>
                            <span><i class="fas fa-map-marker-alt"></i> Instalaciones del colegio</span>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="month">Junio</span>
                        <span class="day">10</span>
                        <span class="year">2025</span>
                    </div>
                    <div class="event-info">
                        <h3>Encuentro de Generaciones</h3>
                        <p>Reunión de exalumnos de todas las generaciones para compartir experiencias y fortalecer la red de egresados.</p>
                        <div class="event-details">
                            <span><i class="fas fa-clock"></i> 2:00 PM</span>
                            <span><i class="fas fa-map-marker-alt"></i> Salón de actos</span>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="month">Agosto</span>
                        <span class="day">25</span>
                        <span class="year">2025</span>
                    </div>
                    <div class="event-info">
                        <h3>Gala de Aniversario</h3>
                        <p>Cena de gala con reconocimientos a figuras destacadas en la historia del colegio y presentación del libro conmemorativo.</p>
                        <div class="event-details">
                            <span><i class="fas fa-clock"></i> 7:00 PM</span>
                            <span><i class="fas fa-map-marker-alt"></i> Hotel Radisson</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
        // Filtro para la galería
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Actualiza la clase activa
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filtra los elementos
                    const filter = this.getAttribute('data-filter');
                    galleryItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Prevenir envío del formulario (solo para demostración)
            const memoryForm = document.getElementById('memoryForm');
            if (memoryForm) {
                memoryForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Gracias por compartir tu recuerdo. Lo revisaremos y añadiremos a nuestra colección.');
                    this.reset();
                });
            }
        });
    </script>
@endpush

