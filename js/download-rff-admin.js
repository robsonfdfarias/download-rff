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

    $("#cadCategDownRff").on('click', function(e){
        e.preventDefault();
        $('#centroDownRffCadCateg').show("slow");
    })
    $('#downRffCloseCadCateg').on('click', function(e){
        e.preventDefault();
        $('#centroDownRffCadCateg').hide(400);
    })


    $('.edit').on('click', function(e){
        e.preventDefault();
        // alert('dfndsçjnd')
        console.log(this.parentNode)
        var td = this.parentNode;
        var tr = td.parentNode;
        var id = tr.children[0];
        var orderItems = tr.children[1];
        var titulo = tr.children[2];
        var doc = tr.children[3].children[0]; //Usar o elemento todo
        var urlPage = tr.children[5].children[0]; //Usar o value
        var startDate = tr.children[5].children[1]; //Usar o value
        var endDate = tr.children[5].children[2]; //Usar o value
        var tags = tr.children[5].children[3]; //Usar o value
        var statusItem = tr.children[5].children[4]; //Usar o value
        var itemCategory = tr.children[5].children[5]; //Usar o value

        $('#itemId').val(id.innerHTML);
        $('#itemTitleEdit').val(titulo.innerHTML);
        $('#itemUrlPageEdit').val(urlPage.value);
        $('#urlFileEdit').val(doc.getAttribute('href'));
        $('#itemFile').html(doc.cloneNode(true));
        $('#itemStartDateEdit').val(startDate.value);
        $('#itemEndDateEdit').val(endDate.value);
        var opStatus = $('<option selected></option>').val(statusItem.value).text('-> '+statusItem.value);
        $('#itemStatusItemEdit').prepend(opStatus);
        var opCateg = $('<option selected></option>').val(itemCategory.getAttribute('name')).text('-> '+itemCategory.value);
        $('#itemCategoryEdit').prepend(opCateg);
        $('#itemTagsEdit').val(tags.value);
        $('#itemOrderItemsEdit').val(orderItems.innerHTML);
        $('#centroDownRffEdit').show("slow");
    })
    $('#downRffCloseEdit').on('click', function(){
        $('#centroDownRffEdit').hide(400);
    })

    $('#down_rff_img_info').on('click', function(){
        window.open('https://www.youtube.com/@RobsonFarias-os2di', '_blank');
    });
});
