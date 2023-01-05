document.addEventListener("DOMContentLoaded",function(){
	var ul_home = document.getElementById("menu-item-151");
	var bg = document.getElementsByClassName("site");
	
	var ul_vita = document.getElementById("menu-item-150");
	//var bg_vita = document.getElementById("background-150");
	
	var ul_hoeren_sehen = document.getElementById("menu-item-45");
	//var bg_hoeren_sehen = document.getElementById("background-45");
	
	var ul_presse = document.getElementById("menu-item-44");
	//var bg_presse = document.getElementById("background-44");
	
	var ul_termin = document.getElementById("menu-item-43");
	//var bg_termin = document.getElementById("background-43");
	
	var ul_repertoire = document.getElementById("menu-item-51");
	//var bg_repertoire = document.getElementById("background-51");
	
	var ul_links = document.getElementById("menu-item-42");
	//var bg_links = document.getElementById("background-42");

	ul_home.addEventListener("mouseover" , mouseOverHome);
	ul_vita.addEventListener("mouseover" , mouseOverVita);
	ul_hoeren_sehen.addEventListener("mouseover" , mouseOverHoerenSehen);
	ul_presse.addEventListener("mouseover" , mouseOverPresse);
	ul_termin.addEventListener("mouseover" , mouseOverTermin);
	ul_repertoire.addEventListener("mouseover" , mouseOverRepertoire);
	ul_links.addEventListener("mouseover" , mouseOverLinks);
	
	ul_home.addEventListener("mouseout" , mouseOutHome);
	ul_vita.addEventListener("mouseout" , mouseOutVita);
	ul_hoeren_sehen.addEventListener("mouseout" , mouseOutHoerenSehen);
	ul_presse.addEventListener("mouseout" , mouseOutPresse);
	ul_termin.addEventListener("mouseout" , mouseOutTermin);
	ul_repertoire.addEventListener("mouseout" , mouseOutRepertoire);
	ul_links.addEventListener("mouseout" , mouseOutLinks);
	
	//var bg = document.getElementsByClassName("background-5");
	var bg_aktuell = "";
	//if (bg[0].style.backgroundImage != ""){
	//	bg_aktuell = bg[0].style.backgroundImage;
	//}
	function mouseOverHome() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2022/03/Sibylla_Duffe_09_2019_020-1-1.jpeg')";
		bg[0].style.backgroundPosition = "0 30%";
		bg[0].style.backgroundSize= "cover";
	}
	
	function mouseOutHome() {
		bg[0].style.backgroundImage = bg_aktuell;
	}
	
	function mouseOverVita() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2017/04/vita.jpg')";
	}
	
	function mouseOutVita() {
		bg[0].style.backgroundImage = bg_aktuell;
	}
	
	function mouseOverHoerenSehen() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2022/03/Sibylla_Duffe_09_2019_114.jpeg')";
		bg[0].style.backgroundPosition = "0 22%";
		bg[0].style.backgroundSize= "cover";
	}
	
	function mouseOutHoerenSehen() {
		bg[0].style.backgroundImage = bg_aktuell;
	}

	function mouseOverPresse() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2022/03/Sibylla_Duffe_09_2019_055-1.jpeg')";
		bg[0].style.backgroundSize= "cover";
		bg[0].style.backgroundPosition = "0 10%";
	}
	
	function mouseOutPresse() {
		bg[0].style.backgroundImage = bg_aktuell;
	}
	function mouseOverTermin() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2017/04/termine.jpg')";
	}
	
	function mouseOutTermin() {
		bg[0].style.backgroundImage = bg_aktuell;
	}

	function mouseOverRepertoire() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2022/04/Sibylla_Duffe_09_2019_012-1sw-cropped.jpg')";
		bg[0].style.backgroundPosition = "0 30%";
		bg[0].style.backgroundSize= "cover";
	}
	
	function mouseOutRepertoire() {
		bg[0].style.backgroundImage = bg_aktuell;
	}
	
	function mouseOverLinks() {
		bg[0].style.backgroundImage = "url('/wp-content/uploads/2022/03/Sibylla_Duffe_09_2019_092sw.jpeg')";
		bg[0].style.backgroundPosition = "0 24%";
		bg[0].style.backgroundSize= "cover";
	}
	
	function mouseOutLinks() {
		bg[0].style.backgroundImage = bg_aktuell;
	}
}, false);