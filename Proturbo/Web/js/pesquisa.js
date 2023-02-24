$(function() {
    $("#pesquisa").keyup(function(){
        //Pegar o valor do campo
        var pesquisa = $(this).val();

        //Verificar se tem algo digitado
        if(pesquisa != ''){
            var dados = {
                palavra : pesquisa
            }
            $.post('js/proc_pesq_user.php', dados, function(retorna) {
                //Mostrar
                $(".resultado").html(retorna);
            });
        }
    });
});