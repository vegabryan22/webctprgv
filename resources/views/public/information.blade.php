@extends('layouts.public')

@section('title', 'Nuestra institución - CTP Roberto Gamboa Valverde')

@section('content')
<header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Información Institucional</h1>
            <p>Descubre todo lo que necesitas saber sobre la institución</p>
        </div>
    </header>
    
    <section class="features">
        <div class="feature-card">
            <i class="fas fa-graduation-cap"></i>
            <h3>Información Académica</h3>
            <p>Nuestro colegio ofrece educación técnica de alta calidad para estudiantes de tercer ciclo y educación diversificada. Contamos con programas educativos integrales que preparan a los estudiantes para su futuro profesional y académico.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Ubicación</h3>
            <p>Estamos ubicados en San Rafael Abajo, brindando servicios educativos a la comunidad local. Nuestra institución está comprometida con el desarrollo integral de los estudiantes de la zona, sin importar su origen o condición.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-clock"></i>
            <h3>Horarios</h3>
            <p>Funcionamos en horario diurno, con jornadas que permiten a los estudiantes recibir una educación completa y de calidad. Nuestros horarios están diseñados para maximizar el aprendizaje y el desarrollo de habilidades técnicas.</p>
        </div>
    </section>
    
    <section class="features">
        <div class="feature-card">
            <i class="fas fa-book"></i>
            <h3>Requisitos de Admisión</h3>
            <p>Para ingresar a nuestro colegio, los estudiantes deben cumplir con los requisitos académicos establecidos por el Ministerio de Educación. Ofrecemos igualdad de oportunidades para todos los estudiantes interesados en desarrollar sus habilidades técnicas.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-university"></i>
            <h3>Certificaciones</h3>
            <p>Al concluir sus estudios, los estudiantes obtienen su Bachillerato y un Título Técnico en la especialidad que hayan elegido. Nuestras certificaciones son reconocidas a nivel nacional y preparadas para el mercado laboral actual.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-users"></i>
            <h3>Comunidad Educativa</h3>
            <p>Formamos parte de una comunidad comprometida con la educación, donde estudiantes, docentes, administrativos y padres de familia trabajan juntos para alcanzar metas académicas y de desarrollo personal.</p>
        </div>
    </section>
    
    <section class="values-section">
        <h2 class="section-title">Nuestros Compromisos</h2>
        <div class="values-container">
            <div class="value-card"><i class="fas fa-chart-line"></i><h3>Excelencia</h3></div>
            <div class="value-card"><i class="fas fa-laptop-code"></i><h3>Innovación</h3></div>
            <div class="value-card"><i class="fas fa-hands-helping"></i><h3>Apoyo</h3></div>
            <div class="value-card"><i class="fas fa-globe"></i><h3>Inclusión</h3></div>
            <div class="value-card"><i class="fas fa-brain"></i><h3>Desarrollo</h3></div>
            <div class="value-card"><i class="fas fa-graduation-cap"></i><h3>Formación</h3></div>
            <div class="value-card"><i class="fas fa-laptop"></i><h3>Tecnología</h3></div>
            <div class="value-card"><i class="fas fa-book-open"></i><h3>Aprendizaje</h3></div>
        </div>
    </section>
    
    <section class="location-section">
        <h2 class="section-title centered">Nuestra Ubicación</h2>
        <div class="location-container">
            <div class="location-info">
                <i class="fas fa-map-marker-alt"></i>
                <h3>CTP Roberto Gamboa Valverde</h3>
                <p>San Rafael Abajo, San jose, Costa Rica</p>
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.408689251464!2d-84.10625112505874!3d9.758243589707988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e1b4a8441e4d%3A0x8d11420da4019dcb!2sCTP%20Roberto%20Gamboa%20Valverde!5e0!3m2!1ses!2scr!4v1711477235495!5m2!1ses!2scr" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
@endsection
