<?php
require_once('lib/common.php');

//header('Content-Type: text/plain');
//print_r($_POST);

function get_post_var($name)
{
  if (array_key_exists($name, $_POST))
    return $_POST[$name];
  else
    return FALSE;
}

function redirect($relative_url='')
{
  global $BASE_URL;
  header('Location: '.$BASE_URL.'/'.$relative_url);
  exit;
}

//
// Put code below into a function or two later!
//

$login = get_post_var('login');
$passwd = get_post_var('passwd');

if ($login === FALSE || $passwd === FALSE)
{
  log_out_user();
  redirect('login.php'); 
}
else 
{
  if ($login == 'admin' && $passwd == 'qwerty')
  {
    log_in_user($login);
    redirect();
  }
  else
  {
    // Invalid login...
    log_out_user();
    redirect('login.php');
  }
}

?>
