function getXmlHttp() {
	var xmlhttp;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function lwp_post(Page, Query, IdToInsert) {
	var xmlhttp = getXmlHttp();
	xmlhttp.open('POST', Page, true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(Query);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			if(xmlhttp.status == 200) {
				document.getElementById(IdToInsert).innerHTML = xmlhttp.responseText;
			}
		}
	};
}
function lwp_cur_range() {
	var CD = new Date();
	var range = CD.getDate()+"."+(CD.getMonth()+1)+"."+CD.getFullYear()+' - '+CD.getDate()+"."+(CD.getMonth()+1)+"."+CD.getFullYear();
	return range;
}