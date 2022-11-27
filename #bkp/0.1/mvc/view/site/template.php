<?php 
    require($_SERVER['DOCUMENT_ROOT'].'/library/functions.php');
    include($_SERVER['DOCUMENT_ROOT'].'/mvc/view/site/patrocineo.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $base_url="https://$_SERVER[HTTP_HOST]";

?><!doctype html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Tooeste Informação ao seu alcance</title>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url;?>/assets/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $base_url;?>/assets/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url;?>/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $base_url;?>/assets/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $base_url;?>/assets/img/favicon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $base_url;?>/assets/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta property="og:title" content="">
	<meta property="og:type" content="">
	<meta property="og:url" content="">
	<meta property="og:image" content="">

	<link rel="manifest" href="<?php echo $base_url;?>/assets/img/favicon/site.webmanifest">
	<link rel="apple-touch-icon" href="<?php echo $base_url;?>/assets/img/favicon/icon.png">


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo $base_url;?>/assets/css/simpleLightbox.css" >
	<link rel="stylesheet" href="<?php echo $base_url;?>/assets/css/tooeste.css" >

    <link rel="stylesheet" href="assets/css/fonts.css" type="text/css" charset="utf-8" />
	<style id="compiled-css" type="text/css">
		
	</style>
	<meta name="theme-color" content="#fafafa">
</head>

<body>
<!-- Modal -->
<div class="modal fade" id="modal_banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_banner_title">nome da foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="modal_banner_image" src="<?php echo $base_url;?>" width="100%">
      </div>
      <div class="modal-footer">   </div>
    </div>
  </div>
</div>

	<header>
		<nav class="row bg-primary  py-0">
			<div class="container" >
                  <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-between">
                    
                      <ul class="navbar-nav">
                        <li class="nav-item ">
                          <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                              <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                          </a>
                        </li>
                      </ul>
                      <form class="form-inline" style="visibility:hidden">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar">
                        <button class="btn btn-outline-light my-2 my-sm-0 border-0" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>              
                        </button>
                      </form>
                    <div class="navbar-nav ">
                        <a class="nav-link" href="https://www.tempo.com/toledo_parana-l116233.htm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-sun-fill" viewBox="0 0 16 16">
                              <path d="M11.473 11a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5h-.027z"/>
                              <path d="M10.5 1.5a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0v-1zm3.743 1.964a.5.5 0 1 0-.707-.707l-.708.707a.5.5 0 0 0 .708.708l.707-.708zm-7.779-.707a.5.5 0 0 0-.707.707l.707.708a.5.5 0 1 0 .708-.708l-.708-.707zm1.734 3.374a2 2 0 1 1 3.296 2.198c.199.281.372.582.516.898a3 3 0 1 0-4.84-3.225c.352.011.696.055 1.028.129zm4.484 4.074c.6.215 1.125.59 1.522 1.072a.5.5 0 0 0 .039-.742l-.707-.707a.5.5 0 0 0-.854.377zM14.5 6.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                                </svg> 
                        </a>
                        <a class="nav-link"><?php echo date('d/m/Y');?></a>
                    </div>
                  </nav>
			</div>
		</nav>
		
		<div  class="container">
			<div class="row mt-3">
				<div class="col-sm-3" style="height:120px;">
					<div class="w-100 h-100" style="height:120px;text-align:center;" ><a href="<?php echo $base_url;?>"><img class="h-100" style="width:160px;height:120px;"
						src="<?php echo $base_url;?>/assets/img/logo.png"
					></a></div>
				</div>
				<div class="col-sm-3 h-100 text-center" style="font-size: 48px;color:#1d2554;font-family:'Conv_trademarker-bolditalic',Sans-Serif; line-height:120px">Tooeste<div class="h-100" >
                    
				</div></div>
				<div class="col-sm-6 h-100"><div class="w-100 h-100 block-bg-1" ><?php patrocineo("banner topo");?></div></div>
			</div>
		</div>	
		<nav class="row  py-3 mt-1" style="background-color:#fbb12e"></nav>
		<div  class="container">	
			
			<div class="row mt-0" style="color:#1d2554;font-family:'Conv_trademarker-bolditalic',Sans-Serif;">
				<?php include ($_SERVER['DOCUMENT_ROOT']."/mvc/view/site/menu.php");?>
			</div>
		</div>
		<nav class="row  py-1 mb-3" style="background-color:#1d2554"></nav>
	</header>




	<div  class="container">
		<div class="row mt-0">
			<div class="col-sm-12" ><div class="w-100 block-row-1 block-bg-3" ><?php patrocineo("banner abaixo do menu");?></div></div>
		</div>
		




        <?php 
        
        if(isset($erro)){
            include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/erro.php";
        }
        else
		    include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/ler.php";
		
		include $_SERVER['DOCUMENT_ROOT']."/mvc/view/site/mais_vistas.php";
		
		
		
		?>





		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >
				<div class="row h-100">
					<div class="col-sm-9 h-100" >
						<div class="row h-100">
							<div class="col-sm-6 h-100" >
								<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 9");?></div>
							</div>
							<div class="col-sm-6 h-100" >
							<div class="w-100 h-100 " ><?php patrocineo("banner meio noticia 10");?></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 h-100" >
						<div class="w-100 h-100 " ><?php patrocineo("banner lateral 21");?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3 block-row-1">
			<div class="col-sm-12 h-100" >  
				<div class="w-100 h-100 " ><?php patrocineo("banner rodape");?></div>
			</div>
		</main>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script src="<?php echo $base_url;?>/assets/js/simpleLightbox.js" ></script>
  <script src="<?php echo $base_url;?>/assets/js/tooeste.js" ></script>
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
