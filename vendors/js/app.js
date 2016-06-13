$(document).ready(function(){
    $('textarea').autosize();   

	$('.btn-toggle').click(function() {
		if($(this).find('.btn.active').attr('data-tipo') == 'negativo'){
			$(this).find('.btn.active').removeClass('btn-danger');
		}else{
			$(this).find('.btn.active').removeClass('btn-success');
		}
		$(this).find('.btn.active').addClass('btn-default');
		$(this).find('.btn').toggleClass('active');  

		if($(this).find('.btn.active').attr('data-tipo') == 'positivo'){
			$(this).parent().find('.explicacion .negativo').hide();
			$(this).parent().find('.explicacion .positivo').show();
			$(this).find('.btn.active').addClass('btn-success');
			$('#FallaTipoComentario').attr('value', 0);
			$('.tipofalla').hide();
			$('.tipofalla select').attr('disabled', true);

		}else{
			$(this).parent().find('.explicacion .positivo').hide();
			$(this).parent().find('.explicacion .negativo').show();
			$(this).find('.btn.active').addClass('btn-danger');
			$('#FallaTipoComentario').attr('value', 1);
			$('.tipofalla').show();
			$('.tipofalla select').attr('disabled', false);
		}  
	});
});
