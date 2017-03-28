window.addEventListener("load", init);

// on window load
function init(){
    // add animalSearch handler
    document.getElementById("animalSearchButton").addEventListener("click", animalSearchHandler);
}

// handler for search button
function animalSearchHandler(){
    /* stop form from submitting normally */
    event.preventDefault(); 

    /* get the filter options from the page for POST */
    var param = 'name='+document.getElementById("name").value;
    	
    // AJAX -> ask server (filter_handler.php) to grab animals from db
    var xhttp = new XMLHttpRequest(); // make http request obj
    	
    // When response received, this is called
    xhttp.onreadystatechange = function(){
    // if request finished, and everything OK
    if (this.readyState == 4 && this.status == 200){
    		// place content returned from fitler_handler in animalBox
    		document.getElementById("animalBox").innerHTML=this.responseText;
        		}
    	}

    /* Send the data and write the results to the animal box */
    xhttp.open("POST", "resources/lib/animalSearch_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(param); 
    // send request to store_wishlist
}