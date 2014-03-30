<?php 
session_start();
function success()
{
if(!session_is_registered(user_name) && !session_is_registered(number))
{
	return false;
}
else
{	
	return true;
}
/* if($_SESSION["suser"]){
	return true;
} */

}
?>