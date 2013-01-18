	$(function() {

		//***al darle clic a un campo con #cliente pinto el dialog
		var id = $('#cliente'); 
		$("#cliente").click(function() {

			//***remuevo la tabla para pintarla otra vez
			$( "#clientesxcedula" ).remove()

			//*** creo el div que se convertira el el diag
			$('body').append("<div id='clientesxcedula'title='Buscar Clientes'>"
									+"<label>Introduzca la cedula</label>"
			   	 					+"<input onkeyup='buscarclientesxcedula()' type='text' placeholder='Introduzca la cedula' id='buscarcliente' value=''/><br></div>"
			   	 					);

			//*** creo la ventana de dialog
			$( "#clientesxcedula" ).dialog({
											width: 400,
											maxHeight: 1000,
											"position": { my: "right top", at: "right top" }
										});

		});
	});

	//***al escribir un cedula en el dialog busco en BD
	function buscarclientesxcedula() { 
		var id2 = $('#buscarcliente'); 
		
		//***solo tragigo los clientes al darle enter cod=13
		var evento = window.event;
		if (evento.keyCode == 13) {
			//***remuevo la tabla anterior
			$( "#clientesxcedula div" ).remove()
			$( "#clientesxcedula h3" ).remove()

			$.get("../cliente/buscar/clientexcedula", { cedula: id2.val() },
			  function(data){
			  	if(data !=""){

			  		//***data es una tabla que convertire en jquery data table
			  		$( "#clientesxcedula" ).append(data);

					 $.extend( $.fn.dataTable.defaults, {
					        "bFilter": false,
					        "bSort": false
					    } );

			  		$( "#clientesxcedula table" ).dataTable({
				       "oLanguage": {
				            "sLengthMenu": "Mostrando _MENU_ clientes por pagina",
				            "sZeroRecords": "Nothing found - sorry",
				            "sInfo": "Mostrando _START_ de _END_ de _TOTAL_ clientes",
				            "sInfoEmpty": "Mostrando 0 de 0 de 0 clientes",
				            "sInfoFiltered": "(filtered from _MAX_ total records)"
				        }
					});

			  	$(".tabla_cliente").button({
			  		icons: { primary: "ui-icon ui-icon-circle-plus" }});

			  	}else
			  		$( "#clientesxcedula" ).append("<h3>No hay clientes con esta ci</h3>")

			  });
		}

	}

	//***cuando presiono agregar en la tabla copio el tr en el campo cliente
	function agregarcliente(i){
		 var tractual = $( "#clientesxcedula table tr")[i];
		 $("#cliente").val(tractual.children[1].innerText);
		 identificarcliente();
		 $( "#clientesxcedula" ).dialog( "destroy" );
	}

	//***pinto el nombre y apellido del cliente dado la cedula
	
	function identificarcliente() { 
		var id = $('#cliente'); 
		$.get("../cliente/buscar/existecliente", { cedula: id.val() },
		  function(data){
		    $("#cliente2").remove();
		    if(data != "")
		    	$("#cliente").after("<p class='msj_input' id='cliente2'>"+id.val()+" - "+data+"</p>")

		  });
	}
