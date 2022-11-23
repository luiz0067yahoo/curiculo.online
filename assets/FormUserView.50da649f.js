import{_ as T,H as M,F as A}from"./FooterView.19ba57dd.js";import{I as E,u,a as _}from"./until.b06b892c.js";import{r as C,o as a,c as d,a as y,d as e,t as h,w as m,v as p,g as c,F as v,h as k,e as g}from"./index.cb469efe.js";const U={components:{HeaderView:M,FooterView:A},name:"FormUserComponent",data(){return{url:"https://curiculo.online/server/users",state:"new",repeat_password:"",errorMsg:"",errorPhone:"",errorCell_phone:"",successMsg:"",infoMsg:"",modalDelete:null,elements:[],elementCurrent:{id:"",nome:"",login:"",e_mail:"",cell_phone:"",telephone:""}}},mounted:function(){this.getAllelements(),E().mask(document.querySelectorAll("input")),this.modalDelete=new bootstrap.Modal(document.getElementById("modalDelete"))},methods:{setPhone(){var o=$("#phone").val();this.errorPhone=null,u.phoneIsValid(o)?this.elementCurrent.phone=o:this.errorPhone='n\xE3o \xE9 um telefone v\xE1lido exemplo de telefone: "(99) 99999-9999"'},setCellPhone(){var o=$("#cell_phone").val();this.errorCell_phone=null,u.phoneIsValid(o)?this.elementCurrent.cell_phone=o:this.errorCell_phone='n\xE3o \xE9 um celular v\xE1lido exemplo de telefone: "(99) 99999-9999"'},async getAllelements(){let o=this.elements,s=this.errorMsg;await _.get(this.url,{},{mode:"no-cors",headers:{"Access-Control-Allow-Origin":"*","Access-Control-Allow-Methods":"GET, POST, PATCH, PUT, DELETE, OPTIONS","Access-Control-Allow-Headers":"Origin, Content-Type, X-Auth-Token","Content-Type":"application/json;charset=UTF-8"}}).then(function(i){i.data.error?(this.errorMsg=i.data.message,console.log(this.errorMsg)):o=u.ArrayObjUtf8Tounicode(i.data.elements)}),this.elements=o,this.errorMsg=s},async findElements(){this.state="find";let o=this.elements,s=this.errorMsg;await _.get(this.url+"?"+new URLSearchParams(this.elementCurrent).toString(),{},{headers:{"Access-Control-Allow-Origin":"*","Access-Control-Allow-Methods":"GET, POST, PATCH, PUT, DELETE, OPTIONS","Access-Control-Allow-Headers":"Origin, Content-Type, X-Auth-Token","Content-Type":"application/json;charset=UTF-8"}}).then(function(i){i.data.error?s=i.data.message:o=u.ArrayObjUtf8Tounicode(i.data.elements)}),this.elements=o,this.errorMsg=s},async findbyField(o){this.state="find";let s=this.elements,i=this.errorMsg;await _.get(this.url+"?"+new URLSearchParams(o).toString(),{},{headers:{"Access-Control-Allow-Origin":"*","Access-Control-Allow-Methods":"GET, POST, PATCH, PUT, DELETE, OPTIONS","Access-Control-Allow-Headers":"Origin, Content-Type, X-Auth-Token","Content-Type":"application/json;charset=UTF-8"}}).then(function(r){r.data.error?i=r.data.message:s=u.ArrayObjUtf8Tounicode(r.data.elements)}),this.elements=s,this.errorMsg=i},async findID(){this.state="find";let o=this.elements,s=this.errorMsg,i=this.successMsg,r=this.elementCurrent;await _.get(this.url+"/"+r.id,{},{headers:{"Access-Control-Allow-Origin":"*","Access-Control-Allow-Methods":"GET, POST, PATCH, PUT, DELETE, OPTIONS","Access-Control-Allow-Headers":"Origin, Content-Type, X-Auth-Token","Content-Type":"application/json;charset=UTF-8"}}).then(function(t){r={},t.data.error?s=t.data.message:(i=t.data.message,o=u.ArrayObjUtf8Tounicode(t.data.elements),r=o[0],$("#phone").val(r.phone),$("#cell_phone").val(r.cell_phone))}),this.elements=o,this.errorMsg=s,this.successMsg=i,this.elementCurrent=r},async saveElement(){this.state="edit",u.toFormData(this.elementCurrent),/^\+?(0|[1-9]\d*)$/.test(this.elementCurrent.id)?await this.updateElement():await this.createElement()},async updateElement(){this.state="edit";var o={...this.elementCurrent};delete o.id;var s=u.toFormData(o);let i=this.elements,r=this.errorMsg,t=this.successMsg,l=this.elementCurrent;await _.put(this.url+"/"+l.id,s,{mode:"no-cors",headers:{"Content-Type":"application/json;charset=UTF-8"}}).then(function(b){b.data.error?r=b.data.message:(t=b.data.message,i=u.ArrayObjUtf8Tounicode(b.data.elements),l=i[0])}),this.elements=i,this.errorMsg=r,this.successMsg=t,this.elementCurrent=l},async createElement(){this.state="edit";var o=u.toFormData(this.elementCurrent);let s=this.elements,i=this.errorMsg,r=this.successMsg,t=this.elementCurrent;await _.post(this.url,o,{headers:{"Content-Type":"application/json;charset=UTF-8"}}).then(function(l){l.data.error?i=l.data.message:(r=l.data.message,s=u.ArrayObjUtf8Tounicode(l.data.elements),t=s[0])}),this.elements=s,this.errorMsg=i,this.successMsg=r,this.elementCurrent=t},async deleteElement(){this.state="find";let o=this.elementCurrent,s=this.elements,i=this.errorMsg,r=this.successMsg,t=this.getAllelements;await _.delete(this.url+"/"+o.id,{},{mode:"no-cors",headers:{"Content-Type":"application/json;charset=UTF-8"},withCredentials:!0,credentials:"same-origin"}).then(function(l){o={},l.data.error?(i=l.data.message,console.log(l.data)):(r=l.data.message,t())}).catch(function(l){console.log(l),console.log("Show error notification!"),i=l.data}),this.modalDelete.hide(),this.elements=s,this.errorMsg=i,this.successMsg=r,this.elementCurrent={id:"",nome:"",login:"",e_mail:"",cell_phone:"",telephone:""}},edit(o){this.state="edit",this.elementCurrent=o},confirmDeleteElement(o){this.elementCurrent=o,this.modalDelete.show()},clearMsg(){this.errorMsg="",this.successMsg=""},cleanFieldHiddeButtons(){try{for(var o in CKEDITOR.instances){var s=CKEDITOR.instances[o];s.setData("")}}catch{}this.elementCurrent={id:"",nome:"",login:"",e_mail:"",cell_phone:"",telephone:""},this.modalDelete.hide()},newState(){this.state="new",this.cleanFieldHiddeButtons()},cancelState(){this.state="cancel",this.cleanFieldHiddeButtons()},close(){this.modalDelete.hide()},editState(){this.state="edit",this.cleanFieldHiddeButtons()}}},x={class:"container"},O={class:"modal",id:"modalDelete",tabindex:"-1",role:"dialog","aria-labelledby":"modalDeleteLabel","aria-hidden":"true"},F={class:"modal-dialog",role:"document"},D={class:"modal-content"},S={class:"modal-header"},P=e("h5",{class:"modal-title"},"Excluir",-1),V=e("span",{"aria-hidden":"true"},"\xD7",-1),I=[V],H={class:"modal-body"},N={class:"modal-footer"},j=e("h1",null,"CADASTRO DE USU\xC1RIOS",-1),L=e("br",null,null,-1),R=e("br",null,null,-1),B={class:"row"},G={class:"sm-12"},X={class:"form-row align-items-center"},q=e("label",{class:"w-100"},"C\xD3DIGO",-1),K={class:"input-group mb-3"},z=e("label",{class:"sr-only",for:"inlineFormInputGroupcodigo"},"codigo",-1),J=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fa fa-key","aria-hidden":"true"})])],-1),Q=["disabled"],W={class:"input-group-append"},Y=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),Z=[Y],ee=e("label",{class:"w-100"},"LOGIN",-1),te={class:"input-group mb-3"},se=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fa fa-user","aria-hidden":"true"})])],-1),ne=["disabled"],le={class:"input-group-append"},oe=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),ie=[oe],re=e("label",{class:"w-100"},"SENHA",-1),ae={class:"input-group mb-3"},de=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-lock"})])],-1),ce=["disabled"],ue=e("label",{class:"w-100"},"REPETIR SENHA",-1),he={class:"input-group mb-3"},me=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-lock"})])],-1),pe=["disabled"],_e=e("label",{class:"w-100"},"NOME",-1),be={class:"input-group mb-3"},ge=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-address-card","aria-hidden":"true"})])],-1),fe=["disabled"],Ce={class:"input-group-append"},ye=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),ve=[ye],we=e("label",{class:"w-100"},"E-MAIL",-1),Te={class:"input-group mb-3"},Me=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-at","aria-hidden":"true"})])],-1),Ae=["disabled"],Ee={class:"input-group-append"},ke=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),Ue=[ke],xe=e("label",{class:"w-100"},"CELULAR",-1),Oe={class:"input-group mb-3"},Fe=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-mobile"})])],-1),De=["disabled"],Se={class:"input-group-append"},Pe=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),Ve=[Pe],Ie=e("label",{class:"w-100"},"TELEFONE",-1),He={class:"input-group mb-3"},Ne=e("div",{class:"input-group-prepend"},[e("div",{class:"input-group-text h-100"},[e("i",{class:"fas fa-phone-square-alt"})])],-1),je=["disabled"],Le={class:"input-group-append"},Re=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),Be=[Re],Ge=e("i",{class:"fa fa-sticky-note","aria-hidden":"true"},null,-1),Xe=g(" Novo"),qe=[Ge,Xe],Ke=e("i",{class:"fa fa-search","aria-hidden":"true"},null,-1),ze=g(" Buscar"),Je=[Ke,ze],Qe=e("i",{class:"fa fa-save","aria-hidden":"true"},null,-1),We=g(" Salvar "),Ye=[Qe,We],Ze=e("i",{class:"fa fa-times","aria-hidden":"true"},null,-1),$e=g(" Excluir"),et=[Ze,$e],tt=e("i",{class:"fa fa-ban","aria-hidden":"true"},null,-1),st=g(" Cancelar"),nt=[tt,st],lt=e("br",null,null,-1),ot={class:"alert alert-success d-none",role:"alert"},it={class:"alert alert-danger d-none",role:"alert"},rt={class:"alert alert-info d-none",role:"alert"},at=e("br",null,null,-1),dt={class:"table table-striped resultado_busca"},ct=e("thead",null,[e("tr",null,[e("th",null,"C\xF3digo"),e("th",null,"Nome"),e("th",null,"E-mail"),e("th",null,"Celular"),e("th",null,"Telephone"),e("th",null,"A\xE7\xE3o")])],-1),ut=["onUpdate:modelValue"],ht=["onClick"],mt=e("i",{class:"fa fa-edit","aria-hidden":"true"},null,-1),pt=[mt],_t=["onClick"],bt=e("i",{class:"fa fa-times","aria-hidden":"true"},null,-1),gt=[bt];function ft(o,s,i,r,t,l){const b=C("HeaderView"),w=C("FooterView");return a(),d(v,null,[y(b,{title:"Curiculo Online"}),e("div",x,[e("div",O,[e("div",F,[e("div",D,[e("div",S,[P,e("button",{type:"button",class:"close","data-dismiss":"modal","aria-label":"Close",onClick:s[0]||(s[0]=n=>l.close())},I)]),e("div",H,[e("p",null,"tem certeza que desja excluir este Usu\xE1rio "+h(t.elementCurrent.name)+" .",1)]),e("div",N,[e("button",{type:"button",class:"btn btn-primary",onClick:s[1]||(s[1]=n=>l.deleteElement())},"Sim"),e("button",{type:"button",class:"btn btn-secondary","data-dismiss":"modal",onClick:s[2]||(s[2]=n=>l.close())},"N\xE3o")])])])]),j,L,R,e("div",B,[e("div",G,[e("div",X,[q,e("div",K,[z,J,m(e("input",{type:"number",disabled:t.state!="new",class:"form-control","onUpdate:modelValue":s[3]||(s[3]=n=>t.elementCurrent.id=n),placeholder:"C\xF3digo",name:"id"},null,8,Q),[[p,t.elementCurrent.id]]),e("div",W,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo buscarcodigo",onClick:s[4]||(s[4]=n=>l.findID(t.elementCurrent.id))},Z)):c("",!0)])]),ee,e("div",te,[se,m(e("input",{type:"text",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[5]||(s[5]=n=>t.elementCurrent.username=n),placeholder:"Login do Usu\xE1rio",name:"username"},null,8,ne),[[p,t.elementCurrent.username]]),e("div",le,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo",onClick:s[6]||(s[6]=n=>l.findbyField({username:t.elementCurrent.username}))},ie)):c("",!0)])]),re,e("div",ae,[de,m(e("input",{type:"password",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[7]||(s[7]=n=>t.elementCurrent.password=n),placeholder:"Senha do Usu\xE1rio",name:"password"},null,8,ce),[[p,t.elementCurrent.password]])]),ue,e("div",he,[me,m(e("input",{type:"password",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[8]||(s[8]=n=>t.repeat_password=n),placeholder:"Repetir senha do Usu\xE1rio",name:"repeat_password"},null,8,pe),[[p,t.repeat_password]])]),_e,e("div",be,[ge,m(e("input",{type:"text",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[9]||(s[9]=n=>t.elementCurrent.name=n),placeholder:"Nome do Usu\xE1rio",name:"name"},null,8,fe),[[p,t.elementCurrent.name]]),e("div",Ce,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo",onClick:s[10]||(s[10]=n=>l.findbyField({name:t.elementCurrent.name}))},ve)):c("",!0)])]),we,e("div",Te,[Me,m(e("input",{type:"text",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[11]||(s[11]=n=>t.elementCurrent.e_mail=n),placeholder:"E-mail do Usu\xE1rio",name:"e_mail"},null,8,Ae),[[p,t.elementCurrent.e_mail]]),e("div",Ee,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo",onClick:s[12]||(s[12]=n=>l.findbyField({e_mail:t.elementCurrent.e_mail}))},Ue)):c("",!0)])]),xe,e("div",Oe,[Fe,m(e("input",{id:"cell_phone",type:"text",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[13]||(s[13]=n=>t.elementCurrent.cell_phone=n),placeholder:"(__) _____-____","data-inputmask":"'mask': '(99) 99999-9999'",onFocusout:s[14]||(s[14]=n=>l.setCellPhone())},null,40,De),[[p,t.elementCurrent.cell_phone]]),e("div",Se,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo",onClick:s[15]||(s[15]=n=>l.findbyField({cell_phone:t.elementCurrent.cell_phone}))},Ve)):c("",!0)])]),Ie,e("div",He,[Ne,m(e("input",{id:"phone",type:"text",disabled:t.state!="new"&&t.state!="edit",class:"form-control","onUpdate:modelValue":s[16]||(s[16]=n=>t.elementCurrent.telephone=n),placeholder:"(__) _____-____","data-inputmask":"'mask': '(99) 99999-9999'",onFocusout:s[17]||(s[17]=n=>l.setPhone())},null,40,je),[[p,t.elementCurrent.telephone]]),e("div",Le,[t.state=="new"?(a(),d("button",{key:0,style:{height:"38px"},name:"buscar",type:"button",class:"btn btn-primary buscarcampo",onClick:s[18]||(s[18]=n=>l.findbyField({telephone:t.elementCurrent.telephone}))},Be)):c("",!0)])]),t.state=="find"||t.state=="cancel"||t.state=="edit"?(a(),d("button",{key:0,name:"novo",type:"button",class:"btn btn-dark novo",onClick:s[19]||(s[19]=n=>l.newState())},qe)):c("",!0),t.state=="new"?(a(),d("button",{key:1,name:"buscar",type:"button",class:"btn btn-primary buscar",onClick:s[20]||(s[20]=n=>l.findElements())},Je)):c("",!0),t.state=="new"||t.state=="edit"?(a(),d("button",{key:2,name:"salvar",type:"button",class:"btn btn-success salvar",onClick:s[21]||(s[21]=n=>{l.saveElement(),l.clearMsg()})},Ye)):c("",!0),c("",!0),t.state=="edit"?(a(),d("button",{key:4,name:"excluir",type:"button",class:"btn btn-danger excluir",onClick:s[23]||(s[23]=n=>l.confirmDeleteElement(t.elementCurrent))},et)):c("",!0),t.state=="new"||t.state=="edit"?(a(),d("button",{key:5,name:"cancelar",type:"button",class:"btn btn-danger cancelar",onClick:s[24]||(s[24]=n=>l.cancelState())},nt)):c("",!0)]),lt,e("div",ot,h(t.successMsg),1),e("div",it,h(t.errorMsg),1),e("div",rt,h(t.infoMsg),1),at,e("table",dt,[ct,e("tbody",null,[(a(!0),d(v,null,k(t.elements,n=>(a(),d("tr",null,[e("td",null,[m(e("input",{type:"hidden",name:"id","onUpdate:modelValue":f=>n.id=f},null,8,ut),[[p,n.id]]),g(h(n.id),1)]),e("td",null,h(n.name),1),e("td",null,h(n.e_mail),1),e("td",null,h(n.cell_phone),1),e("td",null,h(n.telephone),1),e("td",null,[e("button",{name:"editar",type:"button",class:"btn btn-primary minieditar btn-sm",onClick:f=>l.edit(n)},pt,8,ht),e("button",{name:"excluir",type:"button",class:"btn btn-danger miniexcluir btn-sm",onClick:f=>l.confirmDeleteElement(n)},gt,8,_t)])]))),256))])])])])]),y(w)],64)}const wt=T(U,[["render",ft]]);export{wt as default};
