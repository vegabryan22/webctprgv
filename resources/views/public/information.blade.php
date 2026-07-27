@extends('layouts.public')

@section('title', 'Nuestra institución - CTP Roberto Gamboa Valverde')

@section('content')
<main class="institution-page">
    <header class="institution-hero">
        <div class="institution-hero__image" aria-hidden="true"></div>
        <div class="institution-hero__overlay"></div>
        <div class="institution-hero__content">
            <span>Identidad institucional</span>
            <h1>Nuestra institución</h1>
            <p>Conozca los principios que orientan la formación académica y técnica del CTP Roberto Gamboa Valverde.</p>
        </div>
        <img class="institution-hero__crest" src="/images/escudo.png" alt="">
    </header>

    <section class="institution-intro">
        <div class="institution-shell">
            <div class="institution-intro__copy">
                <span class="institution-eyebrow">Quiénes somos</span>
                <h2>Educación técnica para el desarrollo integral</h2>
                <p>El CTP Roberto Gamboa Valverde es una institución educativa pública, diurna y técnica que brinda servicios de tercer ciclo y educación diversificada.</p>
            </div>
            <div class="institution-facts" aria-label="Características institucionales">
                <span><i class="fas fa-building-columns"></i> Institución pública</span>
                <span><i class="fas fa-sun"></i> Modalidad diurna</span>
                <span><i class="fas fa-screwdriver-wrench"></i> Educación técnica</span>
                <span><i class="fas fa-user-graduate"></i> Tercer ciclo y diversificada</span>
            </div>
        </div>
    </section>

    <section class="institution-purpose">
        <div class="institution-shell institution-purpose__grid">
            <article>
                <div class="institution-purpose__icon"><i class="fas fa-bullseye"></i></div>
                <span class="institution-eyebrow">Nuestro propósito</span>
                <h2>Misión</h2>
                <p>El Colegio Técnico Profesional Roberto Gamboa Valverde (CTPRGV) es una institución educativa, pública, diurna, técnica, que brinda sus servicios educativos para tercer ciclo y educación diversificada, cuya misión es brindar a su personal espacios de reforzamiento, capacitación e integración, por medio de los cuales se motive para el desempeño de su trabajo, propiciando un ambiente que favorezca el desarrollo integral de la comunidad educativa, donde se transmita y fomente valores y conocimientos que faciliten a los estudiantes el desarrollo de sus potencialidades para su inserción en el ámbito laboral.</p>
            </article>
            <article>
                <div class="institution-purpose__icon"><i class="fas fa-eye"></i></div>
                <span class="institution-eyebrow">Hacia dónde avanzamos</span>
                <h2>Visión</h2>
                <p>Ser una institución pública, diurna y técnica de tercer ciclo y educación diversificada que cuente con diversos servicios y personal calificado para facilitar un proceso educativo de calidad, además que brinde a las personas estudiantes de San Rafael Abajo, independientemente de su credo religioso, etnia o nacionalidad, una formación integral que no solo le permita concluir la Educación Secundaria, y por ende obtener su Bachillerato y Técnico Medio en una Especialidad, sino también facilite la construcción de su proyecto de vida, el cual le permita mejorar su nivel social, cultural, técnico, académico y económico.</p>
            </article>
        </div>
    </section>

    <section class="institution-values">
        <div class="institution-shell">
            <header>
                <span class="institution-eyebrow">Principios que nos orientan</span>
                <h2>Valores institucionales</h2>
                <p>Estos valores acompañan la convivencia y el trabajo de nuestra comunidad educativa.</p>
            </header>
            <div class="institution-values__grid">
                <span><i class="fas fa-heart"></i> Amor</span>
                <span><i class="fas fa-handshake"></i> Compromiso</span>
                <span><i class="fas fa-comments"></i> Diálogo</span>
                <span><i class="fas fa-hands-holding-circle"></i> Empatía</span>
                <span><i class="fas fa-person-running"></i> Esfuerzo</span>
                <span><i class="fas fa-dove"></i> Paz</span>
                <span><i class="fas fa-user-shield"></i> Respeto</span>
                <span><i class="fas fa-clipboard-check"></i> Responsabilidad</span>
                <span><i class="fas fa-hands-helping"></i> Solidaridad</span>
                <span><i class="fas fa-glasses"></i> Transparencia</span>
            </div>
        </div>
    </section>

    <section class="institution-explore">
        <div class="institution-shell">
            <header><span class="institution-eyebrow">Continúe explorando</span><h2>Información relacionada</h2></header>
            <div class="institution-explore__grid">
                <a href="/servicios"><i class="fas fa-hand-holding-heart"></i><span><strong>Servicios</strong><small>Trámites, apoyos y atención institucional</small></span><i class="fas fa-arrow-right"></i></a>
                <a href="/junta-administrativa"><i class="fas fa-people-group"></i><span><strong>Junta Administrativa</strong><small>Gestión y transparencia institucional</small></span><i class="fas fa-arrow-right"></i></a>
                <a href="/contacto"><i class="fas fa-address-book"></i><span><strong>Contacto</strong><small>Ubicación y medios de atención</small></span><i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
</main>
@endsection
