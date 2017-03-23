<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Adopt Animals',
	array('css/nav.css', 'css/adopt.css'),
	array());
	
html5_nav();
?>	
<div class="contentborder">
	<div id="formspace">
		<form id="ourForm">
			<label>Animal:</label>
				<select>
					<option>Dog</option>
					<option>Cat</option>
					<option>Rabbit</option>
					<option>Hamster</option>
				</select>
			<label>Age:</label>
				<select>
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
					<option>11</option>
					<option>12</option>
					<option>13</option>
					<option>14</option>
					<option>15</option>
					<option>16</option>
					<option>17</option>
					<option>18</option>
					<option>19</option>
					<option>20+</option>
				</select>
			<label>Gender:</lavel>
				<select>
					<option>Male</option>
					<option>Female</option>
				</select>
			<label>Spayed/Neutered?</label>
				<select>
					<option>Yes</option>
					<option>No</option>
				</select>
			<label>Size:</label>
				<select>
					<option>Very Small</option>
					<option>Small</option>
					<option>Medium</option>
					<option>Large</option>
					<option>Very Large</option>
				</select>
			<label>Primary Color</label>
				<select>
					<option>Black</option>
					<option>Grey</option>
					<option>Yellow</option>
					<option>White</option>
					<option>Brown</option>
				</select>
			<label>Secondary Color</label>
				<select>
					<option>Black</option>
					<option>Grey</option>
					<option>Yellow</option>
					<option>White</option>
					<option>Brown</option>
				</select>
				
		</form>
	</div>
</div>

<div class="contentborder">
	<div id="resultspace">
	</div>
</div>
	
<?php
html5_footer();
?>
	