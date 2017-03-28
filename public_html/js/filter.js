
window.addEventListener("load", init);

// on window load
function init(){
   document.getElementById("name").value="HELLOWOOW+";
    
    // make request to filter_handler.php with default args -> get all animals
    filterHandler();
    // add filter handler
    
    document.getElementById("filterButton").addEventListener("click", filterHandler);   
}

// handler for filter button
function filterHandler(){
    /* stop form from submitting normally */
    event.preventDefault(); 

    /* get the filter options from the page for POST */
    var params = 'species='+document.getElementById("species").value+
        '&min_age='+document.getElementById("min_age").value+
        '&max_age='+document.getElementById("max_age").value+
        '&gender='+document.getElementById("gender").value+
        '&altered='+document.getElementById("altered").value+
        '&size='+document.getElementById("size").value+
        '&primary_color='+document.getElementById("primary_color").value+
        '&secondary_color='+document.getElementById("secondary_color").value; 

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
    xhttp.open("POST", "resources/lib/filter_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}