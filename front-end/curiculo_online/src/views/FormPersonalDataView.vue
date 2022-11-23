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
  <HeaderView title="Curiculo Online - Dados Pessoais" />
  <div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <h3>DADOS PESSOAIS</h3>
            <hr>
            <p>Estamos na reta final! <br> As informações complementares a seguir permitem aumentar a aderência do seu currículo com as vagas disponíveis.</p>
            <hr style="width: 100%; margin-top:10px; padding: 1px !important; color: #b9b9b9;">
            <p>Anexar Foto</p>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile01">
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="inputPassword4" class="form-label">Estado Civil</label>
                <select class="form-select" aria-label="Default select example">
                        <option selected>Selecione seu estado civil atual</option>
                        <option value="1">Solteiro</option>
                        <option value="2">Casado </option>
                        <option value="3">Separado </option>
                        <option value="4">Divorciado</option>
                        <option value="5">Viúvo</option>
                        <option value="5">União Estável</option>
                        <option value="5">Outra</option>
                    </select>
            </div>

            <div class="col-md-4">
                <label for="inputPassword4" class="form-label">Número de filhos</label>
                <input type="number" class="form-control" id="inputPassword4" placeholder="EX: 1">
            </div>

            <div class="col-md-2 mt-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Aceita viajar pela empresa?</label>
                </div>
            </div>
            <div class="col-md-3 mt-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Disponível para mudança de
                            endereço?</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <h3>ENDEREÇO</h3>
            <hr>
        </div>
        <form class="row">
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="inputCity" placeholder="Cidade">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Estado</label>
                <input type="text" class="form-control" id="inputZip" placeholder="Estado">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Pais</label>
                <input type="text" class="form-control" id="inputZip" placeholder="Pais">
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">CEP</label>
                <input type="text" class="form-control" id="inputZip" placeholder="CEP">
            </div>
            <div class="col-md-3">
                <label for="inputAddress" class="form-label">Logradouro</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Logradouro">
            </div>
            <div class="col-md-3">
                <label for="inputAddress" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Logradouro">
            </div>
            <div class="col-md-3">
                <label for="inputAddress2" class="form-label">Número</label>
                <input type="number" class="form-control" id="inputAddress2" placeholder="N°">
            </div>
            <div class="col-md-3">
                <label for="inputAddress" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Logradouro">
            </div>
        </form>
    </div>
</div>

<div class="container mt-4 mb-4">
    <h3>DEFICIÊNCIAS</h3>
    <hr>
    <div class="row ms-4">
        <div class="col-md-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Física</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Mental</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Auditiva</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Intelectual</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Visual</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Outra</label>
            </div>
        </div>
    </div>
    <div class="col">
        <hr style="width: 100%; margin-top:25px; padding: 1px !important;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="/conhecimentos"><button class="btn_blue" type="button">Anterior</button></a>
            <button type="submit" id="btn_save" class="btn_blue">Salvar</button>
        </div>
    </div>
</div>
  <FooterView />
</template>
<style scoped>
  
</style>
