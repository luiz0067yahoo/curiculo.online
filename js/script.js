jQuery(document).ready(function() {
    jQuery("*").click(function(event) { //all element clicked 
        element = jQuery(event.target); //element clicked
        if (element.prop("tagName") != 'a') element = element.closest('a'); //not is tagName <a></a> then parent is tagname <a></a>
        if ((element.length != 0) && (element.attr("href") != null) && (element.attr("href") != undefined) && (element.attr("href").length > 0)) { //exists element tagname <a></a> and not empty href 
            event.preventDefault(); //start event
            const url = new URL(element.attr("href")); //start object url with href
            if (!jQuery('.containerMiniMenu').hasClass('d-none')) jQuery('.containerMiniMenu').addClass('d-none'); //hidde div className containerMiniMenu
            loadDivMain(url.pathname); //load file by path
			window.history.pushState('', element.attr("title"), element.attr("href"));
            event.stopPropagation(); //no refresh page
        } else if (element.length == 0) { //not is element tagname <a></a>
            element = jQuery(event.target); //load element event click
            if (element.attr("id") != "iconAcount") element = jQuery(event.target).closest('#iconAcount'); //element id is iconAcount if not load parent element with id iconAcount
            if (element.length != 0) { //element have id = iconAcount
                jQuery('.containerMiniMenu').toggleClass('d-none'); //toggle hidde show div className containerMiniMenu
                return 0; //exit function
            }
        }
        if (!jQuery('.containerMiniMenu').hasClass('d-none')) jQuery('.containerMiniMenu').addClass('d-none'); //hidde div className containerMiniMenu
    });


    function loadDivMain(pathname_) {
        if (pathname_ === '/formacao_academica/') {
            $('#divMain').load('https://curiculo.online/formacao_academica.html');
			$('title').html("Formacao Acadêmica");
        } else if (pathname_ === '/conhecimentos/') {
            $('#divMain').load('https://curiculo.online/conhecimentos.html');
			$('title').html("Conhecimentos");
        } else if (pathname_ === '/cargo_pretendido/') {
            $('#divMain').load('https://curiculo.online/cargo_pretendido.html');
			$('title').html("Cargo Pretendido");
        } else if (pathname_ === '/dados_pessoais/') {
            $('#divMain').load('https://curiculo.online/dados_pessoais.html');
			$('title').html("Dados Pessoais");
        } else if (pathname_ === '/experiencia_profissional/') {
            $('#divMain').load('https://curiculo.online/experiencia_profissional.html');
        } else if (pathname_ === '/cadastro_estados/') {
            $('#divMain').load('https://curiculo.online/cadastro_estados.html');
			$('title').html("Cadastro Estados");
        } else if (pathname_ === '/dados_basicos/') {
            $('#divMain').load('https://curiculo.online/dados_basicos.html');
			$('title').html("Dados Básicos");
        }  else if (pathname_ === '/adm/') {
            $('#divMain').load('https://curiculo.online/adm.html');
			$('title').html("login");
        } else {
            $('#divMain').load('https://curiculo.online/dados_basicos.html');
			$('title').html("Dados Básicos");
        }
    }
    jQuery('#divHeader').load('https://curiculo.online/header_.html');
    loadDivMain(window.location.pathname);
    jQuery('#divFooter').load('https://curiculo.online/footer.html');
	
	
	

	
});
