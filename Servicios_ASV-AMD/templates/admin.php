<?php
    //Librerias
    include("../libs/bComponentes.php");
    //Encabezado
    $titulo = "Admin Page";
    $css="../css/admin.css";
    include("pl_encabezado.php");
?>
  <form action="" id='formLogOut'>
    <input type="submit" name="bLogOut" id="bLogOut" value="&#60; Log Out">
  </form>
  <header>Admin Page</header>
  <main>
    <div class="idiomas">
      <div class="textoLista">
        <h2>Idiomas</h2>
        <div class="listaIdiomas">
        <?= pintaLista($pdo, 'idioma', 'idioma', $errores); ?></div>
      </div>
      <form action="" id='formIdiomas'>
        <label for="insertaIdioma">Insertar</label>
        <input type="text" name='insertaIdioma' id='insertaIdioma' size='10'>
        <label for="idioma">Eliminar</label>
        <?=pintaDesplegableBD($pdo, 'idioma', $errores); ?>
        <input type="submit" value="Enviar" name='bEnviarIdioma'>
      </form>
    </div>
    <div class="disponibilidad">
      <div class="textoLista">
        <h2>Disponibilidad</h2>
        <div class="listaDisponibilidad">
        <?= pintaLista($pdo, 'disponibilidad', 'disponibilidad', $errores); ?></div>
      </div>
    <form action="" id='formDisponibilidad'>
      <label for="insertaDisponibilidad">Insertar</label>
      <input type="text" name='insertaDisponibilidad' id='insertaDisponibilidad' size='10'>
      <label for="disponibilidad">Eliminar</label>
      <?=pintaDesplegableBD($pdo, 'disponibilidad', $errores); ?>
        <input type="submit" value="Enviar" name='bEnviarDisponibilidad'>
    </form>
    </div>
  </main>
<?
  //Pie
  include("../templates/pl_pie.html");
  //Cerrar conexion
  stopBd($pdo, $errores);
?>