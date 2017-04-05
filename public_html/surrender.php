<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once($TEMPLATES_PATH . '/common.php');

html5_header(
  'Surrender Animal',
  array('css/root.css', 'css/surrender.css', 'css/dropzone.css'),
  array());

html5_nav();
?>
    
<?php
	if (is_logged_in()) {
?>
       
<div class="contentborder">
    <h2>Surrender Animal</h2>
     <form action="resources/lib/surrender_handler.php" method="post" id="surrenderForm" enctype="multipart/form-data">
     	<div class="formContent">
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
            </select> 
          </div>
        </div>


        <div class="formOption">
            <label>Picture: </label>
            <input type="file" name="animalImage" id="animalImage" accept="image/jpeg">
            <p id='prompt' style='color:red'></p>
        </div>
         
         <script>
             // jquery for this
            $('#animalImage').bind('change', function() {
                if (this.files[0].size > 1000000){ //1MB
                    // display prompt
                    document.getElementById('prompt').innerHTML="Too large! (max 1MB)";
                    // dont save image
                    document.getElementById('animalImage').value=null;
                }
                else // clear prompt
                  document.getElementById('prompt').innerHTML="";

            });
         </script>
         
        <div class="formOption">
            <button type="submit" value="Submit" class="submitButton" id="submitButton">Submit</button>
        </div>
    </form>
    
    
    
    	<?php } else { ?>

		<p id="prompt"> Please log in or visit us in person at visit us at 33 LULZ Street, Windsor, Ontario to surrender your pet </p>
		
	<?php
	}
?>
  
</div>
<?php
html5_footer();
?>