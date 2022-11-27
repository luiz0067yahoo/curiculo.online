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
  <HeaderView title="Curiculo Online - Dados Básicos" />
  <div class="container mt-4">
    DADOS BÁSICOS - EXPERIÊNCIA PROFISSIONAL - FORMAÇÃO ACADÊMICA - CONHECIMENTOS E HABILIDADES - ÁREA E CARGO PRETENDIDO - DADOS PESSOAIS
</div>

<div class="container mt-4">

    <h3>Dados Básicos</h3>
    <hr>
    <div class="row">
        <div class="col">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nome</span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>Sexo</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">Feminino</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                <label class="form-check-label" for="inlineRadio3">Prefiro não dizer</label>
            </div>
        </div>
        
    </div>
    <div class="row mt-4">
        <div class="col">
            <p>Data de nascimento</p>
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="birthday" name="birthday" style="width:90%;">
            </div>
        </div>
        <div class="col">
            <p>Pretensão salarial</p>
            <div class="input-group">
                <span class="input-group-text" id="inputGroup-sizing-default"><i
                            class="far fa-money-bill-alt"></i></span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="0.000,00">
            </div>
        </div>
    </div>
</div>



<div class="container mt-4 mb-4">
    <h3>Redes Sociais</h3>
    <hr>
    <div class="row">
        <div class="col">
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fab fa-facebook-f"></i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fab fa-twitter"></i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fab fa-instagram"></i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                class="fab fa-linkedin-in"></i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr style="width: 100%; margin-top:10px; padding: 1px !important;">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/novo_usuario"><button class="btn_blue" type="button">Anterior</button></a>
                <a href="/experiencia_profissional"><button class="btn_blue" type="button">Próximo</button></a>
            </div>
        </div>
    </div>
</div>  
  <FooterView />
</template>
<style scoped>
  
</style>
