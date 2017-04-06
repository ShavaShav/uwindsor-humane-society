window.addEventListener("load", init);

// on window load
function init(){
    
    // get all the requests for both adoptions and surrenders
    reloadPendingAdoptions();
    reloadPendingSurrenders();
}

// option should be a string, like confirm_adoption (see pending_handler.php)
function confirmOrDeny(username, id, option){ 
    /* get the filter options from the page for POST */
    var params = 'option='+option+'&username='+username+'&id='+id;

    // AJAX -> ask server to grab animals from db
    var xhttp = new XMLHttpRequest(); // make http request obj

    // When response received, this is called
    xhttp.onreadystatechange = function(){
    
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // place animals in pending appropriate box 
            if (option.includes("adoption")){
                document.getElementById("pendingAdoptions").innerHTML=this.responseText;
            } else {
               document.getElementById("pendingSurrenders").innerHTML=this.responseText;
            }
        }
    }
    /* Send the data and write the results to pending box */
    xhttp.open("POST", "resources/lib/pending_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}

function reloadPendingAdoptions(){   
    /* get the filter options from the page for POST */
    var params = 'reload_adoptions=TRUE';

    // AJAX -> ask server to grab animals from db
    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // When response received, this is called
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // place animals in pending adoptions box 
            document.getElementById("pendingAdoptions").innerHTML=this.responseText;
        }
    }
    
    /* Send the data and write the results to pending box */
    xhttp.open("POST", "resources/lib/pending_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}

function reloadPendingSurrenders(){   
    /* get the filter options from the page for POST */
    var params = 'reload_surrenders=TRUE';

    // AJAX -> ask server to grab animals from db
    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // When response received, this is called
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // place animals in pending adoptions box 
            document.getElementById("pendingSurrenders").innerHTML=this.responseText;
        }
    }
    
    /* Send the data and write the results to pending box */
    xhttp.open("POST", "resources/lib/pending_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}