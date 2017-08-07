function show_content(element,id,value){
	value = value ? value:'';
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

function calificar_servicio(id_consulta){
	var html = '';
	bootbox.dialog({ 
		message: html, 
		buttons: {
			close: {
				label: 'Cancelar',
				className: "btn-default",
			},
			success: {
				label: 'Calificar',
				className: "btn-primary",
			},
		} 
	});
}

function show_and_require(element,div,find_elmt){
	if(!$(element).prop('checked')){
		$(div).show();
		var field = $(div).find(find_elmt);
		$(field).attr('required',true);
	}
	else{
		$(div).hide();
		var field = $(div).find(find_elmt);
		$(field).removeAttr('required');
	}
}

function show_recomendations(element,id){
	if($(element).prop('checked')){
		$(id).show();
		var parent = $(element).parent().parent().parent().parent().find(id+' input[type="text"]');
		muti_add_required(parent);
		parent = $(element).parent().parent().parent().parent().find(id+' input[type="email"]');
		muti_add_required(parent);
	}
	else{
		$(id).hide();
		var parent = $(element).parent().parent().parent().parent().find(id+' input[type="text"]');
		muti_add_required(parent,false);
		parent = $(element).parent().parent().parent().parent().find(id+' input[type="email"]');
		muti_add_required(parent,false);
		console.log(parent);
	}
}

function muti_add_required(field,add){
	add = add===false ? add:true;
	$.each(field,function(key,value){
		if(add){
			$(value).attr('required',true);
		}
		else{
			$(value).removeAttr('required');
		}
	});
}