<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
  'Surrender Animal',
  array('css/root.css', 'css/surrender.css'),
  array());

html5_nav();
?>
  <script src="dropzone.js"></script>
    <link rel="stylesheet" href="dropzone.css">
    
<?php
	if (is_logged_in()) {
?>
       
<div class="contentborder">
        <h2>Surrender Animal</h2>
         <form action="resources/lib/surrender_handler.php" method="post">
          <div class="formOption"> 
              <label>Name:</label>
              <input type="text" name="name" id="name" class="textInput" required><br>
          </div>
          <div class="formOption"> 
              <label>Species:</label>
                <select name="species" id="species">
                  <option value="dog">Dog</option>
                  <option value="cat">Cat</option>
                  <option value="rabbit">Rabbit</option>
                  <option value="small_mammal">Small Mammal</option>
                  <option value="reptile">Reptile</option>
                  <option value="bird">Bird</option>
                </select><br>
          </div>
             
        <!-- will put this in surrender.js later, updates display of slider value -->
         <script>
            function updateAgeText(val) {
                document.getElementById("age").value = val;
            }
         </script>
             
          <div class="formOption"> <!-- need to keep age slide and display on same line -->
              <label>Age:</label>
              <input type="text" name="age" id="age" value="1" style="width: 3em" readonly>
              <input type="range" name="rangeInput" min="0" max="100" value="1"  oninput="updateAgeText(this.value);" style="width: 200px;">
          </div>  
          <div class="formOption">
              <label>Gender:</label>
              <input type="radio" name="gender" id="gender" value="male" required> Male
              <input type="radio" name="gender" id="gender" value="female"> Female
          </div>
          <div class="formOption">
                <label>Spayed/Neutered:</label>
              <input type="radio" name="altered" name="altered" value="yes" required> Yes
              <input type="radio" name="altered" name="altered" value="no"> No
          </div>
          <div class="formOption">
              <label>Size:</label>
              <select name="size" id="size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
              </select><br>
          </div>
          <div class="formOption">
            <label>Primary Color:</label>
            <select name="primary_color" id="primary_color">
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
              <label>Secondary Color:</label>
              <select name="secondary_color" id="secondary_color">
                <option value="tan">Tan</option>
                <option value="brown">Brown</option>
                <option value="black">Black</option>
                <option value="grey">Grey</option>
                <option value="white">White</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
                <option value="yellow">Yellow</option>
                <option value="red">Red</option>
                <option value="null">None</option>
            </select> <br>
          </div>
        

    <div class="formOption">
        <label>Picture: </label>
        <form action="upload.php" class="dropzone"></form>
        <br>
        <input type="submit" value="Submit" class="submitButton">
    </div>
    </form>
    
    
    
    	<?php } else { ?>

		<p> Please log in or visit us in person at visit us at 33 LULZ Street, Windsor, Ontario to surrender your pet </p>
		
	<?php
	}
?>
  
</div>
<?php
html5_footer();
?>