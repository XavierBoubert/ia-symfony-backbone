<?php
	define('IN_IA', true);
	require_once dirname(__FILE__).'/engine/engine.php';

	define('API_VERSION', '1.0.0');

	db_connect();

	$action = '';
	if(isset($_GET['action'])) {
		$action = $_GET['action'];
	}
	else if(isset($_POST['action'])) {
		$action = $_POST['action'];
	}

	$result = array('success' => true);

	switch($action) {
		case 'talk':

			$text = '';
			if(isset($_POST['text'])) {
				$text = utf8_decode(trim(strip_tags($_POST['text'])));
			}
			$previous = '';
			if(isset($_POST['previous'])) {
				$previous = utf8_decode(trim(strip_tags($_POST['previous'])));
			}

			if($text == '') {
				$result['success'] = false;
				$result['error'] = 'Aucun texte envoyé';
				break;
			}

			$result['response'] = '';
			$responseExists = false;

			$query = db_query('SELECT id, sentence, links FROM sentences WHERE LOWER(sentence)=LOWER(\''.addslashes($text).'\')');
			if($row = mysql_fetch_assoc($query)) {
				$responseExists = true;
				$links = json_decode($row['links']);

				if(count($links->ids) > 0) {

					$values = array();
					for($i = 0; $i < count($links->ids); $i++) {
						$id = $links->ids[$i];
						for($j = 0; $j < (int) $id[1]; $j++) {
							$values []= (int) $id[0];
						}
					}

					$id = $values[array_rand($values)];

					$query = db_query('SELECT sentence FROM sentences WHERE id='.$id);
					if($row = mysql_fetch_assoc($query)) {
						$result['response'] = utf8_encode($row['sentence']);
					}
				}
			}

			if($result['response'] == '') {
				if(!$responseExists) {
					db_query('INSERT INTO sentences (sentence, links) VALUES (\''.addslashes($text).'\', \'{"ids":[]}\')');
				}

				$query = db_query('SELECT sentence FROM sentences ORDER BY RAND() LIMIT 1');
				if($row = mysql_fetch_assoc($query)) {
					$result['response'] = utf8_encode($row['sentence']);
				}
			}

			if($previous !== '') {

				$query = db_query('SELECT id FROM sentences WHERE LOWER(sentence)=LOWER(\''.addslashes($text).'\')');
				if($row = mysql_fetch_assoc($query)) {
					$textId = (int) $row['id'];

					$query = db_query('SELECT id, links FROM sentences WHERE LOWER(sentence)=LOWER(\''.addslashes($previous).'\')');
					if($row = mysql_fetch_assoc($query)) {

						$links = json_decode($row['links']);

						$idExists = false;
						for($i = 0; $i < count($links->ids); $i++) {
							$id = $links->ids[$i];
							if((int) $id[0] == $textId) {
								$links->ids[$i][1]++;
								$idExists = true;
								break;
							}
						}

						if(!$idExists) {
							$links->ids []= array($textId, 1);
						}

						$links = json_encode($links);

						db_query('UPDATE sentences SET links=\''.$links.'\' WHERE id='.$row['id']);
					}
				}
			}

			$result['count'] = $contentCount = mysql_result(db_query('SELECT COUNT(id) FROM sentences'), 0, 0);

			break;

		default:

			$result['name'] = 'I.A. (par xavier Boubert)';
			$result['version'] = API_VERSION;

			break;

	}

	echo json_encode($result);

	db_close();