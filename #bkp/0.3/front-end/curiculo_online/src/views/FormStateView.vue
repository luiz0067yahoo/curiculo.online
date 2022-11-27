<script>
    import HeaderView from './inner/HeaderView.vue'
    import FooterView from './inner/FooterView.vue'

    import axios from "axios"
    import Inputmask from "inputmask"    
    import until from '../until/until.js'


    export default {
        components:{
            HeaderView,FooterView
        },
        name: 'FormUserComponent',
        data () {
            return {
                url:"https://curiculo.online/server/estados",
                state:"new",
                errorMsg: "",
                successMsg: "",
                infoMsg: "",
                modalDelete: null,
                elements: [],
                elementCurrent: { id: "", nome: "", sigla: ""},
            }
        },
		mounted: function() {
			this.getAllelements();
			Inputmask().mask(document.querySelectorAll("input"));
            this.modalDelete=new bootstrap.Modal(document.getElementById('modalDelete'));
		},
		methods: {
			async getAllelements() {
                let elements=this.elements;
                let errorMsg=this.errorMsg;
				await axios.get(
                    this.url,
                    {},
                    {
                        mode: 'no-cors',
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    }
                ).then(function(response) {
					if (response.data.error) {
						this.errorMsg = response.data.message;
                        console.log(this.errorMsg);
					} else {
                        elements = until.ArrayObjUtf8Tounicode(response.data.elements);
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
			},
			async findElements() {
			    this.state="find";
                let elements=this.elements;
                let errorMsg=this.errorMsg;
				await axios.get(
                    this.url+"?"+(new URLSearchParams(this.elementCurrent)).toString(),
                    {},
                    {
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    }
                ).then(function(response) {
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						elements = until.ArrayObjUtf8Tounicode(response.data.elements);
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
			},
			async findbyField(field){
			    this.state="find";
                let elements=this.elements;
                let errorMsg=this.errorMsg;
				await axios.get(
                    this.url+"?"+(new URLSearchParams(field)).toString(),
                    {},
                    {
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    },
                ).then(function(response) {
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						elements = until.ArrayObjUtf8Tounicode(response.data.elements);
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
			},
			async findID() {
			    this.state="find";
                let elements=this.elements;
                let errorMsg=this.errorMsg;
                let successMsg=this.successMsg;
                let elementCurrent=this.elementCurrent;

                await axios.get(
                    this.url+"/"+elementCurrent.id,
                    {},
                    {
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    }
                ).then(function(response) {
					elementCurrent = {};
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						successMsg = response.data.message;
						elements = until.ArrayObjUtf8Tounicode(response.data.elements);
						elementCurrent = elements[0];
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
                this.successMsg=successMsg;
                this.elementCurrent=elementCurrent;
			},
			async saveElement() {
			    this.state="edit";
			    var formData = until.toFormData(this.elementCurrent);
			    if (/^\+?(0|[1-9]\d*)$/.test(this.elementCurrent.id)){
			        await this.updateElement();
			    }
			    else{
			        await this.createElement();
			    }
			},
			async updateElement() {
			    this.state="edit";
			    var obj={ ...this.elementCurrent };
			    delete obj.id;
				var formData = until.toFormData(obj);
                let elements=this.elements;
                let errorMsg=this.errorMsg;
                let successMsg=this.successMsg;
                let elementCurrent=this.elementCurrent
				await axios.put(
                    this.url+"/"+elementCurrent.id, 
                    formData,
                    {
                        mode: 'no-cors',
                        headers: {
                            //"Access-Control-Allow-Origin": "*",
                            //"Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            //"Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    }
                ).then(function(response) {
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						successMsg = response.data.message;
						elements = until.ArrayObjUtf8Tounicode(response.data.elements);
						elementCurrent =elements[0];
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
                this.successMsg=successMsg;
                this.elementCurrent=elementCurrent;

			},
			async createElement() {
			    this.state="edit";
				var formData = until.toFormData(this.elementCurrent);
                let elements=this.elements;
                let errorMsg=this.errorMsg;
                let successMsg=this.successMsg;
                let elementCurrent=this.elementCurrent;
				await axios.post(
                    this.url, 
                    formData,
                    {
                        headers: {
                            //"Access-Control-Allow-Origin": "*",
                            //"Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            //"Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        }
                    }
                ).then(function(response) {
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						successMsg = response.data.message;
						elements = until.ArrayObjUtf8Tounicode(response.data.elements);
						elementCurrent = elements[0];
					}
				});
                this.elements=elements;
                this.errorMsg=errorMsg;
                this.successMsg=successMsg;
                this.elementCurrent=elementCurrent;
			},
			async deleteElement() {
			    this.state="find";
                let elementCurrent=this.elementCurrent;
                let elements=this.elements;
                let errorMsg=this.errorMsg;
                let successMsg=this.successMsg;
                let getAllelements=this.getAllelements;
				await axios.delete(
                    this.url+"/"+elementCurrent.id,
                    {},
                    {
                        mode: 'no-cors',
                        headers: {
                            //"Access-Control-Allow-Origin": "*",
                            //"Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
                            //"Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token",
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Content-Type': 'application/json;charset=UTF-8',
                        },
                        withCredentials: true,
                        credentials: 'same-origin',
                    }
                ).then(function(response) {
					elementCurrent = {};
					if (response.data.error) {
						errorMsg = response.data.message;
					} else {
						successMsg = response.data.message;
						getAllelements();
					}
				}).catch(function (response) {
                        errorMsg = response.data;
                        //return Promise.reject(errorMsg);
                });
                
                this.modalDelete.show();
                this.elements=elements;
                this.errorMsg=errorMsg;
                this.successMsg=successMsg;
			    this.elementCurrent={ id: "", nome: "", sigla: ""};
			},
			edit(element){
			    this.state="edit";
			    this.elementCurrent=element
			},
			confirmDeleteElement(element) {
			    this.elementCurrent=element
                this.modalDelete.show();
			},
			
			
			
			clearMsg() {
				this.errorMsg = "";
				this.successMsg = "";
			},
    		cleanFieldHiddeButtons(){
        		try{
        			for (var i in CKEDITOR.instances) {
        				var editor_html=CKEDITOR.instances[i]
        				editor_html.setData("")
        			}
        		}
        		catch(eeeee){}
    		    this.elementCurrent={  id: "", nome: "", sigla: ""}
                this.modalDelete.hide();
    		},
    		newState(){
    		    this.state="new";
    		    this.cleanFieldHiddeButtons();
    		},
    		cancelState(){
    		    this.state="cancel";
    		    this.cleanFieldHiddeButtons();
    		},
    		close(){
                this.modalDelete.hide();
    		},
    		editState(){
    		    this.state="edit";
    		    this.cleanFieldHiddeButtons();
    		}
		}
    };


</script>
<template>
    <HeaderView title="Curiculo Online - Cadastro de Estados" />
    <div  class="container">
        <div class="modal " id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Excluir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>tem certeza que desja excluir este estado {{elementCurrent.nome}}.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="deleteElement()">Sim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close()">Não</button>
                </div>
                </div>
            </div>
        </div>
        <h1>CADASTRO DE ESTADOS</h1>
        <br>
        <br>
        <div class="row">
            <div class="sm-12">
                <div class="form-row align-items-center">
                    <label class="w-100" >CÓDIGO</label>
						<div class="input-group mb-3">
							<label class="sr-only" for="inlineFormInputGroupcodigo">codigo</label>
							<div class="input-group-prepend">
								<div class="input-group-text h-100">
									<i class="fa fa-key" aria-hidden="true"></i>
								</div>
							</div>
							<input type="number" :disabled="state!='new'" class="form-control" v-model="elementCurrent.id"  placeholder="Código" name="id">
							<div class="input-group-append">								
								<button style="height:38px" name="buscar" type="button" class="btn btn-primary buscarcampo buscarcodigo" v-if="state=='new'" @click="findID(elementCurrent.id)"><i class="fa fa-search" aria-hidden="true"></i></button	>
							</div>
						</div>
						<label class="w-100" >NOME</label>
						<div class="input-group mb-3">
							<label class="sr-only" for="inlineFormInputGroupnome">nome</label>
							<div class="input-group-prepend">
								<div class="input-group-text h-100">
									<i class="fas fa-address-card"></i>
								</div>
							</div>
							<input type="text" :disabled="(state!='new' && state!='edit')" class="form-control" v-model="elementCurrent.nome"  placeholder="Nome do Estado" name="nome">
							<div class="input-group-append">								
								<button style="height:38px" name="buscar" type="button" class="btn btn-primary buscarcampo " v-if="state=='new'" @click="findbyField({'nome':elementCurrent.nome})"><i class="fa fa-search" aria-hidden="true"></i></button	>
							</div>
						</div>
						<label class="w-100" >SIGLA</label>
						<div class="input-group mb-3">
							<label class="sr-only" for="inlineFormInputGroupnome">Sigla</label>
							<div class="input-group-prepend">
								<div class="input-group-text h-100">
									<i class="fa fa-bars" aria-hidden="true"></i>
								</div>
							</div>
							<input type="text" :disabled="(state!='new' && state!='edit')" class="form-control" v-model="elementCurrent.sigla"  placeholder="Sigla do Estado" name="nome">
							<div class="input-group-append">								
								<button style="height:38px" name="buscar" type="button" class="btn btn-primary buscarcampo" v-if="state=='new'" @click="findbyField({'sigla':elementCurrent.sigla})"><i class="fa fa-search" aria-hidden="true"></i></button	>
							</div>
						</div>
					<button name="novo" type="button" class="btn btn-dark novo"  @click="newState()" v-if="(state=='find'||state=='cancel'||state=='edit')"><i class="fa fa-sticky-note" aria-hidden="true"></i> Novo</button>      
					
					<button name="buscar" type="button" class="btn btn-primary buscar" @click="findElements()" v-if="(state=='new')"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
				
					<button name="salvar" type="button" class="btn btn-success salvar" @click="saveElement(); clearMsg();" v-if="(state=='new'||state=='edit')" >
					    <i class="fa fa-save" aria-hidden="true"></i> Salvar
					  </button>    
				
					<button name="editar" type="button" class="btn btn-primary editar" @click="editState()" v-if="false"><i class="fa fa-edit " aria-hidden="true" ></i> Editar</button>
					
					<button name="excluir" type="button" class="btn btn-danger excluir" @click="confirmDeleteElement(elementCurrent)" v-if="(state=='edit')"><i class="fa fa-times" aria-hidden="true" ></i> Excluir</button>
							
					<button name="cancelar" type="button" class="btn btn-danger cancelar" @click="cancelState()" v-if="(state=='new'||state=='edit')"><i class="fa fa-ban " aria-hidden="true"></i> Cancelar</button>
								
						
				</div>
			<br>
			<div class="alert alert-success  d-none" role="alert">{{successMsg}}</div>
			<div class="alert alert-danger  d-none" role="alert">{{errorMsg}}</div>
			<div class="alert alert-info  d-none" role="alert">{{infoMsg}}</div>
			<br>
				<table class="table table-striped resultado_busca">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Sigla</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
                        <tr v-for="element in elements">
                            <td><input type="hidden" name="id" v-model="element.id" >{{element.id}}</td>
							<td>{{element.nome}}</td>
							<td>{{element.sigla}}</td>
                            <td>						
                                <button name="editar" type="button" class="btn btn-primary minieditar  btn-sm" @click="edit(element)">
                                    <i class="fa fa-edit " aria-hidden="true"></i>
                                </button>
                                <button name="excluir" type="button" class="btn btn-danger miniexcluir  btn-sm"  @click="confirmDeleteElement(element)">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <FooterView />
</template>
<style scoped></style>