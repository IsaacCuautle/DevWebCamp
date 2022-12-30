<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Registrate en DevWebCamp</p>

    <?php require_once __DIR__.'/../templates/alertas.php' ?>

    <form  method="POST" action="/registro" class="formulario">

    <div class="formulario__campo">
        <label class="formulario__label">Nombre</label>
            <input 
            type="text"
            class="formulario__input"
            placeholder="Tu nombre"
            id="nombre"
            for="nombre"
            name="nombre"
            value="<?php echo $usuario->nombre?>"
            >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label">Apellido</label>
            <input 
            type="text"
            class="formulario__input"
            placeholder="Tu Apellido"
            id="apellido"
            for="apellido"
            name="apellido"
            value="<?php echo $usuario->apellido?>"
            >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label">Email</label>
            <input 
            type="email"
            class="formulario__input"
            placeholder="Tu Email"
            id="email"
            for="email"
            name="email"
            value="<?php echo $usuario->email?>"
            >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label">Password</label>
            <input 
            type="password"
            class="formulario__input"
            placeholder="Tu password"
            id="password"
            for="password"
            name="password"
            >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label">Repetir Password</label>
            <input 
            type="password"
            class="formulario__input"
            placeholder="Repetir tu password"
            id="password2"
            for="password2"
            name="password2"
            >
    </div>

    <input 
    type="submit" 
    class="formulario__submit"
    value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Ya tienes cuenta? Inciar Sesion</a> 
        <a href="/olvide" class="acciones__enlace">Olvidaste tu password?</a> 
        </div>
</main>