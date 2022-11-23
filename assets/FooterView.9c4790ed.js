import{o as s,c as e,d as t,e as n,b as h}from"./index.081daa3a.js";jQuery(document).ready(function(){jQuery("*").click(function(o){var c=jQuery(o.target);if(c.attr("id")!="iconAcount"&&(c=jQuery(o.target).closest("#iconAcount")),c.length!=0)return jQuery(".containerMiniMenu").toggleClass("d-none"),0;jQuery(".containerMiniMenu").hasClass("d-none")||jQuery(".containerMiniMenu").addClass("d-none")})});const _="/assets/images/logo.svg",a=(o,c)=>{const i=o.__vccOpts||o;for(const[r,l]of c)i[r]=l;return i},C={name:"HeaderComponent",props:{title:{type:String,required:!0}},mounted(){$("title").html(this.title)}},u={id:"divHeader"},p={class:"containerHeader"},v={class:"row"},f={class:"col-lg-12"},g=t("a",{href:"/",class:"p-0 m-0"},[t("img",{src:_,alt:"",style:{width:"100px",height:"100px"}})],-1),x=t("a",{href:"/",class:"p-0 m-0 text-decoration-none"},[t("h1",{class:"text-white"},"Curiculo Online")],-1),w={class:"main-nav m-0 p-0"},m={class:"desktop"},M={href:"/vagas/",class:"p-0 m-0"},y={class:"hover-opacity text-white bg-transparent border-0 d-flex d-flex flex-wrap justify-content-ceter text-center p-3"},H={class:"w-100",style:{height:"110px"}},z={style:{height:"75px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 640 512"},V=t("path",{d:"M0 155.2C0 147.9 2.153 140.8 6.188 134.7L81.75 21.37C90.65 8.021 105.6 0 121.7 0H518.3C534.4 0 549.3 8.021 558.2 21.37L633.8 134.7C637.8 140.8 640 147.9 640 155.2C640 175.5 623.5 192 603.2 192H36.84C16.5 192 .0003 175.5 .0003 155.2H0zM64 224H128V384H320V224H384V464C384 490.5 362.5 512 336 512H112C85.49 512 64 490.5 64 464V224zM512 224H576V480C576 497.7 561.7 512 544 512C526.3 512 512 497.7 512 480V224z"},null,-1),L=[V],b=t("div",{class:"w-100 textHeader"},"Vagas",-1),j={class:"desktop"},B={href:"/suas_vagas/",class:"p-0 m-0"},k={class:"hover-opacity text-white bg-transparent border-0 d-flex d-flex flex-wrap justify-content-ceter text-center p-3"},I={class:"w-100",style:{height:"110px"}},Q={style:{height:"75px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512"},S=t("path",{d:"M352 128C352 198.7 294.7 256 224 256C153.3 256 96 198.7 96 128C96 57.31 153.3 0 224 0C294.7 0 352 57.31 352 128zM209.1 359.2L176 304H272L238.9 359.2L272.2 483.1L311.7 321.9C388.9 333.9 448 400.7 448 481.3C448 498.2 434.2 512 417.3 512H30.72C13.75 512 0 498.2 0 481.3C0 400.7 59.09 333.9 136.3 321.9L175.8 483.1L209.1 359.2z"},null,-1),F=[S],A=t("div",{class:"w-100 textHeader"},"Suas vagas",-1),N={class:"desktop"},E={href:"/curriculum/",class:"p-0 m-0"},O={class:"hover-opacity text-white bg-transparent border-0 d-flex d-flex flex-wrap justify-content-ceter text-center p-3"},q={class:"w-100",style:{height:"110px"}},T={style:{height:"75px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 384 512"},D=t("path",{d:"M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"},null,-1),G=[D],J=t("div",{class:"w-100 textHeader"},"Seu Curr\xEDculo",-1),K=t("li",null,[t("button",{id:"iconAcount",class:"hover-opacity text-white bg-transparent border-0 d-flex d-flex flex-wrap justify-content-ceter text-center p-3"},[t("i",{class:"far fa-user-circle",style:{"font-size":"75px"}})])],-1),P={class:"containerMiniMenu d-none"},R={class:"row"},U={class:"col"},W={class:"miniMenu"},X={class:"miniMenuInner mobile",href:"/vagas/"},Y={style:{height:"25px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 640 512"},Z=t("path",{d:"M0 155.2C0 147.9 2.153 140.8 6.188 134.7L81.75 21.37C90.65 8.021 105.6 0 121.7 0H518.3C534.4 0 549.3 8.021 558.2 21.37L633.8 134.7C637.8 140.8 640 147.9 640 155.2C640 175.5 623.5 192 603.2 192H36.84C16.5 192 .0003 175.5 .0003 155.2H0zM64 224H128V384H320V224H384V464C384 490.5 362.5 512 336 512H112C85.49 512 64 490.5 64 464V224zM512 224H576V480C576 497.7 561.7 512 544 512C526.3 512 512 497.7 512 480V224z"},null,-1),t2=[Z],s2=n(" Vagas "),e2={class:"miniMenuInner mobile",href:"/suas_vagas/"},o2={style:{height:"25px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512"},c2=t("path",{d:"M352 128C352 198.7 294.7 256 224 256C153.3 256 96 198.7 96 128C96 57.31 153.3 0 224 0C294.7 0 352 57.31 352 128zM209.1 359.2L176 304H272L238.9 359.2L272.2 483.1L311.7 321.9C388.9 333.9 448 400.7 448 481.3C448 498.2 434.2 512 417.3 512H30.72C13.75 512 0 498.2 0 481.3C0 400.7 59.09 333.9 136.3 321.9L175.8 483.1L209.1 359.2z"},null,-1),n2=[c2],i2=n(" Suas vagas "),r2={class:"miniMenuInner mobile",href:"/curriculum/"},l2={style:{height:"25px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 384 512"},a2=t("path",{d:"M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"},null,-1),d2=[a2],h2=n(" Seu Curr\xEDculo "),_2={class:"miniMenuInner",href:"/login/"},C2={style:{height:"25px",width:"25px"},fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"},u2=t("path",{d:"M256.1 246c-13.25 0-23.1 10.75-23.1 23.1c1.125 72.25-8.124 141.9-27.75 211.5C201.7 491.3 206.6 512 227.5 512c10.5 0 20.12-6.875 23.12-17.5c13.5-47.87 30.1-125.4 29.5-224.5C280.1 256.8 269.4 246 256.1 246zM255.2 164.3C193.1 164.1 151.2 211.3 152.1 265.4c.75 47.87-3.75 95.87-13.37 142.5c-2.75 12.1 5.624 25.62 18.62 28.37c12.1 2.625 25.62-5.625 28.37-18.62c10.37-50.12 15.12-101.6 14.37-152.1C199.7 238.6 219.1 212.1 254.5 212.3c31.37 .5 57.24 25.37 57.62 55.5c.8749 47.1-2.75 96.25-10.62 143.5c-2.125 12.1 6.749 25.37 19.87 27.62c19.87 3.25 26.75-15.12 27.5-19.87c8.249-49.1 12.12-101.1 11.25-151.1C359.2 211.1 312.2 165.1 255.2 164.3zM144.6 144.5C134.2 136.1 119.2 137.6 110.7 147.9C85.25 179.4 71.38 219.3 72 259.9c.6249 37.62-2.375 75.37-8.999 112.1c-2.375 12.1 6.249 25.5 19.25 27.87c20.12 3.5 27.12-14.87 27.1-19.37c7.124-39.87 10.5-80.62 9.749-121.4C119.6 229.3 129.2 201.3 147.1 178.3C156.4 167.9 154.9 152.9 144.6 144.5zM253.1 82.14C238.6 81.77 223.1 83.52 208.2 87.14c-12.87 2.1-20.87 15.1-17.87 28.87c3.125 12.87 15.1 20.75 28.1 17.75C230.4 131.3 241.7 130 253.4 130.1c75.37 1.125 137.6 61.5 138.9 134.6c.5 37.87-1.375 75.1-5.624 113.6c-1.5 13.12 7.999 24.1 21.12 26.5c16.75 1.1 25.5-11.87 26.5-21.12c4.625-39.75 6.624-79.75 5.999-119.7C438.6 165.3 355.1 83.64 253.1 82.14zM506.1 203.6c-2.875-12.1-15.51-21.25-28.63-18.38c-12.1 2.875-21.12 15.75-18.25 28.62c4.75 21.5 4.875 37.5 4.75 61.62c-.1249 13.25 10.5 24.12 23.75 24.25c13.12 0 24.12-10.62 24.25-23.87C512.1 253.8 512.3 231.8 506.1 203.6zM465.1 112.9c-48.75-69.37-128.4-111.7-213.3-112.9c-69.74-.875-134.2 24.84-182.2 72.96c-46.37 46.37-71.34 108-70.34 173.6l-.125 21.5C-.3651 281.4 10.01 292.4 23.26 292.8C23.51 292.9 23.76 292.9 24.01 292.9c12.1 0 23.62-10.37 23.1-23.37l.125-23.62C47.38 193.4 67.25 144 104.4 106.9c38.87-38.75 91.37-59.62 147.7-58.87c69.37 .1 134.7 35.62 174.6 92.37c7.624 10.87 22.5 13.5 33.37 5.875C470.1 138.6 473.6 123.8 465.1 112.9z"},null,-1),p2=[u2],v2=n(" Entrar "),f2=t("a",{class:"miniMenuInner",href:"/print_curriculum/"},[t("i",{class:"fas fa-file-pdf"}),n(" Imprimir Curriculo")],-1),g2=t("a",{class:"miniMenuInner",href:"/logout/"},[t("i",{class:"fas fa-sign-out-alt"}),n(" Sair ")],-1);function x2(o,c,i,r,l,d){return s(),e("div",u,[t("div",p,[t("div",v,[t("div",f,[t("header",null,[g,x,t("nav",null,[t("ul",w,[t("li",m,[t("a",M,[t("button",y,[t("div",H,[(s(),e("svg",z,L))]),b])])]),t("li",j,[t("a",B,[t("button",k,[t("div",I,[(s(),e("svg",Q,F))]),A])])]),t("li",N,[t("a",E,[t("button",O,[t("div",q,[(s(),e("svg",T,G))]),J])])]),K])])])])])]),t("div",P,[t("div",R,[t("div",U,[t("div",W,[t("a",X,[(s(),e("svg",Y,t2)),s2]),t("a",e2,[(s(),e("svg",o2,n2)),i2]),t("a",r2,[(s(),e("svg",l2,d2)),h2]),t("a",_2,[(s(),e("svg",C2,p2)),v2]),f2,g2])])])])])}const V2=a(C,[["render",x2]]),w2={name:"FooterComponent"},m2={id:"divFooter"},M2=h('<footer id="footer"><div class="row justify-content-center"><div class="col-lg-6"><div class="toledo"></div></div></div><div class="copyright"> \xA9 2022 - Curiculo.online. </div></footer>',1),y2=[M2];function H2(o,c,i,r,l,d){return s(),e("div",m2,y2)}const L2=a(w2,[["render",H2]]);export{L2 as F,V2 as H,a as _};
