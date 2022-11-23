
<?php 
$ler_menu=urldecode(getParameter("menu"));
$ler_sub_menu=urldecode(getParameter("sub_menu"));
$ler_categoria=urldecode(getParameter("categoria"));
$ler_titulo_noticia=urldecode(getParameter("noticia"));
$url="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
try{

    date_default_timezone_set("America/Sao_Paulo");
    $data_atual=date("Y-m-d");
    $hora_atual=date("h:i:s");
    {
        $sql=" INSERT INTO contador_acesso_por_pagina ";
        $sql.=" (url, menu, submenu, categoria, titulo, data_acesso, hora_acesso) "; 
        $sql.=" VALUES  ";
        $sql.=" (  ";
        $sql.=" :url,  ";
        $sql.=" :menu,  ";
        $sql.=" :submenu,  ";
        $sql.=" :categoria,  ";
        $sql.=" :titulo,  ";
        $sql.=" :data_acesso,  ";
        $sql.=" :hora_acesso  ";
        $sql.=" )  ";
        $params=array(
            'url'=>$url,
            'menu'=>$ler_menu,
            'submenu'=>$ler_sub_menu,
            'categoria'=>$ler_categoria,
            'titulo'=>$ler_titulo_noticia,
            'data_acesso'=>$data_atual,
            'hora_acesso'=>$hora_atual
        );
        DAOquery($sql,$params,false,"");
        
    }
}catch(Exception $e){
    
}







if($ler_menu=='Fotos'){

    if($ler_categoria!=""){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categoria_fotos.php";
    }
    else if(($ler_menu!="")and($ler_sub_menu=="")and($ler_categoria=="")){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categorias_fotos_por_menu.php";
    }
    else if($ler_menu!=""){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categorias_fotos_por_sub_menu.php";
    }
}
else if($ler_menu=='Vídeos'){
    if($ler_categoria!=""){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categoria_videos.php";
    }
    else if(($ler_menu!="")and($ler_sub_menu=="")and($ler_categoria=="")){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categorias_videos_por_menu.php";
    }
    else if($ler_menu!=""){
         include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/categorias_videos_por_sub_menu.php";
    }
}
else if($ler_titulo_noticia!=""){
     include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/noticia.php";
}
else if(($ler_menu!="")and($ler_sub_menu=="")and($ler_titulo_noticia=="")){
     include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/noticias_por_menu.php";
}
else if($ler_menu!=""){
     include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/noticias_por_sub_menu.php";
}
else{
     include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/home.php";
}
?>