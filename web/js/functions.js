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

String.prototype.splice = function(idx, rem, str) {
    return this.slice(0, idx) + str + this.slice(idx + Math.abs(rem));
};

function render_input_to_cents(field) {
    var value = $('#' + field.id).val().replace(/[^0-9]/g,'');
    if (parseInt(value) == 0 || value == ""){
        return $('#' + field.id).val("0,00");
    }
    if (value < 99 && value > 9)
        value = "0," + parseInt(value);
    else if (value < 99 && value < 9)
        value = "0,0" + parseInt(value);
    else {
        if (value[0] == "0") value = value.slice(1);
        value = value.splice(value.length - 2, 0, ",");
    }
    $('#' + field.id).val(value);
}

function render_text_to_cents(field) {
    var value = field.textContent.replace(/[^0-9]/g,'');
    value = value.splice(value.length - 2, 0, ",");
    field.textContent = value;
}

function line_graphic(container,title,categories,y_axis,data){
	Highcharts.chart(container, {
	    chart: {
	        type: 'line'
	    },
	    title: {
	        text: title
	    },
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle'
	    },
	    tooltip: {
	        valueSuffix: ' $',
	    },
	    xAxis: {
	        categories: categories
	    },
	    yAxis: {
	        title: {
	            text: y_axis
	        }
	    },
	    series: [data]
	});
}

function move_carousel(name,move){
	$(name).carousel(move);
	$(name).carousel('pause');
}

function show_familia(element,id){
	if($(element).val()==='FA'){
		$(id).show(1000);
	}
	else{
		$(id).hide(500);	
	}
}

function agregar_otro_miembro(){
	$('#miembros_familia').append($('#familia_form').html());
}

function remove_element(element){
	var container = $(element).parent().parent();
	$(container).remove();
}

function load_servicios(){
	$.each(servicios,function(key,value){
		$('input[value='+value.id+']').prop('checked',true)
	});
}

function llenar_grupo(valor){
	var init = '<option value>Seleccione el grupo</option>';
	if(valor!=''){
		$('#sendmailsform-email').html("");
		$('#sendmailsform-email').attr('disabled',false);
		$.each($('#sendmailsform-email option'),function(key,value){
			console.log(value);
		})

	}
	else{
		$('#sendmailsform-email').attr('disabled',true);
	}
}