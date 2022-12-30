<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Coloca tu Nuevo Password</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <?php if ($token_valido) { ?>

    <form method="POST" class="formulario">
        <div class="formulario__campo">
            <label class="formulario__label">Nuevo Password</label>
                <input 
                type="password"
                class="formulario__input"
                placeholder="Tu Nuevo Password"
                id="email"
                for="passoword"
                name="password"
                >
        </div>
        
    <?php } ?>

    <input 
    type="submit" 
    class="formulario__submit"
    value="Guardar Password">
    </form>

    <div class="acciones">
        <a href="/olvide" class="acciones__enlace">Ya tienes cuenta? Iniciar Sesion</a> 
        <a href="/registro" class="acciones__enlace">Aun no tienes cuenta? Obtener una</a> 
        </div>
</main>