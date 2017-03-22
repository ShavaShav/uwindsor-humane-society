<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_navigation(
	'Adopt Animals',
	array('css/nav.css'),
	array(),
	"is logged in: ".is_logged_in()
);
?>
        <p class="titleText">Surrender Animal</p>
         <form action="/surrender_handler.php" method="post">
             
          <p class="formLabel">Name:</p>
          <input type="text" name="name" id="name" class="textInput"><br>
          <p class="formLabel">Species:</p>
          <input type="radio" name="species" id="species" value="dog" class="textInput"> Dog<br>
          <input type="radio" name="species" id="species" value="cat" class="textInput"> Cat<br>
          <input type="radio" name="species" id="species" value="rabbit" class="textInput"> Rabbit<br>
          <input type="radio" name="species" id="species" value="rabbit" class="textInput"> Bird<br>
          <input type="radio" name="species" id="species" value="rabbit" class="textInput"> Small Mammal<br>
          <input type="radio" name="species" id="species" value="rabbit" class="textInput"> Reptile<br>

          <p class="formLabel">Age:</p>
          <input type="text" name="age" id="age"><br>
            
          <p class="formLabel">Gender:</p>
          <input type="radio" name="gender" id="gender" value="Male"> Male<br>
          <input type="radio" name="gender" id="gender" value="Female"> Female<br>
             
          <p class="formLabel">Spayed/Neutered:</p>
          <input type="radio" name="fertility" name="fertility" value="spayed"> Spayed<br>
          <input type="radio" name="fertility" name="fertility" value="neutured"> Neutured<br>
          <input type="radio" name="fertility" name="fertility" value="no"> Neither<br>
             
          <p class="formLabel">Size:</p>
          <select name="size" id="size">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="large">Large</option>
          </select><br>
             
          <p class="formLabel">Color:</p>
          <input type="text" name="species" id="species" class="textInput"><br> 
             
          <p class="formLabel">Picture:</p>
          <input type="file" name="pic" accept="image/*"><br><br>
          <input type="submit" value="Submit" class="submitButton">
        </form> 
<?php
html5_footer();
?>