function show_content(element,id,value=''){
	if($(element).val()!=value){
		$(id).show(2000);
	}
	else{
		$(id).hide(1000);	
	}
}

function show_representante(element,id){
	if($(element).val()==='OA' || $(element).val()==='NE'){
		$(id).show(1000);
	}
	else{
		$(id).hide(500);	
	}
}

function habilitar_campo(element,id){
	if($(element).val()!=''){
		$(id).removeAttr('disabled');
	}
	else{
		$(id).attr('disabled',true);	
	}
}

function cargar_municipio(element,id){
	var new_municipio = [];
	$.each(municipio,function(index,value){
		if(value.fk_provincia==$(element).val()){
			new_municipio.push(value);
		}
	});
	$(id).html("");
	$.each(new_municipio,function(index,value){
		$(id).append($('<option>', { 
	        value: value.id,
	        text : value.nombre 
	    }));
	});
}

function radio_value(element,id,value){
	if($(element).find('input[type="radio"]:checked').val()==value){
		$(id).show(2000);
	}
	else{
		$(id).hide(500);
	}
}

function checkbox_abogado(element, id){
	var abogado = $(element).prop('checked');
	if  (abogado){
		$(id).text("3. ¿Tiene experiencia en tribunales o Asistiendo a audiencias?");
	}
	else{
		$(id).text("3. ¿Tiene experiencia consultando?");
	}
}