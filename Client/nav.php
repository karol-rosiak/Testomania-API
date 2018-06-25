<nav>

<ul>
  <li><a href="../index.php">Home</a></li>
  <li><a href="../question/question_one.php">One question</a></li>
  <li><a href="../question/question_quiz.php">Test</a></li>

<?php
session_start();

if(isset($_SESSION['Logged'])  && $_SESSION['Rank']=="Administrator")
{
	echo '<li><a href="../adminPanel.php">Admin Panel</a></li>';
}

if(isset($_SESSION['Logged']))
{
	echo " <ul style='float:right;list-style-type:none;'>";
	echo "<li><a href='../user/user_profile.php?user={$_SESSION['Logged']}'>Profile: {$_SESSION['Logged']} </a></li>";
	echo "<li><a href='../user/user_logout.php'>Log out</a></li>";
	echo "</ul>";
}
else
{
		echo " <ul style='float:right;list-style-type:none;'>";
		echo "<li><a href='../user/user_register.php'>Sign in</a></li>";
		echo "<li><a href='../user/user_login.php'>Log in</a></li>";
		echo "</ul>";
}

?>
</ul>


</nav>