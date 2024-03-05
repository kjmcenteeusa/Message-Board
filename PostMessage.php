<!-- Message Board Exercise -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post A Message</title>
</head>
<body>
	<?php  
		// Check to see if the page has been loaded based on
		// submitting the form.
		if(isset($_POST["submit"])) {
			$Subject = stripslashes($_POST["subject"]);

			$Name = stripslashes($_POST["name"]);

			$Message = stripslashes($_POST["message"]);
			// Replace any '~' characters with '-' characters.
			
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);

			$ExistingSubjects = array();

			// Check to see that the file both exists and has // at least one message before continuing.

			if((file_exists("messages.txt") === TRUE) && (filesize("messages.txt") > 0)) {
				$MessageArray = file("messages.txt");
				$count = count($MessageArray);

				// Loop through each old message and extract // only the subject.

				for($i = 0; $i < $count; ++$i) {
					$CurrMsg = explode("~", $MessageArray[$i]);
					$ExistingSubjects[] = $CurrMsg[0];

				} // End of FOR loop.

			} // End of message check IF statement.

			// Check the new subject against the
			// $ExistingSubjects array.

			if(in_array($Subject, $ExistingSubjects) === TRUE) {
				echo "<p>The subject you entered already exists!<br/>Please enter a new subject and try again.</p>";

				echo "<p>Your message was not saved!</p>";

				$Subject = "";
			} else {

				// Combine all three input variables into a
				// single string.

				$MessageRecord = "$Subject~$Name~$Message\n";
				$MessageFile = fopen("messages.txt", "a");

				// Check to see if the file can't be created.

				if($MessageFile === FALSE) {
					echo "<p>There was an error saving your message!</p>";
				} else {
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "<p>Your message has been saved!</p>";
					$Subject = "";
					$Message = "";

				} // End of IF/ELSE statement.

			} // End of duplicate subject IF statement.

		} // End of IF statement.

		else {
			$Subject = "";
			$Name = "";
			$Message = "";
		}
	?>

	<h1>Post New Message</h1>
	<hr/>
	<form action="PostMessage.php" method="post">
		<label style="font-weight: bold;" for="subject">Subject:</label>

		<input type="text" name="subject" id="subject" value="<?php echo $Subject; ?>" />

		<label style="font-weight: bold;" for="name">Name:</label>

		<input type="text" name="name" id="name" value="<?php echo $Name; ?>" />

		<br/>
		<br/>
		<textarea name="message" rows="6" cols="80"><?php echo $Message; ?></textarea>
		<br/>
		<br/>

		<input type="submit" name="submit" value="Post Message" />

		<input type="reset" name="reset" value="Reset Form" />
	</form>
	<hr/>
	<p><a href="MessageBoard.php">View Messages</a></p>
</body>
</html>



