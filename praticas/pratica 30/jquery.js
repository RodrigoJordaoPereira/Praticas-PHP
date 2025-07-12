// Função que faz com que caixa de id texto 
//assuma valor da opção do select com o id queries
function mostrarVal() {
    $("#texto").val($("#querys option:selected").val());
};

$(document).ready(function () {
    $('#conteudo').fadeOut();  // ocultar a div
    $('#botao').click(function () {  // quando é clicado  
        $('#conteudo').fadeIn();  // mostrar a div e mostrar a consulta

        $('#conteudo').load("main.php", { consulta: $("#texto").val() });
        return false; // em caso de erro, não mostrar nada              
    });
});


