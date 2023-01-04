<h2 class="pagina__heading"><?php echo $titulo; ?></h2>
<p class="pagina__descripcion">Elige hasta 5 evetnos para asistir de forma presencial.</p>
  
<div class="eventos-registro"> 
    <main class="eventos-registro__listado">
    <h3 class="eventos-registro__heading--conferencias">&lt;Conferencias /></h3>
        <p class="eventos-registro__fecha">Viernes 5 de Octubre</p>
        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_V'] as $evento) { ?>
                   <?php include __DIR__ . '/evento.php'; ?>
                <?php } ?>
        </div>
        <p class="eventos-registro__fecha">Sabado 6 de Octubre</p>
        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_S'] as $evento) { ?>
                   <?php include __DIR__ . '/evento.php'; ?>
                <?php } ?>
        </div>
    <h3 class="eventos-registro__heading--workshops">&lt;Workshops /></h3>
        <p class="eventos-registro__fecha">Viernes 5 de Octubre</p>
        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_V'] as $evento) { ?>
                   <?php include __DIR__ . '/evento.php'; ?>
                <?php } ?>
        </div>
        <p class="eventos-registro__fecha">Sabado 6 de Octubre</p>
        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_S'] as $evento) { ?>
                   <?php include __DIR__ . '/evento.php'; ?>
                <?php } ?>
        </div>
    </main>
    <aside class="registro">
        <h2 class="registro__heading">Tu Registro</h2>
        <div id="registro-resumen" class="registro__resumen"></div>
    </aside>
</div>