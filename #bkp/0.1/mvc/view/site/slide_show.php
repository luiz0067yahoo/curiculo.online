<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


    $indexIdMenu=0;
    $params=null;
    $sql="  select ";
    $sql.=" noticias.foto_principal, ";
    $sql.=" noticias.titulo, ";
    $sql.=" IF(filho.id_menu is null, concat(filho.nome,'/',noticias.titulo), concat(pai.nome,'/',filho.nome,'/',noticias.titulo)) as url,";
    $sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal";
    $sql.=" from noticias ";
    $sql.=" left join menus filho on(filho.id=noticias.id_menu) ";
    $sql.=" left join menus pai  on (pai.id=filho.id_menu) "; 
    $sql.=" where ";
    $sql.=" (noticias.slide_show) ";
    $sql.=" and(";
    $sql.="  ((:ler_menu='')and(:ler_sub_menu=''))";//home
    $sql.="  or ";
    $sql.="  (((filho.nome=:ler_menu)or(pai.nome=:ler_menu))and(:ler_sub_menu=''))";//menu
    
    $sql.="  or ";
    $sql.="  ((pai.nome=:ler_menu)and(filho.nome=:ler_sub_menu))";//sub menu
    
    $sql.="  )";
    $sql.=" order by noticias.id desc";
    $sql.=" limit 0 , 6";
    $params=array("ler_menu"=>$ler_menu,"ler_sub_menu"=>$ler_sub_menu);
	$result_slide_show=DAOquery($sql,$params,true,"");
?>
<div id="carouselExampleIndicators" class="carousel slide block-row-2" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php for($i=0;$i<count($result_slide_show["data"]);$i++){ ?>
    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo "active" ?>"></li>
    <?php } ?>
  </ol>
  <div class="carousel-inner">
    <?php for($i=0;$i<count($result_slide_show["data"]);$i++){ 
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result_slide_show,"foto_principal",$i);}catch(Exception $e){}
        $titulo=resultDataFieldByTitle($result_slide_show,"titulo",$i);
        $url=resultDataFieldByTitle($result_slide_show,"url",$i);
        $menu_principal=resultDataFieldByTitle($result_slide_show,"menu_principal",$i);

        for ($menu_index_slide_show = 1; $menu_index_slide_show <= count($menus); $menu_index_slide_show++){
            if($menus[$menu_index_slide_show-1][1]==$menu_principal)
                break;
        }
    ?>
    <div class="carousel-item <?php if($i==0) echo "active" ?> block-row-2 bg-menu-<?php echo $menu_index_slide_show; ?>">
      <div 
      style=" 
  width:100%;
  height:180px;
  background: url(<?php echo $base_url;?>/uploads/noticias/320x240/<?php echo $foto_principal;?>) no-repeat center  ; 
  "></div>
  
    <p class="w-100 text-center mt-1" ><a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" class="link-color-<?php echo $menu_index_slide_show; ?>">  <?php echo $titulo;?>  </a></p>
    </div>
    <?php } ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>