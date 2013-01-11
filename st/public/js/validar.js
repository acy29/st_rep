jQuery(document).ready(function($) {
  
	//***cliente
	function pintar_tag(){
		$("#cliente").after("<a href='#'>Buscar Cliente</a>");
		$("#cliente").after("<br>");
	}

	$.ajax({
		  type: "POST",
		  url: "cliente.php",
		  data: { name: "John", location: "Boston" }
		}).done(function( msg ) {
		  alert( "Data Saved: " + msg );
	});

});