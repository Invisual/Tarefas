

function listarTarefasProcessadas(cliente){
	$('#container-tarefas').empty();
	$('#container-tarefas').append('<input type="checkbox" id="alternar-estado-nao-faturado"><label for="alternar-estado-nao-faturado"> &nbsp; Mostrar Tarefas não Faturadas</label><input type="checkbox" id="alternar-estado-faturado"><label for="alternar-estado-faturado"> &nbsp; Mostrar Tarefas já Faturadas</label><input type="checkbox" id="alternar-estado-avenca"><label for="alternar-estado-avenca"> &nbsp; Mostrar Tarefas em Avença</label>');
	$.ajax({//PRIMEIRO PEDIDO AJAX
		data: {cliente: cliente},
		type:'post',		
		dataType: 'json',	
		url: 'resultadosajax.php',
		success: function(dados){
			for(var i=0;dados.length>i;i++){

				var short_desc = dados[i].descricao.substring(0, 250) + "...";
				var selected1 = '';
				var selected2 = '';
				var selected3 = '';
				var class_faturacao = '';
				var iconfaturacao = '';

				if(dados[i].faturada == 0){selected1 = 'selected'; selected2 =''; selected3 =''; class_faturacao = 'nao-faturado'; iconfaturacao = '<i class="fa fa-times times-faturacao icon-faturacao"></i>';}
				else if(dados[i].faturada == 1){selected1 = ''; selected2 ='selected'; selected3 =''; class_faturacao = 'faturado'; iconfaturacao = '<i class="fa fa-check check-faturacao icon-faturacao"></i>';}
				else if(dados[i].faturada == 2){selected1 = ''; selected2 =''; selected3 ='selected';  class_faturacao = 'avenca'; iconfaturacao = '<i class="fa fa-edit acordo-faturacao icon-faturacao"></i>';}
				

				$('#container-tarefas').append(
					'<div class="row row-list '+ class_faturacao +' " style="margin: 5vh auto;"> <a href = "listar_tarefa.php?id='
					+dados[i].id_tarefa+'"><div class="col-md-1"> <h5><strong>Cliente</strong> <br><br>'
					+dados[i].nome+'</h5></div><div class="col-md-2"> <h5><strong>Título</strong><br><br>'
					+dados[i].titulo+'</h5></div><div class="col-md-3"> <h5><strong>Descrição</strong> <br><br>'
					+short_desc+'</h5></div><div class="col-md-2"><h5><strong>Horas</strong><br><br><a href="#" onclick="verHoras('+dados[i].id_tarefa+')">Ver Horas</a></h5></div></a><div class="col-md-2"> <h5><strong>Faturação</strong> <br><br><form method="POST" action=""><select class="form-control" name="faturacao" required><option '
					+selected1+'  value="0">Não faturada</option><option '
					+selected2+'  value="1">Faturada</option><option '
					+selected3+'  value="2">Avença</option></select><br><button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none;"><i class="fa fa-check" aria-hidden="true"></i></button><input type="hidden" name="tarefaid" value="'+dados[i].id_tarefa+'"></form></div><div class="col-md-2">'+ iconfaturacao +'</div></div>');
			}

		}
	});

}



function verHoras(idtarefa){
	$.__horastotais = '';
	$.ajax({//SEGUNDO PEDIDO AJAX
		type: "post",
		dataType: 'json',
		url: "horasajax.php",
		data: {tarefa: idtarefa},
		success: function (data) {
			if(data[0].horastotais == null){
				$.__horastotais = 'Esta tarefa não tem horas.';
			}					
			else{
				var horas = data[0].horastotais.substring(0, 2);
				var minutos = data[0].horastotais.substring(3, 6);
			$.__horastotais = 'Esta tarefa tem '+horas+ 'h:'+minutos+'m';//É ESTA VARIAVEL QUE PRECISAVA DE PASSAR PARA O APEND EM BAIXO
			}
			window.alert($.__horastotais); //NESTE CONSOLE.LOG CONSIGO VER O VALOR QUE EU QUERIA IR BUSCAR
			
		}
	});
}




