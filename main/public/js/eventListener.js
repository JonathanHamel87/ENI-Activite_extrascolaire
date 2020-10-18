$(document).ready(function(){

    /* Modification du lieu lors de la création d'une sortie */
    $('#lieu').change(function (){
        let id = $(this).children(":selected").attr("id");
        $.ajax({
        method : 'GET',
        url : '/lieu/recupLieu',
        data : {id: id},
        success: function (result){
            $('#rue').val(result.rue);
            $('#codePostal').val(result.codePostal);
            $('#longitude').val(result.longitude);
            $('#latitude').val(result.latitude);
        }
        });
    });

    /* Modification de la ville lors de la création d'une sortie */
    $('#ville').change(function (){
        let id = $(this).children(":selected").attr("id");
        $.ajax({
            method : 'GET',
            url : '/lieu/recupLieux',
            data : {id: id},
            dataType: "json",
            success: function (lieux){
                var select = $('#lieu');
                select.empty();
                $.each(lieux, function (key, value){
                    console.log(value.id + ' ' +value.nom);
                    select.append($("<option></option>").attr("id", value.id).text(value.nom));
                });

                $.ajax({
                    method : 'GET',
                    url : '/lieu/recupLieu',
                    data : {id: lieux[0].id},
                    success: function (result){
                        $('#rue').val(result.rue);
                        $('#codePostal').val(result.codePostal);
                        $('#longitude').val(result.longitude);
                        $('#latitude').val(result.latitude);
                    }
                });
            }
        });
    });
});