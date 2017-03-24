// initialize the wishlist on page load
window.addEventListener("load", init);
function init() {
    makeAnimalsDraggable();
    // listen for events of animals being dropped in wishlist box
    var wishlist = document.getElementById("wishlistBox");
    wishlist.addEventListener("dragover", animalDragover);
    wishlist.addEventListener("drop", animalDrop);
}

// to be called whenever page updated (to add listeners for new animals)
function makeAnimalsDraggable(){
    var animals = document.getElementsByClassName("animal");
    for (var i = 0; i < animals.length; i++){
        animals[i].addEventListener("dragstart", animalDragstart);
        animals[i].setAttribute("draggable", "true");
    }
}

var currentAnimalID; // to store the current dragging animal's id
var store_wishlist_URL = "resources/lib/store_wishlist.php";

console.log(store_wishlist_URL);

// implementation of the drag and drop to wishlist
function animalDragstart(evt){
    console.log("animalDragStart");
    // set currentAnimalID's to id of source (div id)
    currentAnimalID = evt.target.id || evt.source.id;
    console.log(currentAnimalID);
}

function animalDrop(evt){
    console.log("animalDrop");
    evt.preventDefault();
    // pass currentAnimal to wishlist
    wishlist(currentAnimalID);
} 

function animalDragover(evt){
    console.log("animalDragover"); // could dim the wishlist??
    evt.preventDefault();
}

// to be called when animal dragged into table
function wishlist(id)
{
    var img_src = document.getElementsByTagName("img")[0].src; // get image
    var name = document.getElementById("animalName_"+id).innerHTML; // get name
    console.log(name + " dropped in wishlist.");
    var params = "animal_img=img_src&animal_name=name"; // for POST request 
    
    // this is where the ajax comes into play -> put animal in wishlist table
    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // show count
            document.getElementById("wishlistCount").innerHTML=this.responseText;
            console.log("Response: " + this.responseText);
            // show wishlist
            showWishlist();
        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.send(params); // send request to store_wishlist
}

// removing an animal from wishlist
function removeAnimal(animal_val){
    var params = "remove_animal='remove_animal'&animal_val=animal_val"; // for POST request 

    var xhttp = new XMLHttpRequest(); // make http request obj
    
    // this will be call when response is received
    xhttp.onreadystatechange = function(){
        // if request finished, and everything OK
        if (this.readyState == 4 && this.status == 200){
            // show count
            document.getElementById("wishlistCount").innerHTML=this.responseText;
            console.log("Response: " + this.responseText);
            // show wishlist
            showWishlist();
        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
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
            console.log("Response: " + this.responseText);

        }
    }
    
    xhttp.open("POST", store_wishlist_URL, true);
    xhttp.send(params); // send request to store_wishlist
}