// <?php 
//     require_once(dirname(__FILE__).'/../config.php');
//     
//     // testing the cruelty form
//     //print_r($_POST);
//     
//     
// foreach ($_POST as $key=>$value){
// 
// 	echo $key.": ".$value."<br><br>";
// 	
// 
// }


//?>

<?php 
if(isset($_POST['submit'])){}

	//require_once(dirname(__FILE__).'/../config.php');

    $to = "ficara@uwindsor.ca"; // this is your Email address
    $from = "kim.ficara@gmail.com"; // this is the sender's Email address
    $name = $_POST['name'];
    $phone_number = $_POST['phoneNumber'];
    $personName = $_POST['personName'];
    $personAddress = $_POST['personAddress']; 
    $subject = "Cruelty Form Submission";
    $message = $_POST['incidentText'];

    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);
    
    echo "Mail Sent. Thank you, we will contact you shortly.";
    }
?>