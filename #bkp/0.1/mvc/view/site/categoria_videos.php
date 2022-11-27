<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$indexIdMenu=0;

$sql=" select ";
$sql.=" v.nome as nome_video, ";
$sql.=" v.video, ";
$sql.=" album_videos.nome, IF(filho.id_menu is null, concat(filho.nome,'/',album_videos.nome),";
$sql.=" concat(pai.nome,'/',filho.nome,'/',album_videos.nome)) as url, ";
$sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal ";
$sql.=" from album_videos ";
$sql.=" left join videos v on(v.id_album=album_videos.id) ";
$sql.=" left join menus filho on(filho.id=album_videos.id_menu) ";
$sql.=" left join menus pai on (pai.id=filho.id_menu) ";
$sql.=" where  ";
$sql.=" (pai.id_menu is null) ";
$sql.=" and (album_videos.nome = :ler_categoria) ";
$sql.=" and (";
$sql.=" (((filho.nome=:ler_menu ) or (pai.nome=:ler_menu)) and (:ler_sub_menu=''))";
$sql.=" or ";
$sql.=" ((filho.nome=:ler_sub_menu ) and (pai.nome=:ler_menu)) ";
$sql.=" )";
$sql.=" limit 0 , 9";
$params=array("ler_menu"=>$ler_menu,"ler_sub_menu"=>$ler_sub_menu,"ler_categoria"=>$ler_categoria);

$cat_videos=array();
$cat_campos=array();


$result=DAOquery($sql,$params,true,"");
if (isset($result["data"])){$cat_videos=$result["data"];}
if(isset($result["title"])){$cat_campos=$result["title"];}
for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
    if($menus[$menu_index-1][1]==$ler_menu)
        break;
}
?>
<div class="row mt-3">
	<div class="col-sm-9" >
        <div class="  menu-<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h2 text-uppercase text-white"><?php echo $ler_menu;?></p></div>
        <?php if($ler_sub_menu!=""){?>
            <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h3 text-uppercase text-white"><?php echo $ler_sub_menu; ?></p></div>
        <?php } ?>
         <?php if($ler_categoria!=""){?>
            <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h3 text-uppercase text-white"><?php echo $ler_categoria; ?></p></div>
        <?php } ?>
	</div>
	<div class="col-sm-3" >
		<div class="row block-row-1 mx-0 pb-2 " >
			<div class="w-100 "><?php patrocineo("banner lateral 1");?></div>
		</div>
	</div>
</div>			



<?php for ($j = 0; $j < 3; $j++) {?>
<div class="row mt-3 block-row-2 ">
	<?php for ($i = 0; $i < 3; $i++) {
    	for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$ler_menu)
                break;
        }
        $nome=$cat_videos[$i+$j*3][array_search('nome_video',$cat_campos)]; 
        $video="";
        try{
            $video_=$cat_videos[$i+$j*3][array_search('video',$cat_campos)];
        }catch(Exception $e){};
    ?>
        <div class=" col-sm-3 h-100  card">
        <a class=" galleryItem" href="https://www.youtube.com/embed/<?php  echo $video_;?>" title="<?php echo $nome; ?>">
			<?php if(isset($video_)){?>
				<iframe src="https://www.youtube.com/embed/<?php echo $video_;?>" type="text/html" width="200px"	height="150px" frameborder=0></iframe>
			<?php }?>
            <label class="h-25 pt-3  menu<?php echo $menu_index;?> link-color-<?php echo $menu_index;?> " ><?php echo $nome; ?> </label>
    		
	    </a>
	    </div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral ".(2+$j));?></div>
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
						<div class="w-100 h-100 " ><?php patrocineo("banner lateral 5");?></div>
					</div>
				</div>
			</div>
		</div>


	    <div class="row mt-3 block-row-2">
            <?php include "barra_atalho_menu2.php";?>
        	<div class="col-sm-3" >
        		<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 6");?></div>
        	</div>
        </div>	  







<?php for ($j = 3; $j <= 6; $j++) {?>
<div class="row mt-3 block-row-2 ">
	<?php for ($i = 0; $i < 3; $i++) {
    	for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$ler_menu)
                break;
        }
        $nome=$cat_videos[$i+$j*3][array_search('nome',$cat_campos)]; 
        $video="";
        try{
            $video_=$cat_videos[$i+$j*3][array_search('video',$cat_campos)];
        }catch(Exception $e){};
    ?>
        <div class=" col-sm-3 h-100  card">
        <a class=" galleryItem" href="https://www.youtube.com/embed/<?php  echo $video_;?>" title="<?php echo $nome; ?>">
			<?php if(isset($video_)){?>
				<iframe src="https://www.youtube.com/embed/<?php echo $video_;?>" type="text/html" width="200px"	height="150px" frameborder=0></iframe>
			<?php }?>
            <label class="h-25 pt-3  menu<?php echo $menu_index;?> link-color-<?php echo $menu_index;?> " ><?php echo $nome; ?></label>
    		
	    </a>
	    </div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral ".(4+$j));?></div>
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
		

<?php for ($j = 7; $j < 10; $j++) {?>
<div class="row mt-3 block-row-2 ">
	<?php for ($i = 0; $i < 3; $i++) {
    	for ($menu_index = 1; $menu_index <= count($menus); $menu_index++){
            if($menus[$menu_index-1][1]==$ler_menu)
                break;
        }
        $nome=$cat_videos[$i+$j*3][array_search('nome',$cat_campos)]; 
        $video="";
        try{
            $video_=$cat_videos[$i+$j*3][array_search('video',$cat_campos)];
        }catch(Exception $e){};
    ?>
        <div class=" col-sm-3 h-100  card">
        <a class=" galleryItem" href="https://www.youtube.com/embed/<?php  echo $video_;?>" title="<?php echo $nome; ?>">
			<?php if(isset($video_)){?>
				<iframe src="https://www.youtube.com/embed/<?php echo $video_;?>" type="text/html" width="200px"	height="150px" frameborder=0></iframe>
			<?php }?>
            <label class="h-25 pt-3  menu<?php echo $menu_index;?> link-color-<?php echo $menu_index;?> " ><?php echo $nome; ?></label>
    		
	    </a>
	    </div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral ".(7+$j));?></div>
	</div>
</div>
<?php }?>		
