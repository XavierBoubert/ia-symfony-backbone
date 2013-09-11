<?php
	define('IN_IA', true);
	require_once dirname(__FILE__).'/engine/engine.php';

	db_connect();

	$contentCount = mysql_result(db_query('SELECT COUNT(id) FROM sentences'), 0, 0);

	$sentences = array();
	$query = db_query('SELECT id, sentence, links FROM sentences ORDER BY sentence');
	while($row = mysql_fetch_assoc($query)) {
		$row['responses'] = array();
		$row['sentence'] = utf8_encode($row['sentence']);
		$sentences []= $row;
	}

	for($i = 0; $i < sizeof($sentences); $i++) {
		$links = json_decode($sentences[$i]['links']);
		$ids = $links->ids;

		if(count($ids) > 0) {
			for($j = 0; $j < sizeof($sentences); $j++) {

				for($k = 0; $k < count($ids); $k++) {
					if((int) $ids[$k][0] == (int) $sentences[$j]['id']) {
						$sentences[$i]['responses'] []= $sentences[$j]['sentence'] . ' <span title="Poids de la phrase">('.$ids[$k][1].')</span>';
						break;
					}
				}
			}
		}
	}

	db_close();

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR" xmlns:og="http://ogp.me/ns#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Xavier Boubert http://xavierboubert.fr" />
	<title>I.A. Graph (by Xavier Boubert)</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700" />
	<link rel="stylesheet" type="text/css" href="engine/css/index.css" />
</head>
<body style="overflow: auto;">

	<div id="chatmessage" class="chatmessage">
		<h1 class="chat-title">GRAPH I.A. <div>Phrases acquises : <span id="contentCount"><?php echo $contentCount; ?></span></div></h1>

		<?php for($i = 0; $i < sizeof($sentences); $i++) { ?>

		<div class="graph-item">
			<div class="column-left">
				<div>
					<h3><?php echo $sentences[$i]['sentence']; ?></h3>
				</div>
				<?php if(count($sentences[$i]['responses']) > 0) { ?>
				<div class="column-left-bar"></div>
				<?php } ?>
			</div>
			<div class="column-right">
				<?php for($j = 0; $j < count($sentences[$i]['responses']); $j++) { ?>

				<div class="column-right-response <?php echo $j === 0 ? 'first' : ''; ?>">
					<?php if($j > 0) { ?>
					<div class="column-right-bar"><div></div></div>
					<?php } ?>
					<?php echo $sentences[$i]['responses'][$j]; ?>
				</div>

				<?php } ?>
			</div>

			<div class="clearfix"></div>
		</div>

		<?php } ?>

	</div>
</body>
</html>