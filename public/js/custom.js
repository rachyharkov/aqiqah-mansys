function loadButton(elem, is_send=true, text){
	if (is_send) {
		var html = '&nbsp;'
		html += '<div class="spinner-border text-white mr-2 align-self-center loader-sm" style="width: 1rem; height: 1rem;">'
		html += '</div>'
		$(elem).attr('disabled', true).text('Loading...').append(html)
		return
	}
	$(elem).attr('disabled', false).text(text)
	$('.spinner-border text-white mr-2 align-self-center loader-sm').remove()
}