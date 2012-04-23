/*
 * 
 */
function submit(inputClass,post,action,callback) {
	// raccolta form
	input=$('.'+inputClass+' input:not([type=checkbox],[type=radio])');
	for(var key in input) {
		name=input.eq(key).attr('name');
		post[name]=input.eq(key).val();
	}
	checkbox=$('.'+inputClass+' input[type=checkbox]');
	radio=$('.'+inputClass+' input[type=radio]');
	for(var key in checkbox) {
		name=checkbox.eq(key).attr('name');
		post[name]=checkbox.eq(key).attr('checked');
	}
	for(var key in radio) {
		name=radio.eq(key).attr('name');
		if (radio.eq(key).attr('checked')) post[name]=radio.eq(key).val();
	}
	
	$.ajax({
		url: action,
		type: 'post',
		data: post,
		success:callback
	});
}