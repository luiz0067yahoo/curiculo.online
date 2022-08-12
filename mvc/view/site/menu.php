
				
				
				<nav class="navbar navbar-expand-lg w-100 ">
					<div class="container-fluid p-0 " >
						<button id="abrir_menus" class="navbar-toggler  collapsed rounded border border-dark" type="button" >
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
						</button>
							<ul id="navbarNavDropdown" class="show navbar-nav navbar-collapse collapse  h5 text-center  w-100 "style="min-height:0px" >
							<?php
							
								$menus=array();
								//$sql="select id,nome from menus where (id_menu is null) and nome!='home'";
								//$result_menu=DAOquery($sql,"",true,"");
								$sql="select id,nome from menus where (id_menu is :id_menu) and nome!='home'";
								$result_menu=DAOquery($sql,["id_menu"=>null],true,"");
								if (isset($result_menu["data"])){
									$menus=$result_menu["data"];
								}
						        for($i=1;$i<=count($menus);$i++){
								    $menu_nome=resultDataFieldByTitle($result_menu,"nome",($i-1));
								    $menu_id=resultDataFieldByTitle($result_menu,"id",($i-1));
								    $prefixo="/ler";
                                    if ((strtolower($menu_nome)=="fotos") or (strtolower($menu_nome)=="vídeos"))
                                        $prefixo="";
								?>
								<li class=" col nav-item  text-color-<?php echo $i; ?> "  style="padding-left: 0;padding-right: 0; <?php if($i==3) echo "min-width:190px;"?>"  >
									
									<a id="menu<?php echo $i; ?>" style="padding-left: 0;padding-right: 0;"  class="nav-link dropdown-toggle text-capitalize" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $menu_nome;?></a>
									<?php
        								$sub_menus=array();
        								$sql="select id,nome from menus where (id_menu = $menu_id)";
        								$result_sub_menu=DAOquery($sql,"",true,"");
        								if (isset($result_menu["data"])){
        									


									?>
									<div class="dropdown-menu bg-menu-<?php echo $i; ?> text-left text-uppercase " id="submenu<?php echo $i; ?>" aria-labelledby="menu<?php echo $i; ?>">
									    <?php
									        for($j=1;$j<=count($result_sub_menu["data"]);$j++){
                                                $sub_menu_nome=resultDataFieldByTitle($result_sub_menu,"nome",($j-1));
									    ?>
    										<a style="<?php if($i==6) echo "color:#000000;"?>" class="dropdown-item" href="<?php echo $base_url;?><?php echo $prefixo;?>/<?php echo $menu_nome; ?>/<?php echo $sub_menu_nome;?>/"><?php echo $sub_menu_nome; ?></a>
								        <?php }?>
									</div>
									<?php }?>
								</li>
								<?php }?>

							</ul>
					</div>
				</nav>
