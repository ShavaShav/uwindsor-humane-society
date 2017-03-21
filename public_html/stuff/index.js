function About_click(evt)
{
  window.location = $(this).find("a").attr("href"); 
  return false;
}


function init()
{
	document.getElementById("About").addEventListener("click", About_click);
	document.getElementById("Animals").addEventListener("click", Animals_click);
	document.getElementById("Surrender").addEventListener("click", Surrender_click);
	document.getElementById("Cruelty").addEventListener("click", Cruelty_click);
}

window.addEventListener("load", init);