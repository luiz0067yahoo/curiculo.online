<?php 
    include "./adm/functions.php";
    date_default_timezone_set("America/Sao_Paulo");
    //ini_set('display_errors', 0);
    //ini_set('display_startup_errors', 0);
    $data_atual=date("Y-m-d");
    $hora_atual=date("h:i:s");
    $sql="SELECT count(c.url) as acessos,c.menu,c.submenu,c.categoria,c.titulo,c.url FROM contador_acesso_por_pagina c ";
    $sql.=" where (c.data_acesso between :data_inicio and :data_fim) ";
    $sql.=" group by c.url  order by count(c.url) desc";
    $params=array(
        'data_inicio'=>$data_atual,
        'data_fim'=>$data_atual
    );
    $result_contador=DAOquery($sql,$params);
    $contador_acesso_por_pagina=array();
    $campos_contador=array();
    if (isset($result_contador["title"])){$campos_contador=$result_contador["title"];}
    if (isset($result_contador["data"])){$contador_acesso_por_pagina=$result_contador["data"];}
?>
<h1>Relatorio de paginas mais acessadas por dia</h1>
<table>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $campos_contador[$i]; ?></th>
        <?php } ?>
    </tr>
    <?php for ($j = 0; $j<count($contador_acesso_por_pagina); $j++) { ?>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $contador_acesso_por_pagina[$j][$i]; ?></th>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
<?php
    $day = date('w');
    $week_start = date('m-d-Y', strtotime('-'.$day.' days'));
    $week_end = date('m-d-Y', strtotime('+'.(6-$day).' days'));
    $params=array(
        'data_inicio'=>$week_start,
        'data_fim'=>$week_end
    );
    $result_contador=DAOquery($sql,$params);
    if (isset($result_contador["data"])){$contador_acesso_por_pagina=$result_contador["data"];}
?>
<h1>Relatorio de paginas mais acessadas por semana</h1>
<table>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $campos_contador[$i]; ?></th>
        <?php } ?>
    </tr>
    <?php for ($j = 0; $j<count($contador_acesso_por_pagina); $j++) { ?>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $contador_acesso_por_pagina[$j][$i]; ?></th>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
<?php

    $P_Dia = date("Y-m-01");
    $U_Dia = date("Y-m-t");
    $params=array(
        'data_inicio'=>$P_Dia,
        'data_fim'=>$U_Dia
    );
    $result_contador=DAOquery($sql,$params);
    if (isset($result_contador["data"])){$contador_acesso_por_pagina=$result_contador["data"];}
?>
<h1>Relatorio de paginas mais acessadas por mês</h1>
<table>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $campos_contador[$i]; ?></th>
        <?php } ?>
    </tr>
    <?php for ($j = 0; $j<count($contador_acesso_por_pagina); $j++) { ?>
    <tr>
        <?php for ($i = 0; $i<count($campos_contador); $i++) { ?>
        <th><?php echo $contador_acesso_por_pagina[$j][$i]; ?></th>
        <?php } ?>
    </tr>
    <?php } ?>
</table>