<?php

if ($_GET['error'] == "1") {
   $error_code = 1; //this means that there's been a missing info error and we need to notify the customer

} 

else {
  $error_code = 0;
}

?>
<body>
<h3>Harry Potter Fanclub Application</h3>
<?
if ($error_code) {
    echo "<div style='color:red'>Please help us with the following:</div>";
}
?>

<form method="GET" action="PHPLesson10obj1v5.php">
<table>
<tr>
<td align="right">
Name:
</td>
<td align="left">
<input type="text" size="25" name="name" value="<? echo $_GET['name']; ?>" />
<?
if ($error_code && !($_GET['name'])) {
  echo "<b>Please include your name.</b>";
}

?>
</td>
</tr>
<tr>
<td align="right">
Email:
</td><td align="left">
<input type="text" size="25" name="email" value="<? echo htmlspecialchars($_GET['email'],ENT_QUOTES, 'UTF-8'); ?>" />
<?
if ($error_code && !($_GET['email'])) {
  echo "<b>Please include your email address.</b>";
} else {
$email = test_input($_GET['email']);
  //check if email address is well-formed
  if ($error_code && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<b>Invalid email format.</b>";
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
</td>
</tr>
<tr>
<td align="right">
Type of Request:
</td>
<td align="left">
<select name="whoami">
<option value="" />Please choose. . .
<option value="newcustomer"<?
if ($_GET['whoami'] == "newcustomer") {
   echo " selected";
}
?>
/>I am interested in becoming a Member.
<option value="customer"<?
if ($_GET['whoami'] == "customer") {
   echo " selected";
}
?> />I am a Member with a general question.
<option value="support" <?
if ($_GET['whoami'] == "support") {
   echo " selected";
}
?> />I need technical help using the website.
<option value="billing" <?
if ($_GET['whoami'] == "billing") {
   echo " selected";
}
?> />I have a billing question.
</select>
<?
if ($error_code && !($_GET['whoami'])) {
  echo "<b>Please choose a request type.</b>";
}
?>
</td>
</tr>
<tr>
<td align="right">
Subject:
</td>
<td align="left">
<input type="text" size="50" max="50" name="subject" value="<? echo $_GET['subject']; ?>">
<?
if ($error_code && !($_GET['subject'])) {
  echo "<b>Please add a subject for your request.</b>";
}
?>
</td>
</tr>
<tr>
<td align="right" valign="top">
Message:
</td>
<td align="left">
<textarea name="message" cols="50" rows="8">
<? echo $_GET['message']; ?>
</textarea>
<?
if ($error_code && !($_GET['message'])) {
  echo "<b>Please fill in a message for us.</b>";
}
?>
</td>
</tr>
<tr>
<td colspan="2" align="left">
How did you hear about us?
<ul>
<input type="radio" name="found" value="wordofmouth" />Word of Mouth<br/>
<input type="radio" name="found" value="search" />Online Search<br/>
<input type="radio" name="found" value="article" />Printed publication/article<br/>
<input type="radio" name="found" value="website" />Online link/article<br/>
<input type="radio" name="found" value="other" />Other
</ul>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" value="SUBMIT" />
</td></tr>
</table>
</form>
</body>