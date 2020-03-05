<?php
echo '<center>';
echo '<form id="form_sql" name="form_sql" method="post" action="'.$_SERVER['PHP_SELF'].'">';
echo '<textarea id="comandosql" name="comandosql" required />';
echo '</textarea><br>';
echo '<input type="submit" class="btn" id="enviar" name="enviar" form="form_sql" value="Executar" />';
echo '</form>';
echo '</center>';
?>