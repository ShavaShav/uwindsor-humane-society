<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
  'Surrender Animal',
  array('css/root.css'),
  array());

html5_nav();
?>
  <script src="dropzone.js"></script>
    <link rel="stylesheet" href="dropzone.css">
<div class="contentborder">
        <p class="titleText">Surrender Animal</p>
         <form action="resources/lib/surrender_handler.php" method="post">
             
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
          </form>
      <!-- Shole form be of class dropzone, instead of 2 forms? and submit button will call surrender_handler.php to insert animal into db (surrender_handler.php should also call upload.php to store image I'm thinking.) -->
        <form action="upload.php" class="dropzone"></form>
        <br>
        <input type="submit" value="Submit" class="submitButton">
  
</div>
<?php
html5_footer();
?>