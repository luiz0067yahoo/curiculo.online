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
  <HeaderView title="Curiculo Online - Novo Usuário" />
  <div class="container mt-4">
    CRIE SEU PERFILDE FORMA FÁCIL E RÁPIDA
</div>

<div class="container mt-4 mb-4">

    <h3>Novo Usuário</h3>
    <hr>
    
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">NOME</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-address-card"></i></span>
                <input type="text" class=" form-control "  aria-describedby="basic-addon1 ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">LOGIN</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input type="text" class=" form-control "  aria-describedby="basic-addon1 ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">SENHA</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input type="password" class=" form-control "  aria-describedby="basic-addon1 ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">REPETIR SENHA</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input type="password" class=" form-control "  aria-describedby="basic-addon1 ">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">E-MAIL</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                <input type="email" class=" form-control " placeholder="seuemail@email.com " aria-label="e-mail " aria-describedby="basic-addon1 ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">Celular</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fas fa-mobile-alt"></i></span>
                </div>
                <input type="tel" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="_____">
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col">
            <label for="inputPassword4" class="form-label">Telefone</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fas fa-phone-alt"></i></span>
                </div>
                <input type="tel" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="_____">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr style="width: 100%; margin-top:10px; padding: 1px !important;">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/dados_basicos"><button class="btn_blue" type="button" @click="">Próximo</button></a>
            </div>
        </div>
    </div>
</div>

  <FooterView />
</template>
<style scoped>
  
</style>
