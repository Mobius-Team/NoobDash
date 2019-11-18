<!DOCTYPE HTML>  
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="/css/boring.css">
	<style>
	</style>
	</head>
	<body>
	<div><a href='/'>Back</a></div>
	
<?php
	session_start();
	
	if ( isset( $_SESSION['user_id'] ) ) {
		echo '<div class="top-right">Welcome, <a href="/account">' . $_SESSION['user_name'] . '</a>&nbsp;&nbsp;&nbsp;
			<a href="includes/logout.php">Logout</a>
		</div>';
	}
	else {
		echo '<div class="top-right"><a href="/create">Create Account</a>&nbsp;&nbsp;&nbsp;
			<a href="/login">Login</a></div>';
	}
?>
	
	<div id="main-pane">
		<h3 align="center">Example TOS</h3>
		<div style="left: 10%; width: 80%; position: absolute;">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse urna sapien, tristique sit amet dolor ac, viverra auctor neque. Sed et tellus vestibulum, tincidunt nisi quis, ultrices sapien. Vivamus vel vehicula nulla, ac fermentum augue. Nunc dictum in tellus ac tristique. Maecenas viverra sagittis viverra. Sed semper libero eu tellus euismod placerat. Aenean condimentum, nisi eget finibus tempor, nisl velit pretium arcu, aliquet faucibus sapien sapien id est. Nam rutrum risus metus, sed luctus purus mattis a. Quisque iaculis elit at molestie tincidunt. Sed quis dignissim quam. Nunc at urna placerat, fringilla sapien at, dictum urna. Sed finibus pharetra eros eu interdum. Donec id posuere leo.
<br><br>
Vestibulum sagittis dolor sit amet est tempus, vitae suscipit tortor accumsan. Aenean ultrices leo at nisi pulvinar ornare. Mauris turpis nisl, viverra vel vestibulum eu, iaculis eget nisi. Sed aliquet ante nec lacinia lacinia. Nullam urna turpis, malesuada sed suscipit sit amet, ullamcorper eu turpis. Phasellus et nibh eget augue sodales vestibulum ut sed felis. Proin et erat rhoncus, feugiat leo id, posuere diam. Nullam non aliquet mauris. Nam et lorem libero. Maecenas non nisi consequat, aliquet velit mattis, tincidunt tortor.
<br><br>
Proin euismod est porttitor mi aliquet, at iaculis odio consectetur. Aenean fringilla enim sed convallis congue. Donec sagittis at urna vel volutpat. Donec lacus magna, feugiat eu laoreet ut, interdum nec turpis. Nam ullamcorper euismod enim, eu rhoncus eros dignissim ac. Morbi tempor feugiat mauris eget mollis. Phasellus pharetra, metus ut aliquet semper, felis velit tincidunt turpis, at efficitur ante eros in felis. Pellentesque sagittis laoreet lacus.
<br><br>
Donec varius lacus id elit molestie dignissim. Donec porttitor luctus mattis. Praesent non elementum lectus. Fusce non metus ipsum. Etiam eu tempus quam. Cras interdum mollis est, in egestas diam dignissim ac. Donec in lacus mauris. In hac habitasse platea dictumst. Vestibulum vitae ligula viverra nisl porta tempor non sit amet purus. Aliquam euismod malesuada tempus. Nam sit amet sem eget quam lacinia sodales. Nullam rutrum tempor leo, vel laoreet ipsum vehicula sed. Curabitur laoreet quam vel mi fermentum, suscipit aliquet dui vehicula.
<br><br>
Nunc tempor non lorem ac egestas. Cras scelerisque condimentum eros, non aliquet dui luctus a. Donec ullamcorper felis nec nunc dapibus, nec mollis ligula viverra. Praesent a ullamcorper nibh, vel luctus ipsum. Quisque volutpat vestibulum lorem, id convallis libero porta a. Sed vel mi sapien. Curabitur gravida libero non justo pharetra tempus. Cras hendrerit commodo leo, eu sodales sapien maximus non. Cras tincidunt quam non odio scelerisque euismod. Maecenas et sagittis elit. Praesent pellentesque nisl sit amet ultrices euismod. Aenean ornare euismod consectetur. Pellentesque finibus malesuada aliquam. Pellentesque at lectus imperdiet odio feugiat semper nec quis mauris.
<br><br>
		</div>
	</div>
	</body>
	<footer class="footer"><div class="bottom-right"><a href="https://github.com/Mobius-Team/">Mobius Team GitHub</a></div></footer>
</html>