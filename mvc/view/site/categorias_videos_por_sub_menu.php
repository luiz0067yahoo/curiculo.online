<?php
    $indexIdMenu=0;
    $sql=" select ";
    if($ler_sub_menu!=''){
        $sql.=" videos.video,";
        $sql.=" videos.nome,";
    }
    else{
        $sql.=" album_videos.nome, ";
        $sql.=" (select videos.video from videos where(videos.id_album=album_videos.id) order by videos.id desc limit 0,1) as video, ";
    }
    $sql.=" album_videos.nome, IF(filho.id_menu is null, concat(filho.nome,'/',album_videos.nome),";
    $sql.=" concat(pai.nome,'/',filho.nome,'/',album_videos.nome)) as url, ";
    $sql.=" IF(filho.id_menu is null,filho.nome,pai.nome) as menu_principal ";
    $sql.=" from album_videos ";
    if($ler_sub_menu!=''){
        $sql.=" left join videos on(videos.id_album=album_videos.id) ";
    }
    $sql.=" left join menus filho on(filho.id=album_videos.id_menu) ";
    $sql.=" left join menus pai on (pai.id=filho.id_menu) ";
    $sql.=" where  ";
    $sql.=" (pai.id_menu is null) ";
    $sql.=" and (";
    $sql.=" (((filho.nome=:ler_menu ) or (pai.nome=:ler_menu)) and (:ler_sub_menu=''))";
    $sql.=" or ";
    $sql.=" ((filho.nome=:ler_sub_menu ) and (pai.nome=:ler_menu))";
    $sql.=" )";
    $sql.=" order by videos.id desc   ";    
    $sql.=" limit 0 , 10";
    $params=array("ler_menu"=>$ler_menu,"ler_sub_menu"=>$ler_sub_menu);
    $cat_videos=array();
    $campos=array();

    $result_videos=DAOquery($sql,$params,true,"");



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
                    <div class="  menu<?php echo $menu_index;?>"><p class="bg-menu-<?php echo $menu_index;?> p-1 h3 text-uppercase text-white"><?php echo $ler_sub_menu; ?></p></div>
                <?php } ?>
                <div class="w-100 block-row-2 block-bg-3" ><div class="w-100 h-100 bg-menu-4" ><?php include "./slide_show_videos.php"?></div></div>
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


<?php for ($j = 0; $j < 3; $j++) { ?>
<div class="row mt-3 block-row-2">
    <?php  for ($i = 0; $i < 3; $i++) {
        $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $url=resultDataFieldByTitle($result_videos,"url",($i+($j*3)));
        $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $video="";
        try{$video=resultDataFieldByTitle($result_videos,"video",($i+($j*3)));}catch(Exception $e){}
    ?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;;?> " href="<?php echo $base_url;?>/<?php echo $url?>"><?php echo $nome;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($video)){?>
			<a href="<?php echo $base_url;?>/<?php echo $url;?>"><center><iframe class="mx-auto" src="https://www.youtube.com/embed/<?php echo $video;?>" type="text/html" width="100%"	height="100%" frameborder=0></iframe></center></a>
			<?php }?>
		</div>
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
						<div class="w-100 h-100 " ><?php patrocineo("banner lateral 6");?></div>
					</div>
				</div>
			</div>
		</div>


		<div class="row mt-3 block-row-2">
		    <?php include "barra_atalho_menu1.php" ?>
			<div class="col-sm-3" >
				<div class="w-100 h-100 " style="padding-top:60px" ><?php patrocineo("banner lateral 7");?></div>
			</div>
		</div>


<?php for ($j = 3; $j < 7; $j++) {?>
<div class="row mt-3 block-row-2">
    <?php  for ($i = 0; $i < 3; $i++) {
       $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $url=resultDataFieldByTitle($result_videos,"url",($i+($j*3)));
        $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $video="";
        try{$video=resultDataFieldByTitle($result_videos,"video",($i+($j*3)));}catch(Exception $e){}
    ?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;;?> " href="<?php echo $base_url;?>/<?php echo $url?>"><?php echo $nome;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($video)){?>
			<a href="<?php echo $base_url;?>/<?php echo $url;?>"><center><iframe class="mx-auto" src="https://www.youtube.com/embed/<?php echo $video;?>" type="text/html" width="100%"	height="100%" frameborder=0></iframe></center></a>
			<?php }?>
		</div>
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



<?php for ($j = 7; $j < 10; $j++) {?>
<div class="row mt-3 block-row-2">
    <?php  for ($i = 0; $i < 3; $i++) {
    
       $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $url=resultDataFieldByTitle($result_videos,"url",($i+($j*3)));
        $nome=resultDataFieldByTitle($result_videos,"nome",($i+($j*3)));
        $video="";
        try{$video=resultDataFieldByTitle($result_videos,"video",($i+($j*3)));}catch(Exception $e){}
    ?>
	<div class="col-sm-3 h-100" >
		<div class="h-25 pt-3  menu<?php echo $menu_index;?>"><a class="link-color-<?php echo $menu_index;;?> " href="<?php echo $base_url;?>/<?php echo $url?>"><?php echo $nome;?></a></div>
		<div class="w-100 h-75 bg-menu-<?php echo $menu_index;?> " >
			<?php if(isset($video)){?>
			<a href="<?php echo $base_url;?>/<?php echo $url;?>"><center><iframe class="mx-auto" src="https://www.youtube.com/embed/<?php echo $video;?>" type="text/html" width="100%"	height="100%" frameborder=0></iframe></center></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="col-sm-3" >
		<div class="w-100 h-100 " style="padding-top:60px"><?php patrocineo("banner lateral ".(7+$j));?></div>
	</div>
</div>
<?php }?>