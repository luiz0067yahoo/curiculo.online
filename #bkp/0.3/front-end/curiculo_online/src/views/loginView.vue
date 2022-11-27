<script>
  import HeaderView from './inner/HeaderView.vue'
  import FooterView from './inner/FooterView.vue'
  export default {
      components:{
          HeaderView,FooterView
      },
    }
</script>
<template>
  <HeaderView title="Curiculo Online" />  
<div class="container">
	<h1>LOGIN</h1>
	<br>
	<br>
	<div class="row">
		<div class="sm-12">
			<form >
				<div class="form-row align-items-center">
					<label class="w-100" >Usuario</label>
					<div class="input-group mb-3">
						<label class="sr-only" for="inlineFormInputGroupcodigo">Usuário</label>
						<div class="input-group-prepend">
							<div class="input-group-text h-100">
								<i class="fa fa-key" aria-hidden="true"></i>
							</div>
						</div>
						<input type="text"  class="form-control"   placeholder="Usuário" name="username">
						<div class="input-group-append">								
								<button style="height:38px" name="buscar" type="button" class="btn btn-primary buscarcampo buscarcodigo d-none"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
					<label class="w-100" >Senha</label>
					<div class="input-group mb-3">
						<label class="sr-only" for="inlineFormInputGroupnome">Senha</label>
						<div class="input-group-prepend">
    						<div class="input-group-text h-100">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</div>
						<input type="password" class="form-control"   placeholder="Senha" name="password">
					</div>
				
					<button name="entrar" type="button" class="btn btn-dark"><i class="fas fa-user-check"></i> Entrar</button>      
					
						
				</div>
			</form>
			<br>
			<br>
		</div>
	</div>
</div>
<br>
<br>
  <FooterView />
</template>
<style scoped>
  
</style>
