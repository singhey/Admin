$(function(){
	$('.delete').click(function(e){
		e.preventDefault();
		if(confirm("Do you wish to delete?")){
			window.location.href = $(this).attr('href');
		}
	});
});