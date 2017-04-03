<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/database.php');
require_once($TEMPLATES_PATH . '/common.php');

html5_header(
	'Adopt Animals',
	array('css/root.css', 'css/adopt.css'),
	array('js/wishlist.js', 'js/filter.js', 'js/animalSearch.js', 'js/form_check.js'));
	
html5_nav();

// setting session variables
if (!isset($_SESSION['wishlist'])){
    $_SESSION['wishlist'] = []; // set to null array if not set yet
}

?>	

<div id="contentWrapper">
    
    <div id="filterSearchBox" class="sidePanel">
        
        <div class="whiteBox">
                <div id="searchBox">
                <h2 class="title">Search Animals</h2>
                <!-- ajax here for the autosuggest -->
                <form>
                    By Name:
                    <input type="text" name="name" id="name"> 
                    <p id="autoSuggestion">Type for suggestion!</p><br>
                    <input type="submit" value="Search" id="animalSearchButton">
                </form>
                <!-- use ajax to change this "autoSuggestion".innerHTML to an animal name, unless we can come up with a way to drop down multiple selections? -->
            </div>
        </div>
        <!-- end of search box -->
        
        <div class="whiteBox">
            <div id="filterBox">
                <h2 class="title">Filters</h2>
            <!-- AJAX idea: autosuggest pet names when they search!
                will use the same form handler as the filter, but get specific animals -->
                <form id="filter">
                    <div class="formOption">
                        Species:
                        <select name="species" id="species">
                          <option value="all" selected>All</option>
                          <option value="dog">Dog</option>
                          <option value="cat">Cat</option>
                          <option value="rabbit">Rabbit</option>
                          <option value="small_mammal">Small Mammal</option>
                          <option value="reptile">Reptile</option>
                          <option value="bird">Bird</option>
                        </select>
                    </div>
                    <div class="formOption">
                        Min Age: <input type="text" name="min_age" id="min_age" value="0" size="3"> <br>
                        Max Age: <input type="text" name="max_age" id="max_age" value="100" size="3">
                    </div>
                    <div class="formOption">
                        <!-- can select one, or both genders. (not a group) -->
                        Gender: 
                        <select name="gender" id="gender">
                          <option value="all" selected>All</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>

                    </div>
                    <div class="formOption">
                        Altered: 
                        <select name="altered" id="altered">
                          <option value="all" selected>All</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                    </div>
                    <div class="formOption">
                        Size:
                        <select name="size" id="size">
                          <option value="all" selected>All</option>
                          <option value="small">Small</option>
                          <option value="medium">Medium</option>
                          <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="formOption">
                        Primary Color: 
                        <select name="primary_color" id="primary_color">
                            <option value="all" selected>All</option> 
                            <option value="tan">Tan</option>
                            <option value="brown">Brown</option>
                            <option value="black">Black</option>
                            <option value="grey">Grey</option>
                            <option value="white">White</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                            <option value="yellow">Yellow</option>
                            <option value="red">Red</option>
                        </select>
                    </div>
                    <div class="formOption">
                        Secondary Color: 
                        <select name="secondary_color" id="secondary_color">
                            <option value="all" selected>All</option> 
                            <option value="tan">Tan</option>
                            <option value="brown">Brown</option>
                            <option value="black">Black</option>
                            <option value="grey">Grey</option>
                            <option value="white">White</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                            <option value="yellow">Yellow</option>
                            <option value="red">Red</option>
                        </select>
                    </div>
                    <br>
                    <input type="button" value="Filter" id="filterButton">
                </form>
            </div>
        </div> 
        <!-- end of filters -->
        
    </div>
    <!-- end of search/filter column -->

    <!-- Animals go here -->
    <div class="whiteBox">
        <h1 class="title">Animals Available for Adoption</h1> <br>
        <div id="animalBox">
            <!-- to be populated by AJAX request to database on page load! -->
        </div>
    </div>
    <!-- end of animalBox -->
    
    <div class="whiteBox"> <!-- must override white box to stretch wishlist -->
        <div class="sidePanel" id="wishlistBox">
            <h2 class="title">Wish List</h2>
            <!-- check cookie, show the count of animals -->
            <div id="wishlistCount_div">
                <p id="wishlistCount" onclick="showWishlist();"><?php echo count($_SESSION['wishlist']);?> Animal(s) on your Wishlist</p>
            </div>
            <div id="wishlistPopulation">
                <?php
                    // check cookie to see if user already has animals, display count
                    if($_SESSION['wishlist']) {
                        for($i = 0; $i < count($_SESSION['wishlist']); $i++) {
                            $animal_val = explode("+",$_SESSION['wishlist'][$i]);
                ?>
                        <div class='wishlistAnimals'>
                        <img src='<?php echo $animal_val[1];?>'>
                        <p><?php echo $animal_val[0];?></p>
                        <input type='button' value='Remove Animal' onclick='removeAnimal("<?php echo $_SESSION['wishlist'][$i];?>");'>
                        <br>
                
                <?php
                        // adopt button
                        $db = new AnimalDB;
                        $hasRequested = $db->hasRequestedAdoption($_SESSION['logged_in_user'], $animal_val['2']);
                        // only show if they haven't already requested adoption
                        if (is_logged_in() && !$hasRequested){
                            echo '<input type="button" value="Request Adoption" onclick="requestAdoption(\'';
                            echo $_SESSION['wishlist'][$i];
                            echo "')\">";
                        } else if ($hasRequested) {
                            echo '<p>Adoption requested!</p>';
                        }
                        echo "</div>";
                        } // end for loop
                    } else { 
                        // no session history
                        echo "<p style='text-align:center'>Drag Animals Here!</p>";
                    }
                ?>
            </div>
        </div>
    </div> 
     <!-- end of wishlist -->
</div>
<!-- end of contentWrapper -->
	
<?php
html5_footer();
?>