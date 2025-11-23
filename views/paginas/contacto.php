<main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php if ($mensaje) { ?>
        <p class="alerta exito"><?php echo $mensaje; ?></p>
    <?php } ?>

    <picture>
        <source srcset="<?php echo RUTA_PUBLIC; ?>/build/img/destacada3.webp" type="image/webp">
        <source srcset="<?php echo RUTA_PUBLIC; ?>/build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="<?php echo RUTA_PUBLIC; ?>/build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulario de Contacto</h2>

    <form class="formulario" method="POST" action="/SobreCasa-mvc/public/contacto">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]">


            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="contacto[mensaje]"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información sobre la Propiedad</legend>

            <label for="opciones">Vende o Compra:</label>
            <select id="opciones" name="contacto[opciones]">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[presupuesto]">

        </fieldset>

        <fieldset>
            <legend>Información de Contacto</legend>

            <p>Como desea ser contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input name="contacto[contacto]" type="radio" value="telefono" id="contactar-telefono" >

                <label for="contactar-email">Gmail</label>
                <input name="contacto[contacto]" type="radio" value="email" id="contactar-email" >
            </div>

            <p>Si eliges telefono, elige fecha y hora</p>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00"  max="21:00" name="contacto[hora]">
            </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>