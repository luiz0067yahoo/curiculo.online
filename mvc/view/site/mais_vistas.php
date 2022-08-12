


		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="row h-100">
					<div class="col-sm-9 h-100" >
						<div class="row h-100">
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 7");?></div>
							</div>
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 8");?></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 h-100" >
						<div class="w-100 h-100" ><?php patrocineo("banner lateral 17");?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="w-100 h-100 " ><?php patrocineo("banner meio");?></div>
			</div>
		</div>





		<div class="row mt-3 ">
			<div class="col-sm-12">
				MAIS VISTAS
			</div>
		</div>

<?php

$sql="  select ";
$sql.=" noticias.foto_principal, ";
$sql.=" noticias.titulo, ";
$sql.=" noticias.subtitulo, ";
$sql.=" concat(CAST(noticias.conteudo_noticia AS CHAR(20) CHARACTER SET utf8),' ...') as intro,";
$sql.=" IF(filho.id_menu is null, concat(filho.nome,'/',noticias.titulo), concat(pai.nome,'/',filho.nome,'/',noticias.titulo)) as url,";
$sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal";
$sql.=" from noticias ";
$sql.=" left join menus filho on(filho.id=noticias.id_menu) ";
$sql.=" left join menus pai  on (pai.id=filho.id_menu) "; 
$sql.=" where ";
$sql.=" (pai.id_menu is null) ";
$sql.="  order by noticias.acesso asc";
$sql.=" limit 0 , 9;";
$result_mais_vistas=DAOquery($sql,"",true,"");
$mais_vistas=array();
if (isset($result_mais_vistas["data"])){$mais_vistas=$result_mais_vistas["data"];}
if((isset($result_mais_vistas["title"]))){$mais_vistas_campos=$result_mais_vistas["title"];}
?>

<div class="row mt-3 block-row-2">
	<?php for ($i = 0; $i < 3; $i++) {?>
    <?php 
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$mais_vistas[$i][array_search('menu_principal',$mais_vistas_campos)])
                break;
        }
	?>

	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3 menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;?>  text-capitalize" href="/<?php echo $mais_vistas[$i][array_search('url',$mais_vistas_campos)];?>"><?php echo $mais_vistas[$i][array_search('titulo',$mais_vistas_campos)];?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php try{$Foto_principalNoticia=$mais_vistas[$i][array_search('foto_principal',$mais_vistas_campos)];if(isset($Foto_principalNoticia)){?>
			<a href="/<?php echo $mais_vistas[$i][array_search('url',$mais_vistas_campos)];?>"><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="w-100 h-100"></a>
			<?php }}catch(Exception $e){}?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral 18");?></div>
	</div>
</div>



<?php for ($j = 1; $j <= 2; $j++) {?>
<div class="row mt-3 block-row-2">
	<?php for ($i = 1; $i <= 3; $i++) {?>
    <?php 
        for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$mais_vistas[$i+$j*3-1][array_search('menu_principal',$mais_vistas_campos)])
                break;
        }
	?>	
	<div class="col-sm-3">
		<a href="/ler/<?php echo $mais_vistas[$i+$j*3-1][array_search('url',$mais_vistas_campos)];?>" style="text-decoration:none;">
		<div class="card overflow-hidden w-100">
			<div class="row no-gutters">
				<div class="col-md-4">
					
					<?php try{$Foto_principalNoticia=$mais_vistas[$i+$j*3-1][array_search('foto_principal',$mais_vistas_campos)];if(isset($Foto_principalNoticia)){?>
						<img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $Foto_principalNoticia;?>" class="card-img">
					<?php }}catch(Exception $e){}?>
				</div>
				<div class="col-md-8">
					<div class="card-body" style="padding-top: 5px;">
						<h6 class="card-title text-color-<?php echo $menu_index;?>"><?php echo $mais_vistas[$i+$j*3-1][array_search('titulo',$mais_vistas_campos)];?></h6>
						<h6 class="card-subtitle text-muted mb-2"><?php echo $mais_vistas[$i+$j*3-1][array_search('subtitulo',$mais_vistas_campos)];?></h6>
						<p class="card-text text-dark " style="height: 32px;">
							<?php echo strip_tags($mais_vistas[$i+$j*3-1][array_search('intro',$mais_vistas_campos)]);?> 
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

