/* 
 * Jan Modal Javascript
 * /js/jan_modal.js
*/


var modal = document.getElementById("jan-modal");

var btn = document.getElementById("jan-modal-btn");

var span = document.getElementByClassName("modal-close")[0];

btn.onclick = function() {
	modal.style.display = "block";
}

span.onclick = function() {
	modal.style.display = "none";
}

window.onclick = function(event) {
	if(event.target == modal)
	{
		modal.style.display = "none";
	}
}