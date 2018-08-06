$(document).ready(function(){
	var cities = [ "Минск", "Витебск", "Брест", "Гомель", "Гродно", "Могилёв", "минск", "витебск", "брест", "гомель", "гродно", "могилёв" ];
	$('input').on('focus', function(e){
		var $this = $(this);
		if($this.prop('class') != 'bx_input_text' && $('.title-search-result').css('display') == 'block'){
			$('.title-search-result').css('display','none');
		}
	});
	$('.bx_input_text').on('keyup', function(e){
		var $this = $(this);
		var $val  = $this.val();
		if(jQuery.inArray( $val, cities ) !== -1){
			$this.val($val + ' г.');
		};
	});
});