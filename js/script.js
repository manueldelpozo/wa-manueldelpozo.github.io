
//Autocomplete
function autocomplet() {
	var min_length = 1; // min caracteres 
	var keyword = $('#buscador').val()
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax_refresh.php',
			type: 'GET',
			data: 'keyword='+keyword,
			success: function( msg ) {
				$('#medicos_list_id').show();
				$('#medicos_list_id').html(msg);
				//$("#buscador").mask( $(".search-option:first").text(), {placeholder:"Y"} );
			} 
		});		
	} else {
		$('#medicos_list_id').hide();
	}
}

//Seleccionador
function set_item(item) {
	$('#buscador').val(item);
	$('#medicos_list_id').hide();	
}

	

