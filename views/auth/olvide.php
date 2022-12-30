<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form method="POST" class="formulario" action="/olvide">
    <div class="formulario__campo">
        <label class="formulario__label">Email</label>
            <input 
            type="email"
            class="formulario__input"
            placeholder="Tu Email"
            id="email"
            for="email"
            name="email"
            >
    </div>

    <input 
    type="submit" 
    class="formulario__submit"
    value="Enviar Instruciones">
    </form>

    <div class="acciones">
        <a href="/olvide" class="acciones__enlace">Ya tienes cuenta? Iniciar Sesion</a> 
        <a href="/registro" class="acciones__enlace">Aun no tienes cuenta? Obtener una</a> 
        </div>
</main>