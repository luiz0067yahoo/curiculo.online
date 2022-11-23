<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$indexIdMenu=0;

$sql="  select ";
$sql.=" noticias.foto_principal, ";
$sql.=" noticias.titulo, ";
$sql.=" noticias.subtitulo, ";
$sql.=" concat(CAST(noticias.conteudo_noticia AS CHAR(20) CHARACTER SET utf8),' ...') as intro,";
$sql.=" IF(filho.id_menu is null, concat(convertUrl(filho.nome),'/',convertUrl(noticias.titulo)), concat(convertUrl(pai.nome),'/',convertUrl(filho.nome),'/',convertUrl(noticias.titulo))) as url,";
$sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal";
$sql.=" from noticias ";
$sql.=" left join menus filho on(filho.id=noticias.id_menu) ";
$sql.=" left join menus pai  on (pai.id=filho.id_menu) "; 
$sql.=" where ";
$sql.=" (pai.id_menu is null) ";
$sql.=" and(";
$sql.="  (((pai.nome=:ler_menu)or(filho.nome=:ler_menu))and(:ler_sub_menu=''))";
$sql.="  or ";
$sql.="  ((pai.nome=:ler_menu)and(filho.nome=:ler_sub_menu))";
$sql.="  )";
$sql.=" order by noticias.id desc   ";
$sql.=" limit 0 , 27";
$result=DAOquery($sql,array('ler_menu'=>$ler_menu,'ler_sub_menu'=>$ler_sub_menu),true,"");


$i=1;

for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
    if($menus[$menu_index-1][1]==$ler_menu)
        break;
}
?>
<div class="row mt-3">
	<div class="col-sm-9" >
	     <div class="row  block-row-1">
            <div class="col-sm-12 h-100" >
                <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h2 text-uppercase text-white"><?php echo $ler_menu;?></p></div>
                <?php if($ler_sub_menu!=""){?>
                <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h2 text-uppercase text-white"><?php echo $ler_sub_menu;?></p></div>
                <?php }?>
                <div class="w-100 block-row-2 block-bg-3" ><div class="w-100 h-100 bg-menu-4" ><?php include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/slide_show.php"?></div></div>
        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
			<div class="w-100 "><?php patrocineo("banner lateral 1");?></div>
		</div>
		<div class="row block-row-1 mx-0 pt-2">
			<div class="w-100 "><?php patrocineo("banner lateral 2");?></div>
		</div>
	</div>
</div>




<div class="row mt-3 block-row-2">
	<?php $j=0; for ($i = 0; $i < 3; $i++) { 
        $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;?> " href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($foto_principal)){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 3");?></div>
	</div>
</div>





<?php for ($j = 1; $j < 3; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 0; $i < 3; $i++) {
        $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $subtitulo=resultDataFieldByTitle($result,"subtitulo",($i+$j*3));
        $intro=resultDataFieldByTitle($result,"intro",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if(isset($foto_principal)){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $menu_index;?>"><?php echo $titulo;?></h6>
						<h6 class="card-subtitle text-muted mb-2"><?php echo $subtitulo;?></h6>
						<p class="card-text text-dark " style="height: 32px;">
							<?php echo strip_tags($intro);?> 
						 </p>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " ><?php patrocineo("banner lateral ".(3+$j));?></div>
	</div>
</div>
<?php }?>



		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="row h-100">
					<div class="col-sm-9 h-100" >
						<div class="row h-100">
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 1");?></div>
							</div>
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 2");?></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 h-100" >
						<div class="w-100 h-100 " ><?php patrocineo("banner lateral 6");?></div>
					</div>
				</div>
			</div>
		</div>


		<div class="row mt-3 block-row-2" style="overflow:hidden"> 
			 <?php include "barra_atalho_menu1.php" ?>
			<div class="col-sm-3" >
				<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 12");?></div>
			</div>
		</div>

		

<div class="row mt-3 block-row-2">
	<?php $j=3; for ($i = 0; $i < 3; $i++) { 
        $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;;?> " href="<?php echo $base_url;?>/ler/<?php $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($foto_principal)){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 3");?></div>
	</div>
</div>




<?php for ($j = 4; $j < 6; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 0; $i < 3; $i++) {        
	    $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $subtitulo=resultDataFieldByTitle($result,"subtitulo",($i+$j*3));
        $intro=resultDataFieldByTitle($result,"intro",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if(isset($foto_principal)){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $menu_index;?>"><?php echo $titulo;?></h6>
						<h6 class="card-subtitle text-muted mb-2"><?php echo $subtitulo;?></h6>
						<p class="card-text text-dark " style="height: 32px;">
							<?php echo strip_tags($intro);?> 
						 </p>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " ><?php patrocineo("banner lateral ".(5+$j));?></div>
	</div>
</div>
<?php }?>



		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="row h-100">
					<div class="col-sm-9 h-100" >
						<div class="row h-100">
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 3");?></div>
							</div>
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 4");?></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 h-100" >
						<div class="w-100 h-100 " ><?php patrocineo("banner lateral 11");?></div>
					</div>
				</div>
			</div>
		</div>

     

		<div class="row mt-3 block-row-2" style="overflow:hidden"> 
			 <?php include "barra_atalho_menu2.php" ?>
			<div class="col-sm-3" >
				<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 12");?></div>
			</div>
		</div>











		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="row h-100">
					<div class="col-sm-9 h-100" >
						<div class="row h-100">
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 5");?></div>
							</div>
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 6");?></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 h-100" >
						<div class="w-100 h-100 "><?php patrocineo("banner lateral 13");?></div>
					</div>
				</div>
			</div>
		</div>



<div class="row mt-3 block-row-2">
	<?php $j=6; for ($i = 0; $i < 3; $i++) { 
	    $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;?> " href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($foto_principal)){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 3");?></div>
	</div>
</div>



<?php for ($j = 7; $j < 9; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 0; $i < 3; $i++) {
	    $menu_principal=resultDataFieldByTitle($result,"menu_principal",($i+$j*3));
        $titulo=resultDataFieldByTitle($result,"titulo",($i+$j*3));
        $subtitulo=resultDataFieldByTitle($result,"subtitulo",($i+$j*3));
        $intro=resultDataFieldByTitle($result,"intro",($i+$j*3));
        $url=resultDataFieldByTitle($result,"url",($i+$j*3));
        $foto_principal="";
        try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",($i+$j*3));}catch(Exception $e){}
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$menu_principal)
                break;
        }
	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if(isset($foto_principal)){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $menu_index;?>"><?php echo $titulo;?></h6>
						<h6 class="card-subtitle text-muted mb-2"><?php echo $subtitulo?></h6>
						<p class="card-text text-dark " style="height: 32px;">
							<?php echo strip_tags($intro);?> 
						 </p>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100" ><?php patrocineo("banner lateral ".(13+$j));?></div>
	</div>
</div>
<?php }?>