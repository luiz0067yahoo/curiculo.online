<script >
    import HeaderView from './inner/HeaderView.vue'
    import FooterView from './inner/FooterView.vue'
    export default {
        components:{
            HeaderView,FooterView
        },
      }
</script>
<template>
  <HeaderView title="Curiculo Online - CONHECIMENTOS" />
  <div class="container mt-4 mb-4">
    <h3>IDIOMAS</h3>
    <hr>
    <p>Informe os idiomas que você tem algum conhecimento e o seu nível de conhecimento.</p>
    <div class="row">
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Idioma</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Informe um Idioma">
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Nível</label>
            <select class="form-select" aria-label="Default select example">
                    <option selected>Qual é o seu nível de fluencia? </option>
                    <option value="1">Básico</option>
                    <option value="2">Intermediário</option>
                    <option value="3">Avançado</option>
                    <option value="4">Fluente</option>
                  </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="btn-group mt-4" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn_blue">Adicionar Idioma</button>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <h3>CONHECIMENTOS</h3>
            <hr>
            <p>Destaque os conhecimentos que você possui, voltados à área que pretende atuar.</p>
            <div class="row">
                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Conhecimento</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Informe um Idioma">
                </div>
                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Nível</label>
                    <select class="form-select" aria-label="Default select example">
                            <option selected>Qual é o nível do seu conhecimento? </option>
                            <option value="1">Básico</option>
                            <option value="2">Intermediário</option>
                            <option value="3">Avançado</option>
                            <option value="4">Fluente</option>
                          </select>
                </div>
                <div class="col-lg-12">
                    <div class="btn-group mt-4" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn_blue">Adicionar Curso</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-6">
            <h3>HABILIDADES</h3>
            <hr>
            <p>Destaque as suas habilidades, o que de melhor você sabe fazer.</p>
            <label for="inputAddress2" class="form-label">Habilidade</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Informe uma habilidade">
        </div>
        <div class="col-lg-12">
            <div class="btn-group mt-4" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn_blue">Adicionar outra habilidade</button>
            </div>
        </div>
        <div class="col">
            <hr style="width: 100%; margin-top:25px; padding: 1px !important;">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/formacao_academica"><button class="btn_blue" type="button">Anterior</button></a>
                <a href="/cargo_pretendido"><button class="btn_blue" type="button">Próximo</button></a>
            </div>
        </div>
    </div>
</div>
  <FooterView />
</template>
<style scoped>
  
</style>
