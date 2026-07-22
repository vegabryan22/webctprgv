@extends('layouts.public')

@section('title', 'Contacto - CTP Roberto Gamboa Valverde')

@section('content')
<header class="specialty-header">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Contacto</h1>
            <p>Mantente en contacto con nosotros</p>
        </div>
    </header>
    <!-- Sección de información de contacto con estilo inline -->
    <div style="background: #f9f9f9; height: 50px; width: 100%; margin-bottom: 0; box-shadow: 0 2px 10px rgba(0,0,0,0.2); display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 1.725rem;">
        Información de Contacto
    </div>

    <!-- Sistema de tarjetas de contacto con animación -->
    <section class="features" style="background-color: #f9f9f9;">
       
        <div class="feature-card">
            <i class="fas fa-phone"></i>
            <h3>Teléfonos</h3>
            <p>Número principal: 2250-8555</p>
            <p>Dirección: 2250-8547</p>
            <div class="event-link" style="margin-top: 15px;">
                <a href="tel:22508555" style="text-decoration: none; color: #4cb11d;">
                    Llamar ahora <i class="fas fa-phone-alt"></i>
                </a>
            </div>
        </div>

        <div class="feature-card">
            <i class="fas fa-envelope"></i>
            <h3>Correo Electrónico</h3>
            <p>ctp.robertogamboa@mep.go.cr</p>
            <p>Para consultas y más información</p>
            <div class="event-link" style="margin-top: 15px;">
                <a href="mailto:ctp.robertogamboa@mep.go.cr" style="text-decoration: none; color: #4cb11d;">
                    Enviar correo <i class="fas fa-paper-plane"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de formulario de contacto con estilo inline -->
    <div style="background: #f9f9f9; height: 50px; width: 100%; margin-bottom: 0; box-shadow: 0 2px 10px rgba(0,0,0,0.2); display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 1.725rem;">
        Formulario de Contacto
    </div>

    <!-- Formulario de contacto estilizado -->
    <section style="background-color: #f9f9f9; padding: 4rem 5%;">
        <div style="max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="color: #002f5d; text-align: center; margin-bottom: 30px;">Envíanos un mensaje</h2>

            <form style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="grid-column: span 1;">
                    <label for="nombre" style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Nombre</label>
                    <input type="text" id="nombre" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; transition: border-color 0.3s;" placeholder="Su nombre completo">
                </div>

                <div style="grid-column: span 1;">
                    <label for="email" style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Correo electrónico</label>
                    <input type="email" id="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; transition: border-color 0.3s;" placeholder="Su correo electrónico">
                </div>

                <div style="grid-column: span 2;">
                    <label for="asunto" style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Asunto</label>
                    <input type="text" id="asunto" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; transition: border-color 0.3s;" placeholder="Asunto de su mensaje">
                </div>

                <div style="grid-column: span 2;">
                    <label for="mensaje" style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Mensaje</label>
                    <textarea id="mensaje" rows="5" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; transition: border-color 0.3s; resize: vertical;" placeholder="Escriba su mensaje aquí..."></textarea>
                </div>

                <div style="grid-column: span 2; text-align: center; margin-top: 10px;">
                    <button type="submit" style="background: #002f5d; color: white; border: none; padding: 14px 30px; border-radius: 5px; cursor: pointer; font-weight: 600; transition: all 0.3s; position: relative; overflow: hidden;">
                        <span style="position: relative; z-index: 2;">Enviar mensaje</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Sección de valores/servicios adicionales con estilo inline -->
    <div style="background: #f9f9f9; height: 50px; width: 100%; margin-bottom: 0; box-shadow: 0 2px 10px rgba(0,0,0,0.2); display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 1.725rem;">
        Nuestros Servicios
    </div>

    <section class="values-section">
        <div class="values-container">
            <div class="value-card">
                <i class="fas fa-user-graduate"></i>
                <h3>Matrícula</h3>
                <div class="value-tooltip">Proceso de matrícula para nuevos estudiantes y reingresos durante los períodos establecidos.</div>
            </div>
            <div class="value-card">
                <i class="fas fa-certificate"></i>
                <h3>Certificaciones</h3>
                <div class="value-tooltip">Emisión de certificados de estudio, títulos y constancias para estudiantes actuales y egresados.</div>
            </div>
            <div class="value-card">
                <i class="fas fa-hands-helping"></i>
                <h3>Orientación</h3>
                <div class="value-tooltip">Servicios de orientación vocacional y apoyo psicoeducativo para estudiantes.</div>
            </div>
            <div class="value-card">
                <i class="fas fa-book-reader"></i>
                <h3>Biblioteca</h3>
                <div class="value-tooltip">Acceso a recursos bibliográficos y digitales para la comunidad estudiantil.</div>
            </div>
            <div class="value-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Tutorías</h3>
                <div class="value-tooltip">Programas de apoyo académico y tutorías para estudiantes que requieren refuerzo.</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
        // Animación para que los elementos aparezcan al hacer scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card, .event-card, .value-card');

            function checkScroll() {
                cards.forEach(card => {
                    const cardTop = card.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (cardTop < windowHeight * 0.9) {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }
                });
            }

            // Establecer estilos iniciales
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            });

            // Verificar posición al cargar
            checkScroll();

            // Verificar posición al hacer scroll
            window.addEventListener('scroll', checkScroll);
        });
    </script>
@endpush

