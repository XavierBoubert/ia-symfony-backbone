<?php
	define('IN_IA', true);
	require_once dirname(__FILE__).'/engine/engine.php';

	db_connect();

	$contentCount = mysql_result(db_query('SELECT COUNT(id) FROM sentences'), 0, 0);

	db_close();

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR" xmlns:og="http://ogp.me/ns#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Xavier Boubert http://xavierboubert.fr" />
	<title>I.A. (by Xavier Boubert)</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700" />
	<link rel="stylesheet" type="text/css" href="engine/css/index.css" />

	<script type="text/javascript">
		window.IA = {
			avatar: 'http://robohash.org/set_set1/<?php echo rand (1, 500); ?>?size=60x60',
			userAvatar: 'engine/img/unknown.jpg'
		};
	</script>
</head>
<body>

	<div id="chatmessage" class="chatmessage">
		<h1 class="chat-title">CHAT AVEC I.A. <div>Phrases acquises : <span id="contentCount"><?php echo $contentCount; ?></span></div></h1>

		<div id="chatmessagecontainer">
			<div id="chatmessageinner"></div>
		</div>

		<div id="sendBox" class="messagebox">
			<button id="sendButton" class="btn btn-primary send">Envoyer</button>
			<span class="inputbox">
				<input type="text" id="msgbox" name="msgbox" class="input-block-level" />
			</span>
			<div class="clearfix"></div>
		</div>
	</div>

	<script id="message" type="text/html">
		<p>
			<div class="background-avatar">
				<img src="{{ avatar }}" alt="{{ name }}" class="img-polaroid" />
			</div>
			<span class="msgblock">
				<strong>{{ name }}</strong> <span class="time">- {{ time }}</span>
				<span class="msg">{{ text }}</span>
			</span>
		</p>
	</script>

	<script type="text/javascript" src="engine/js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="engine/js/tpl.js"></script>
	<script type="text/javascript" src="engine/js/ia.js"></script>
</body>
</html>