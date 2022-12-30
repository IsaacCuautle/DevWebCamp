<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">

    <?php if (is_auth()) { ?>        
        <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__enlace">Administrar</a>
        <form class="header__form" method="POST" action="/logout">
            <input type="submit" value="Cerrar Sesion" class="header__submit">
        </form>
    
    <?php } else { ?>
        <h1 class="devweb"></h1>
        
                    <a href="/registro" class="header__enlace">Registro</a>
                    <a href="/login" class="header__enlace">Iniciar Sesion</a>
                    
    <?php } ?>
                    
        </nav>
    
    <div class="header__contenido">
        <a href="/">
            <h1 class="header__logo">
                &#60;DevWebCamp/>
            </h1>
            <p class="header__texto">
                Octubre 5-6 - 2023
                <p class="header__texto header__texto--modalidad">
                    En linea - Presencial
                </p>
            </p>

            <a href="/registro" class="header__boton">Comprar Pase</a>
        </a>
    </div>
   
</header>

<div class="barra">

<div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
            &#60;DevWebCamp/>
            </h2>
        </a>
        <div class="navegacion">
            <a href="/devwebcamp" class="navegacion__enlace <?php echo pagina_actual('/devwebcamp') ? 'navegacion__enlace--actual' : ''; ?>">Evento</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo pagina_actual('/paquetes') ? 'navegacion__enlace--actual' : ''; ?>">Paquetes</a>
            <a href="/workshops-conferencias" class="navegacion__enlace <?php echo pagina_actual('/workshops-conferencias') ? 'navegacion__enlace--actual' : ''; ?>">workshops - Conferencias</a>
            <a href="/registro" class="navegacion__enlace <?php echo pagina_actual('/registro') ? 'navegacion__enlace--actual' : ''; ?>">Comprar Pase</a>
        </div>
    </div>
</div>