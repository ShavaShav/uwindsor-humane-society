<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Adopt Animals',
	array('css/nav.css', 'css/adopt.css'),
	array('js/wishlist.js'));
	
html5_nav();

// setting session variables
if (!isset($_SESSION['wishlist'])){
    $_SESSION['wishlist'] = []; // set to null array if not set yet
}

?>	

<div id="contentWrapper">
    
    <div id="filterSearchWishlistBox">
        
        <div class="whiteBox">
                <div id="searchBox">
                <h2 class="title">Search Animals</h2>
                <!-- ajax here for the autosuggest -->
                <form>
                    By Name:
                    <input type="text" name="name" id="name"> 
                    <input type="submit" value="Search">
                </form>
                <!-- use ajax to change this "autoSuggestion".innerHTML to an animal name, unless we can come up with a way to drop down multiple selections? -->
                <p id="autoSuggestion">Type for suggestion!</p>
            </div>
        </div>
        <!-- end of search box -->
        
        <div class="whiteBox">
            <div id="filterBox">
                <h2 class="title">Filters</h2>
            <!-- AJAX idea: autosuggest pet names when they search!
                will use the same form handler as the filter, but get specific animals -->
                <form>
                    <div class="filterOption">
                        Species:
                        <select name="species" id="species">
                          <option value="all" selected>All</option>
                          <option value="dog">Dog</option>
                          <option value="cat">Cat</option>
                          <option value="rabbit">Rabbit</option>
                          <option value="smallMammal">Small Mammal</option>
                          <option value="reptile">Reptile</option>
                          <option value="bird">Bird</option>
                        </select>
                    </div>
                    <div class="filterOption">
                        Min Age: <input type="text" name="minAge" id="minAge" value="0" size="3">
                        Max Age: <input type="text" name="maxAge" id="maxAge" value="100" size="3">
                    </div>
                    <div class="filterOption">
                        <!-- can select one, or both genders. (not a group) -->
                        Gender: <br>
                            <input type="checkbox" name="male" id="male" value="male" selected> Male <br>
                            <input type="checkbox" name="female" id="female" value="female" selected> Female
                    </div>
                    <div class="filterOption">
                        Altered: <br>
                            <input type="checkbox" name="altered" id="altered" value="altered" selected> Yes <br>
                            <input type="checkbox" name="unaltered" id="unaltered" value="unaltered" selected> No
                    </div>
                    <div class="filterOption">
                        Size:
                        <select name="size" id="size">
                          <option value="all" selected>All</option>
                          <option value="small">Small</option>
                          <option value="meedium">Medium</option>
                          <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="filterOption">
                        Primary Color: 
                        <select name="primaryColor" id="primaryColor">
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
                    <div class="filterOption">
                        Secondary Color: 
                        <select name="secondaryColor" id="secondaryColor">
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
                    <input type="submit" value="Filter">
                </form>
            </div>
        </div> 
        <!-- end of filters -->
        
        <div class="whiteBox" style="height:100%"> <!-- must override white box to stretch wishlist -->
            <div id="wishlistBox">
                <h2 class="title">Wish List</h2>
                <!-- check cookie, show the count of animals -->
                <div id="wishlistCount">
                    <p id="wishListCount" onclick="showWishlist();"><?php echo count($_SESSION['wishlist']);?> Animal on your Wishlist</p>
                </div>
                <div id="wishlistPopulation">
                    <?php
                        // check cookie to see if user already has animals, display count
                        if($_SESSION['wishlist']) {
                            for($i = 0; $i < count($_SESSION['wishlist']); $i++) {
                                $animal_val = explode("+",$_SESSION['wishlist'][$i]);
                    ?>
                            <div class='wishlistAnimals'>
                            <img src='<?php echo $animal_val[2];?>'>
                            <p><?php echo $animal_val[0];?></p>
                            <p><?php echo $animal_val[1];?></p>
                            <input type='button' value='Remove Animal' onclick='removeAnimal("<?php echo $_SESSION['wishlist'][$i];?>");'>
                           </div>
                    <?php
                            } // end for loop
                        } else { 
                            // no session history
                            echo "<p>Drop Animals Here!</p>";
                        }
                    ?>
                </div>
            </div>
        </div> 
         <!-- end of wishlist -->
    </div>
    <!-- end of search/filter/wishlist column -->

    <!-- Animals go here -->
    <div class="whiteBox">
        <h1 class="title">Animals Available for Adoption</h1> <br>
        <div id="animalBox">
            <!-- these are just test animals! will pull from DB later -->
            <?php
                // show first 15 animals
                for ($i = 1; $i <= 15; $i++){
                    echo <<<ZZEOF
                    <div class="animal" id="$i">
                        <img src="img/animals/$i.jpg">
                        <p>Name: <span id="animalName_$i">Unknown</span></p>
                        <p>Species: <span id="animalSpecies_$i">Unknown</span></p>
                        <p>Age: <span id="animalAge_$i">Unknown</span></p>
                        <p>Gender: <span id="animalGender_$i">Unknown</span></p>
                        <p>Species: <span id="animalSpecies_$i">Unknown</span></p>
                        <p>Altered: <span id="animalAltered_$i">Unknown</span></p>
                        <p>Size: <span id="animalSize_$i">Unknown</span></p>
                        <p>Primary Color: <span id="animalPrimaryColor_$i">Unknown</span></p>
                        <p>Secondary Color: <span id="animalSecondaryColor_$i">Unknown</span></p>
                    </div>
ZZEOF;
                }
            ?>
        </div>
    </div>
    <!-- end of animalBox -->
</div>
<!-- end of contentWrapper -->
	
<?php
html5_footer();
?>