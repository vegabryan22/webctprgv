@extends('layouts.public')

@section('title', 'Noticias - CTP Roberto Gamboa Valverde')

@section('content')
<header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Noticias y Eventos</h1>
            <p>Mantente al día con todas las actividades de nuestra institución</p>
        </div>
    </header>
    
    <div class="main-content">
      
        <section class="events-section">
            <h2 class="section-title centered">Eventos Destacados</h2>
            
            <div class="events-container">
                <div class="event-card">
                    <div class="event-date">
                        <span class="event-day">15</span>
                        <span class="event-month">ABR</span>
                    </div>
                    <div class="event-details">
                        <h3>Feria Científica</h3>
                        <p class="event-time"><i class="far fa-clock"></i> 9:00 AM - 3:00 PM</p>
                        <p class="event-location"><i class="fas fa-map-marker-alt"></i> Gimnasio Principal</p>
                        <p class="event-description">Exhibición de proyectos científicos y tecnológicos desarrollados por estudiantes de todas las especialidades.</p>
                        <a href="#" class="event-link">Más información <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="event-card">
                    <div class="event-date">
                        <span class="event-day">23</span>
                        <span class="event-month">MAY</span>
                    </div>
                    <div class="event-details">
                        <h3>Festival Cultural</h3>
                        <p class="event-time"><i class="far fa-clock"></i> 10:00 AM - 4:00 PM</p>
                        <p class="event-location"><i class="fas fa-map-marker-alt"></i> Cancha de Deportes</p>
                        <p class="event-description">Celebración de nuestra diversidad cultural con presentaciones artísticas, música, bailes tradicionales y gastronomía.</p>
                        <a href="#" class="event-link">Más información <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="event-card">
                    <div class="event-date">
                        <span class="event-day">10</span>
                        <span class="event-month">JUN</span>
                    </div>
                    <div class="event-details">
                        <h3>Feria de Emprendimiento</h3>
                        <p class="event-time"><i class="far fa-clock"></i> 1:00 PM - 6:00 PM</p>
                        <p class="event-location"><i class="fas fa-map-marker-alt"></i> Auditorio</p>
                        <p class="event-description">Exposición de proyectos empresariales y emprendimientos desarrollados por nuestros estudiantes de último año.</p>
                        <a href="#" class="event-link">Más información <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
        
     
        <section class="calendar-section">
            <h2 class="section-title centered">Calendario de Actividades <span id="current-year">2025</span></h2>
            
            <div class="calendar-container">
                <div class="calendar-navigation">
                    <button id="prev-month" class="calendar-nav-btn"><i class="fas fa-chevron-left"></i></button>
                    <h3 id="current-month">Enero 2025</h3>
                    <button id="next-month" class="calendar-nav-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                
                <div class="calendar">
                    <div class="calendar-header">
                        <div>Dom</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mié</div>
                        <div>Jue</div>
                        <div>Vie</div>
                        <div>Sáb</div>
                    </div>
                    <div id="calendar-days" class="calendar-days">
                     
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function() {
           
            let currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            
         
            document.getElementById('current-year').textContent = currentYear;
            
          
            renderCalendar(currentDate.getMonth(), currentYear);
            
          
            document.getElementById('prev-month').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate.getMonth(), currentDate.getFullYear());
            });
            
            document.getElementById('next-month').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate.getMonth(), currentDate.getFullYear());
            });
            
           
            function renderCalendar(month, year) {
                const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
                                   "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                
                document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
                
                const calendarDays = document.getElementById('calendar-days');
                calendarDays.innerHTML = '';
                
               
                const firstDay = new Date(year, month, 1);
                
                const lastDay = new Date(year, month + 1, 0);
                
                
                for (let i = 0; i < firstDay.getDay(); i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.classList.add('calendar-day', 'empty');
                    calendarDays.appendChild(emptyDay);
                }
                
                
                for (let i = 1; i <= lastDay.getDate(); i++) {
                    const day = document.createElement('div');
                    day.classList.add('calendar-day');
                    day.textContent = i;
                    
                  
                    const today = new Date();
                    if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        day.classList.add('today');
                    }
                    if ((month === 3 && i === 15) || 
                        (month === 4 && i === 23) || 
                        (month === 5 && i === 10)) {
                        day.classList.add('has-event');
                    }
                    
                    day.addEventListener('click', function() {
                        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                        this.classList.add('selected');
                    });
                    
                    calendarDays.appendChild(day);
                }
            }
        });
    </script>
@endpush

