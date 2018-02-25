 /* custom JS here */
function responheight() {
	var hfoot = $(window).height();
	var hheader=$('.header').outerHeight();
	var hfooter = $('.footer').outerHeight();
	$('.page').css({marginBottom:-hfooter});	
	$('.mainpage').css({paddingBottom:hfooter+80});	
	
}
$("input[placeholder]").focusin(function () {
    $(this).data('place-holder-text', $(this).attr('placeholder')).attr('placeholder', '');
	})
	.focusout(function () {
		$(this).attr('placeholder', $(this).data('place-holder-text'));
	});
$('.btn-nav').each(function() {
		$(this).click(function(event){
			event.preventDefault();
			$(this).next().slideToggle();
			$(this).toggleClass('open-nav');			
		});
});
$(window).load(function() {
	responheight();
});

$(window).resize(function(){
	responheight();
});
