<?php

#We used the superglobal $_GET here
if (!($_GET['name'] && $_GET['email'] && $_GET['whoami'] && $_GET['subject'] && $_GET['message']) || !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL))
{
      
      #with the header() function, no output can come before it.
      #echo "Please make sure you've filled in all required information.";
      
      $query_string = $_SERVER['QUERY_STRING'];
      #add a flag called "error" to tell contact_form.php that something needs to be fixed
      $url = "http://".$_SERVER['HTTP_HOST']."/contact_formLesson10v5.php?".$query_string."&error=1";
      header("Location: ".$url);
      exit();      
      } 
      
//This function generates a strong password of N length containing at least one lower case letter,
//one uppercase letter, one digit, and one special character.  The reamining characters
//in the password are chosen at random from those four sets.
//
//The available characters in each set are user friendly - there are no ambiguous
//characters such as i, l, 1, 0, O, etc.  This, coupled with the $add_dashes option,
//makes it much easier for users to manually type or speak their passwords.
//
//Note: the $add_dashes option will increase the length of the password by
//floor(sqrt(N)) characters.

function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
 
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
 
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
 
	$password = str_shuffle($password);
 
	if(!$add_dashes)
		return $password;
 
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

//This function generates a random string that I can use as a username for the new Member's initial login.

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//uses the extract() function to extract the form elements and turn them into PHP variables
extract($_GET, EXTR_PREFIX_SAME, "get");


#construct email message
$email_message = "Name: ".$name."
     User Name: ".generateRandomString()."
     Password: ".generateStrongPassword()."
     Email: ".$email."
     Type of Request: ".$whoami."
     Subject: ".$subject."
     Message: ".$message."
     How you heard about us: ".$found;
          
#construct the email headers
$to = $_GET['email'];  //for testing purposes, this should be MY email address 
$from = "nlinzau@gmail.com";
$email_subject = $_GET['subject'];

#now mail
mail($to, $email_subject, $email_message, "From: ".$from) ?>

<h3>Thank you for your interest!</h3>
Welcome to the Wizarding World of Harry Potter Fansite.<br/><br/>
 
Your submittal is being processed and you should receive an email confirmation shortly.

Here is a copy of the other information you have provided: <br/><br/>
<?php
//provides a summary of the information given from the contact form
echo "Member Name: ".$name."<br/>";
echo "Email: ".$email."<br/>";
echo "Type of Request: ".$whoami."<br/>";
echo "Subject: ".$subject."<br/>";
echo "Message: ".$message."<br/>";
echo "How you heard about us: ".$found."<br/>";


//this for loop dynamically constructs the name of our "update#" form elements
//the values of these elements are accessed through the variables created with extract()
for ($i = 1; $i <= 2; $i++) {
   $element_name = "update".$i;
   echo $element_name.": ";
   echo $$element_name;
   echo "<br/>";
   }


?>


