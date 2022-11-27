<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


$indexIdMenu=0;

$sql="  select ";
$sql.=" noticias.id, ";
$sql.=" noticias.foto_principal, ";
$sql.=" noticias.titulo, ";
$sql.=" noticias.subtitulo, ";
$sql.=" concat(CAST(noticias.conteudo_noticia AS CHAR(20) CHARACTER SET utf8),' ...') as intro,";
$sql.=" IF(filho.id_menu is null, concat(filho.nome,'/',noticias.titulo), concat(pai.nome,'/',filho.nome,'/',noticias.titulo)) as url,";
$sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal,";
$sql.=" filho.nome as sub_menu, ";
$sql.=" noticias.conteudo_noticia, ";
$sql.=" noticias.fonte ";
$sql.=" from noticias ";
$sql.=" left join menus filho on(filho.id=noticias.id_menu) ";
$sql.=" left join menus pai  on (pai.id=filho.id_menu) "; 
$sql.=" where ";
$sql.=" (pai.id_menu is null) ";
$sql.=" and ";
$sql.=" ( ";
$sql.=" ((pai.nome=:ler_menu)and(filho.nome=:ler_sub_menu)and(noticias.titulo=:ler_titulo_noticia)) ";
$sql.=" or ";
$sql.=" ((pai.nome=:ler_menu)and(:ler_sub_menu=:ler_sub_menu)and(noticias.titulo=:ler_titulo_noticia)) ";
$sql.=" ) ";
$sql.=" limit 0 , 1";


$result=DAOquery($sql,['ler_menu'=>$ler_menu,'ler_sub_menu'=>$ler_sub_menu,'ler_titulo_noticia'=>$ler_titulo_noticia],true,"");

for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
    if($menus[$menu_index-1][1]==resultDataFieldByTitle($result,"menu_principal",0))
        break;
}

$id_noticia=resultDataFieldByTitle($result,"id",0);
$titulo=resultDataFieldByTitle($result,"titulo",0);
$subtitulo=resultDataFieldByTitle($result,"subtitulo",0);
$foto_principal="";
try{$foto_principal=resultDataFieldByTitle($result,"foto_principal",0);}catch(Exception $e){}
$conteudo_noticia=resultDataFieldByTitle($result,"conteudo_noticia",0);
$fonte=resultDataFieldByTitle($result,"fonte",0);

DAOquery("UPDATE `noticias` SET acesso=acesso+1 WHERE id=:id",["id"=>$id_noticia],false,"");
?>
<div class="row mt-3">
	<div class="col-sm-9" >
	    <div class="row  block-row-1">
            <div class="col-sm-12 h-100" >
                <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h2 text-uppercase text-white"><?php echo $ler_menu;?></p></div>
                <?php if($ler_sub_menu!=""){?>
                    <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h3 text-uppercase text-white"><?php echo $ler_sub_menu; ?></p></div>
                <?php } ?>
        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
			<div class="w-100 "><?php patrocineo("banner lateral 1");?></div>
		</div>
	</div>
</div>	


<div class="row mt-3">
	<div class="col-sm-9" >
	    <div class="row  block-row-1">
            <div class="col-sm-12 h-100" >
        		<div class="menu<?php echo $menu_index;?>"><p class="text-color-<?php echo $menu_index;?> h4"><?php echo $titulo;?></p></div>
        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
			<div class="w-100 "><?php patrocineo("banner lateral 2");?></div>
		</div>
	</div>
</div>

<div class="row mt-3">
	<div class="col-sm-9" >
	    <div class="row  block-row-1">
            <div class="col-sm-12 h-100" >
    			<div class=" menu<?php echo $menu_index;?>"><p class="text-muted h4"><?php echo $subtitulo;?></p></div>
        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
			<div class="w-100 "><?php patrocineo("banner lateral 3");?></div>
		</div>
	</div>
</div>	

<div class="row py-0 ">
	<div class="col-sm-9" >
	    <div class="row py-0 block-row-2">
            <div class="col-sm-12 h-100" >
        		<div class="w-100" >
        			<?php if(isset($Foto_principalNoticia)){?>
        			<a><img src="<?php echo $base_url;?>/uploads/noticias/320x240/<?php  echo $foto_principal;?>" class="rounded mx-auto d-block" height="240px"></a>
        			<?php }?>
        		</div>

        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
    		<div class="w-100 "><?php patrocineo("banner lateral 4");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 5");?></div>
		</div>
	</div>
</div>	


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



<div class="row mt-3  ">
	<div class="col-sm-9" >
	    <div class="row py-0 block-row-3">
            <div class="col-sm-12 " >
        			<p class="w-100 text-color-<?php echo $menu_index;?> "><?php echo $conteudo_noticia;?></p>
        			<p class="text-dark h5">Fonte: <?php echo $fonte;?></p>
        	</div>  
	    </div>
	</div>
	<div class="col-sm-3" >
		<div class="row mx-0 pb-2 " >
    		<div class="w-100 "><?php patrocineo("banner lateral 7");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 8");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 9");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 10");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 11");?></div>
    		<div class="w-100 mt-3"><?php patrocineo("banner lateral 12");?></div>
		</div>
	</div>
</div>	




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
				<div class="w-100 h-100 " ><?php patrocineo("banner lateral 13");?></div>
			</div>
		</div>
	</div>
</div>

	


<div class="row mt-3 block-row-2">
    <?php include "barra_atalho_menu1.php";?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 14");?></div>
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
				<div class="w-100 h-100 " ><?php patrocineo("banner lateral 15");?></div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-3 block-row-2">
    <?php include "barra_atalho_menu2.php";?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 16");?></div>
	</div>
</div>	  
