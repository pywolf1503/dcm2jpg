<!DOCTYPE html>
<html>
<head>
	<title>DCM to JPEG Converter</title>
	<style>
		body {
			background-color: #111;
			color: #eee;
			font-family: Arial, sans-serif;
			font-size: 16px;
			margin: 0;
			padding: 0;
		}

		.container {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		h1 {
			margin-top: 0;
		}

		form {
			background-color: #222;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		input[type=file] {
			margin: 10px 0;
		}

		input[type=submit] {
			background-color: #333;
			color: #eee;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.2s ease-in-out;
		}

		input[type=submit]:hover {
			background-color: #444;
		}

		p {
			margin: 10px 0;
		}

		a {
			color: #00ff00;
			text-decoration: none;
		}

		a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>DCM to JPEG Converter</h1>
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (empty($_FILES["file"]["name"])) {
					echo "<p>No file selected</p>";
				} else {
					$target_dir = "uploads/";
					$target_file = $target_dir . basename($_FILES["file"]["name"]);
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					if ($imageFileType != "dcm") {
						echo "<p>Only DCM files are allowed</p>";
					} else {
						if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
							$output_file = "result.jpg";
							$command = "python main.py " . escapeshellarg($target_file) . " " . escapeshellarg($output_file);
							exec($command, $output, $return_var);
							if ($return_var === 0) {
								echo "<p>Conversion successful. <a href='" . $output_file . "' download>Click here</a> to download the JPEG file.</p>";
							} else {
								echo "<p>An error occurred during the conversion process:</p>";
								foreach ($output as $line) {
									echo "<p>" . $line . "</p>";
								}
							}
						} else {
							echo "<p>Unable to upload file</p>";
						}
					}
				}
			}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			Select a DCM file to convert to JPEG:
			<input type="file" name="file" id="file" value="Upload">
			<input type="submit" value="Convert">
      </form>
</body>
</html>