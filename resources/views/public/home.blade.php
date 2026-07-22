@extends('layouts.public')

@section('title', 'CTP Roberto Gamboa Valverde')

@section('content')
<header class="hero" id="inicio">
        <div class="hero-overlay">
            <h1 class="animated-welcome">Bienvenidos</h1>
        </div>
    </header>
    <div class="section-separator">
        Telefono:                       Correo:                             Horario de atencion:
    </div>
    <section class="features" id="servicios"></section>
    <section class="features" id="servicios">
        <div class="feature-card">
            <i class="fas fa-users"></i>
            <h3>Misión</h3>
            <p>El Colegio Técnico Profesional Roberto Gamboa Valverde (CTPRGV) es una institución educativa, pública, diurna, técnica, que brinda sus servicios educativos para tercer ciclo y educación diversificada, cuya misión es brindar a su personal espacios de reforzamiento, capacitación e integración, por medio de los cuales se motive para el desempeño de su trabajo, propiciando un ambiente que favorezca el desarrollo integral de la comunidad educativa, donde se transmita y fomente valores y conocimientos que faciliten a los estudiantes el desarrollo de sus potencialidades para su inserción en el ámbito laboral.
            </p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('images/escudo.png') }}" alt="Logo 50 Aniversario" class="feature-icon">
            <h3>50 Aniversario</h3>
            <p>Celebramos cinco décadas formando profesionales que transforman nuestra sociedad. Acompáñanos en este recorrido histórico y comparte tus memorias con nuestra comunidad educativa.</p>
            <a href="{{ route('anniversary') }}" class="btn-anniversary">Explorar 50 Aniversario</a>
        </div>
        <div class="feature-card">
            <i class="fas fa-chalkboard-teacher"></i>
            <h3>Visión</h3>
            <p>Ser una institución pública, diurna y técnica de tercer ciclo y educación diversificada que cuente con diversos servicios y personal calificado para facilitar un proceso educativo de calidad, además que brinde a las personas estudiantes de San Rafael Abajo, independientemente de su credo religioso, etnia o nacionalidad, una formación integral que no solo le permita concluir la Educación Secundaria, y por ende obtener su Bachillerato y Técnico Medio en una Especialidad, sino también facilite la construcción de su proyecto de vida, el cual le permita mejorar su nivel social, cultural, técnico, académico y económico.</p>
        </div>
    </section>
    
    <section class="values-section">
        <h2 class="section-title">Nuestros Valores</h2>
        <div class="values-container">
            <div class="value-card">
                <i class="fas fa-heart"></i>
                <h3>Amor</h3>
                <span class="value-tooltip">El amor como valor institucional nos impulsa a tratar a cada persona con calidez, empatía y bondad genuina.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-handshake"></i>
                <h3>Compromiso</h3>
                <span class="value-tooltip">Asumimos con responsabilidad y determinación nuestras obligaciones educativas y sociales para el bienestar de la comunidad estudiantil.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-comments"></i>
                <h3>Diálogo</h3>
                <span class="value-tooltip">Fomentamos la comunicación abierta y respetuosa para resolver conflictos y construir entendimiento mutuo.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-hands-helping"></i>
                <h3>Empatía</h3>
                <span class="value-tooltip">Nos esforzamos por comprender las perspectivas, sentimientos y necesidades de los demás para crear un ambiente inclusivo.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-tasks"></i>
                <h3>Esfuerzo</h3>
                <span class="value-tooltip">Valoramos la dedicación y perseverancia en el trabajo académico y personal como camino hacia la excelencia.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-dove"></i>
                <h3>Paz</h3>
                <span class="value-tooltip">Promovemos un ambiente de armonía, tranquilidad y resolución pacífica de conflictos en toda nuestra comunidad.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-user-shield"></i>
                <h3>Respeto</h3>
                <span class="value-tooltip">Reconocemos la dignidad inherente de cada persona y tratamos a todos con consideración y cortesía.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-clipboard-check"></i>
                <h3>Responsabilidad</h3>
                <span class="value-tooltip">Cumplimos con nuestros compromisos y asumimos las consecuencias de nuestras acciones con integridad.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-hands"></i>
                <h3>Solidaridad</h3>
                <span class="value-tooltip">Trabajamos juntos para apoyarnos mutuamente, especialmente en momentos de necesidad o dificultad.</span>
            </div>
            <div class="value-card">
                <i class="fas fa-glasses"></i>
                <h3>Transparencia</h3>
                <span class="value-tooltip">Actuamos con honestidad y claridad en todos nuestros procesos, decisiones y comunicaciones.</span>
            </div>
        </div>
    </section>
    
    <section class="video-section">
        <h2 class="section-title">Conócenos Mejor</h2>
        <div class="video-container">
            <div class="video-placeholder">
                <iframe src="https://www.youtube.com/embed/01WulhAY6Ts?rel=0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
@endsection

