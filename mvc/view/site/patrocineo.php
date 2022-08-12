<?php 
    //$base_url="https://$_SERVER[HTTP_HOST]";
    if (!function_exists("patrocineo")) {
        function patrocineo($tipo_nome)
		{
?>
<div  class="carousel slide" data-bs-ride="carousel" >
  <div class="carousel-inner">
<?php


    $Foto="";
    $url="";

    $Fotos_patrocineo_topos=array();
    $sql="SELECT anuncios.* FROM `anuncios` LEFT join tipos_anuncios on(id_tipo_anuncio=tipos_anuncios.id) where(tipos_anuncios.nome=:tipo_nome)";
    $result=DAOquery($sql,array("tipo_nome"=>$tipo_nome),true,"");
    for($i=0;$i<=count($Fotos_patrocineo_topos);$i++){
        $Foto=resultDataFieldByTitle($result,"foto",$i);
        $fotoexpandida=resultDataFieldByTitle($result,"foto_expandida",$i);
        $Nome=resultDataFieldByTitle($result,"nome",$i);

        try{
            if((isset($Foto))){
            
            ?>
                <div class="carousel-item <?php if($i==0) echo "active" ?>">
                  <a href="javascript:void();" title="<?php echo $Nome; ?>"><img src="<?php echo "https://$_SERVER[HTTP_HOST]";?>/uploads/anuncio/800x600/<?php echo $Foto;?>" class="d-block w-100 modal_banner" alt="<?php echo $Nome;?>" style="height:120px;" fotoexpandida="<?php echo "https://$_SERVER[HTTP_HOST]";?>/uploads/anuncio/800x600/<?php echo $fotoexpandida;?>"></a>
                </div>
            <?php             
            }
        }
        catch(Exception $e){

        }
    }
?>
  </div>
</div>
<?php 
        }
}
?>

<?php 
    if (!function_exists("patrocineo_mini")) {
        function patrocineo_mini($tipo_nome)
		{
?>
<div  class="carousel slide" data-bs-ride="carousel" >
  <div class="carousel-inner">
<?php


    $Foto="";
    $url="";

$Fotos_patrocineo_topos=array();
    $sql="SELECT anuncios.* FROM `anuncios` LEFT join tipos_anuncios on(id_tipo_anuncio=tipos_anuncios.id) where(tipos_anuncios.nome=:tipo_nome)";
    $result=DAOquery($sql,array("tipo_nome"=>$tipo_nome),true,"");
    for($i=0;$i<=count($Fotos_patrocineo_topos);$i++){
        $Foto=resultDataFieldByTitle($result,"foto",$i);
        $fotoexpandida=resultDataFieldByTitle($result,"foto_expandida",$i);
        $Nome=resultDataFieldByTitle($result,"nome",$i);


        try{
            if((isset($Foto))){
            
            ?>
                <div class="carousel-item <?php if($i==0) echo "active" ?>">
                  <a href="javascript:void();" title="<?php echo $Nome; ?>"><img src="<?php echo "https://$_SERVER[HTTP_HOST]";?>/uploads/anuncio/160x120/<?php echo $Foto;?>" class="d-block w-100 modal_banner" alt="<?php echo $Nome;?>" style="height:120px;" fotoexpandida="<?php echo "https://$_SERVER[HTTP_HOST]";?>/uploads/anuncio/800x600/<?php echo $fotoexpandida;?>"></a>
                </div>
            <?php             
            }
        }
        catch(Exception $e){

        }
    }
?>
  </div>
</div>
<?php 
        }
}
?>