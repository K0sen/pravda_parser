"use strict";

window.onload = function(){
	if (document.querySelector('.preloader')) 
		document.querySelector('.preloader').style.display = 'none';

	if (document.querySelector('.news')) 
		document.querySelector('.news').style.display = 'block';

	if (document.querySelector('.clear_but')) {
		document.querySelector('.clear_but').onclick = function() {
			document.querySelector('.preloader').style.display = 'block';
			document.querySelector('.news').style.display = 'none';
			window.location = "/";
		};
	}

	document.querySelector('.search__form').addEventListener("submit", function(e){
		e.preventDefault();
		var pages = this.querySelector('.amount_field').value;
		if (pages >= 1)
			window.location = "/?pages=" + pages;
		else 
			alert ("wrong number");
	});

};
