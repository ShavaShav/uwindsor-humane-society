<?php
require_once('lib/common.php');

html5_prolog(
  'University of Windsor Humane Society',
  array('background.css', 'buttons.css'),
  array(),
);

?>
	<background></background>
			
		<div class="buttons">
			<div id="About" style="cursor:pointer;" 
			onclick="document.location='About.html'"> 
				<div><p>About Us</p></div>
			</div>
			
			
			<div id="Animals" style="cursor:pointer;" 
			onclick="document.location='AdoptAnimal.php'">
				<div><p>Adopt Animals</p></div>
			</div>
			
			<div id="Surrender" style="cursor:pointer;" 
			onclick="document.location='SurrenderAnimals.php'">
				<div><p>Surrender Animals</p></div>
			</div>
			
			<div id="Cruelty" style="cursor:pointer;" 
			onclick="document.location='Cruelty.php'">
				<div><p>Report Cruelty</p><div>
			</div>
	
		</div>

<?php
html5_epilogue();
?>