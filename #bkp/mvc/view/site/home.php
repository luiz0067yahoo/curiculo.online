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
$sql.=" and((pai.id=:id)or(filho.id=:id)) ";
$sql.=" order by noticias.id desc   ";
$sql.=" limit 0 , 9";
$result_home=array();
for ($i = 1; $i <= 6; $i++) {
	$result_home[$i]=DAOquery($sql,array('id'=>$menus[$i-1][$indexIdMenu]),true,"");
}
?>
<div class="row mt-2">
	<div class="col-sm-6" ><div class="w-100 block-row-2 block-bg-3" ><div class="w-100 h-100 bg-menu-4" ><?php  include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/slide_show.php"?></div></div></div>
	<div class="col-sm-3" id="anuncio_eventos">
		<div class="row mx-0">
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-4" ><?php patrocineo_mini("banner evento 1");?></div></div>
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-5" ><?php patrocineo_mini("banner evento 2");?></div></div>
		</div>
		<div class="row mx-0 mt-3">
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-4" ><?php patrocineo_mini("banner evento 3");?></div></div>
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-5" ><?php patrocineo_mini("banner evento 4");?></div></div>
		</div>
		<div class="row mx-0 mt-3">
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-4" ><?php patrocineo_mini("banner evento 5");?></div></div>
			<div class="col-sm-6 px-0 " ><div class="w-100 block-row-2-by-3 block-bg-5" ><?php patrocineo_mini("banner evento 6");?></div></div>
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
<div class="row mt-0 block-row-2 py-0">
	<?php $j=0; for ($i = 1; $i <= 3; $i++) {
	    $url=resultDataFieldByTitle($result_home[$i],"url",$j);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i],"foto_principal",$j);}catch(Exception $e){}
	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3 menu<?php echo $i;?>"><a class="link-color-<?php echo $i;?> " href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $i;?> " >
			<?php 
			if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 3");?></div>
	</div>
</div>


<?php for ($j = 1; $j <= 2; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 1; $i <= 3; $i++) {
	    $url=resultDataFieldByTitle($result_home[$i],"url",$j);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j);
	    $intro=resultDataFieldByTitle($result_home[$i],"intro",$j);
	    $subtitulo=resultDataFieldByTitle($result_home[$i],"subtitulo",$j);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i],"foto_principal",$j);}catch(Exception $e){}
	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $i;?>"><?php echo $titulo;?></h6>
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


	    <div class="row mt-3 block-row-2">
            <?php include "barra_atalho_menu1.php";?>
        	<div class="col-sm-3" >
        		<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 7");?></div>
        	</div>
        </div>	  
	    
	    
	    
	    

<div class="row mt-3 block-row-2">
	<?php $j=3; for ($i = 4; $i <= 6; $i++) {
	    $url=resultDataFieldByTitle($result_home[$i],"url",$j-3);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j-3);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i-3],"foto_principal",$j);}catch(Exception $e){}

	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3 menu<?php echo $i;?>"><a class="link-color-<?php echo $i;?> " href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $i;?> " >
			<?php if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $noticias_menus[$i][$j][array_search('url',$noticias_campos_home)];?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 8");?></div>
	</div>
</div>



<?php for ($j = 4; $j <= 5; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 4; $i <= 6; $i++) {
	    $url=resultDataFieldByTitle($result_home[$i],"url",$j-3);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j-3);
	    $intro=resultDataFieldByTitle($result_home[$i],"intro",$j-3);
	    $subtitulo=resultDataFieldByTitle($result_home[$i],"subtitulo",$j-3);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i],"foto_principal",$j);}catch(Exception $e){}

	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $url;?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $i;?>"><?php echo $titulo;?></h6>
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


        <div class="row mt-3 block-row-2">
            <?php include "barra_atalho_menu2.php";?>
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
	<?php $j=3; for ($i = 1; $i <= 3; $i++) {
	    $url=resultDataFieldByTitle($result_home[$i],"url",$j);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i],"foto_principal",$j);}catch(Exception $e){}
	?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3 menu<?php echo $i;?>"><a class="link-color-<?php echo $i;?> " href="<?php echo $base_url;?>/ler/<?php echo $url;?>"><?php echo $titulo;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $i;?> " >
			<?php if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
			<a href="<?php echo $base_url;?>/ler/<?php echo $noticias_menus[$i][$j][array_search('url',$noticias_campos_home)];?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="w-100 h-100"></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 "  style="padding-top:60px" ><?php patrocineo("banner lateral 14");?></div>
	</div>
</div>



<?php for ($j = 4; $j < 6; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 1; $i <= 3; $i++) {

	    $url=resultDataFieldByTitle($result_home[$i],"url",$j);
	    $titulo=resultDataFieldByTitle($result_home[$i],"titulo",$j);
	    $intro=resultDataFieldByTitle($result_home[$i],"intro",$j);
	    $subtitulo=resultDataFieldByTitle($result_home[$i],"subtitulo",$j);
	    $Foto_principalNoticia="";
	    try{$Foto_principalNoticia=resultDataFieldByTitle($result_home[$i],"foto_principal",$j);}catch(Exception $e){}

	?>
	<div class="col-sm-3">
		<a href="<?php echo $base_url;?>/ler/<?php echo $noticias_menus[$i][$j][array_search('url',$noticias_campos_home)];?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php if((isset($Foto_principalNoticia))&&($Foto_principalNoticia!="")){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="card-img">
					<?php }?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $i;?>"><?php echo $titulo;?></h6>
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
		<div class="w-100 h-100" ><?php patrocineo("banner lateral ".(11+$j));?></div>
	</div>
</div>
<?php }?>

