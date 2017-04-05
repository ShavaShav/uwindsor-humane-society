// initialize the wishlist on page load
window.addEventListener("load", init);
function init() {
    // listen for events of animals being dropped in wishlist box
    var wishlist = document.getElementById("wishlistBox");
    wishlist.addEventListener("dragover", animalDragover);
    wishlist.addEventListener("drop", animalDrop);
}

// Animal divs are made draggable by the php that creates the html

var currentAnimalID; // to store the current dragging animal's id
var store_wishlist_URL = "resources/lib/store_wishlist.php";

// implementation of the drag and drop to wishlist
function animalDragstart(id){
    // set currentAnimalID's to id of source (div id)
    currentAnimalID = id;
}

function animalDrop(evt){
    evt.preventDefault();
    // pass currentAnimal to wishlist
    wishlist(currentAnimalID);
} 

function animalDragover(evt){
    evt.preventDefault();
}

// to be called when animal dragged into table
function wishlist(id)
{
    var animalDiv = document.getElementById(id);
    var img_src = encodeURIComponent("../resources/templates/img.php?type=animals&filename=" + id + ".jpg"); // post variables for img script
    var name = document.getElementById("animalName_"+id).innerHTML; 
    console.log(img_src);
    var params = "animal_id="+id+"&animal_img="+img_src+"&animal_name="+name; // for POST request 

    // this is where the ajax comes into play -> put animal in wishlist table
    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200) {
            // update count
            document.getElementById("wishlistCount").innerHTML=this.responseText;
            // show wishlist
            showWishlist();
        }
    }

    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}

// removing an animal from wishlist
function removeAnimal(animal_val){
    
    var params = "remove_animal='remove_animal'&animal_val="+encodeURIComponent(animal_val); // for POST request (+s to spaces)
    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // update count
            document.getElementById("wishlistCount").innerHTML=this.responseText;
            // show wishlist
            showWishlist();
        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}

// requesting adoption of a wishlist animal
function requestAdoption(animal_val){
    var params = "request_adoption='request_adoption'&animal_val='"+encodeURIComponent(animal_val); // for POST request (+s to spaces)
    var xhttp = new XMLHttpRequest(); // make http request obj
        
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // update count
            document.getElementById("wishlistCount").innerHTML=this.responseText;
            // show wishlist (removal of buttons for adopted animal)
            showWishlist();
        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}

// show all animals in database table "wishlist" for user
function showWishlist(){
    var params = "show_wishlist='show_wishlist'"; // for POST request 

    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // show count
            document.getElementById("wishlistPopulation").innerHTML=this.responseText;
        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params); // send request to store_wishlist
}