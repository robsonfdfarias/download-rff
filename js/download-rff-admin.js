jQuery(document).ready(function($){
    "use strict";
    $('#cadItemDownRff').on('click', function(e){
        e.preventDefault();
        // alert('kldbvldakbvadkh')
        $('#centroDownRff').show("slow");
    })
    $('#downRffClose').on('click', function(){
        $('#centroDownRff').hide(400);
    })


    $('.edit').on('click', function(e){
        e.preventDefault();
        console.log(this.parentNode)
        var pai = this.parentNode;
        var titulo = pai.children[1];
        var itemUrlPage = pai.children[3];
        var itemUrlDoc = pai.children[5];
        var startDate = pai.children[8];
        var endDate = pai.children[9];
        var itemStatusItem = pai.children[10];
        var itemCategory = pai.children[12];
        var itemTags = pai.children[13];
        var titulo = pai.children[1];
        console.log(startDate.value)
        // alert($('#itemTitle').val())
        // alert(document.getElementById('itemTitle').value)
        $('#itemTitleEdit').val(titulo.value);
        $('#itemUrlPageEdit').val(itemUrlPage.value);
        $('#itemStartDateEdit').val(startDate.value);
        $('#itemEndDateEdit').val(endDate.value);
        $('#itemStatusItemEdit').val(itemStatusItem.value);
        $('#urlFileEdit').val(itemUrlDoc.value);
        $('#itemTitleEdit').val(titulo.value);
        $('#itemTitleEdit').val(titulo.value);
        $('#centroDownRffEdit').show("slow");
    })
    $('#downRffCloseEdit').on('click', function(){
        $('#centroDownRffEdit').hide(400);
    })
});

// var oo = document.getElementById('edit');
// var pp = oo.parentNode;
// console.log(pp.child)