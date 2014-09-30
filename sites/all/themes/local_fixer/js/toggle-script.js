$(document).ready(function(){
	
	$('#toggle_btn').click (function(){
		var $that=$(this);
		$('#drop_menu').slideToggle(500,function(){
		});
	});
	
	$('#toggle_btn_left').click (function(){
		var $that=$(this);
		$('#drop_menu_left').slideToggle(500,function(){
			$that.prev('.right-te_left').text($(this).is(':visible') ? 'CLOSE' : 'MENU');
		});
	});
	
	$('.slide').hover(
	  		function(){
				$(this).children('.bx-caption').stop();
				$(this).children('.bx-caption').fadeIn('slow');	
			},
			function(){
				$(this).children('.bx-caption').fadeOut('slow');
			}
	  );
		
});
