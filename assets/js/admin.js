$(function(){
	/*function setCharAt(str,index,chr) {
	 	if(index > str.length-1) return str;
		return str.substr(0,index) + chr + str.substr(index+1);
	}*/
	$('#page').change(function(){
		var link = window.location.href;
		var _link = link.split('=');
		var l = '';
		for(var i = 0; i< _link.length-1;i++){
			l=l+_link[i]+'=';
		}
		//console.log(l);
		l+=$(this).val();
		//console.log($(this).val());
		//console.log(l);
		window.location = l;
	});
});