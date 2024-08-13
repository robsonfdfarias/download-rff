jQuery(document).ready(function($){
    "use strict";
    $('.down_categ').on('click', function(){
        const obj = this.parentNode;
        const divFile = obj.children[1];
        const simb = this.children[0];
        // $(this).parent().children('.down_files').slideToggle(100);
            // const c = divFile.getBoundingClientRect();
        if(divFile.style.height!='fit-content'){
            divFile.setAttribute('style', 'trasition: all ease 0.8s; height: fit-content;')
        }else{
            divFile.setAttribute('style', 'trasition: all ease 0.8s; height: 0px;')
        }
        if(simb.innerText == '+'){
            simb.innerText = '-';
        }else{
            simb.innerText = '+';
        }

    })
});