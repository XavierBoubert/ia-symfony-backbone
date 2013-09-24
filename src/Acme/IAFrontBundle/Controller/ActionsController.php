<?php

namespace Acme\IAFrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Acme\IAFrontBundle\Entity\Talk;
use Acme\IAFrontBundle\Entity\Sentence;

class ActionsController extends Controller
{
	protected $name = 'I.A. API';
	protected $author = 'Xavier Boubert';
	protected $lastRevision = '2013-09-22';
	protected $version = '1.0';

	protected $actions = array(
		'/actions/talk' => "[POST] (string) \"text\"\n[POST] (string) \"previous\"\n[RETURN] \"reponse\"\nTalk a new \"text\" to I.A and get its \"response\"."
	);

	protected function result($success, $data)
	{
		if(!$success) {
			$data = array('error' => $data);
		}
		$data['success'] = $success;

		$response = new Response(json_encode($data));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}

	public function indexAction()
	{
		$result = array(
			'api_name' => $this->name,
			'author' => $this->author,
			'last_revision' => $this->lastRevision,
			'version' => $this->version,
			'actions' => $this-> actions
		);

		return $this->result(true, $result);
	}

	public function talkAction(Request $request)
	{
		if(!$request->isMethod('POST')) {
			return $this->result(false, 'This action need to be in POST method');
		}

		$talk = new Talk(
			$request->request->get('text'),
			$request->request->get('previous')
		);

		$validator = $this->get('validator');
		$errorList = $validator->validate($talk);

		if(count($errorList) > 0) {
			return $this->result(false, $errorList[0]->getMessage());
		}

		$response = null;

		$doctrineManager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository('AcmeIAFrontBundle:Sentence');
		$sentence = $repository->findOneBySentence($talk->text);

		if($sentence) {
			$links = $sentence->getLinks();

			if(count($links['ids']) > 0) {
				$values = array();
				for($i = 0; $i < count($links['ids']); $i++) {
					$id = $links['ids'][$i];
					for($j = 0; $j < (int) $id[1]; $j++) {
						$values []= (int) $id[0];
					}
				}

				$id = $values[array_rand($values)];

				$response = $repository->findOneById($id);
			}
		}
		else {
			$sentence = new Sentence();
			$sentence->setSentence($talk->text);
			$sentence->setLinks(array('ids' => array()));
			$doctrineManager->persist($sentence);
			$doctrineManager->flush();
		}

		if(!$response) {
			$rsm = new ResultSetMappingBuilder($doctrineManager);
			$rsm->addRootEntityFromClassMetadata('AcmeIAFrontBundle:Sentence', 's');
			$query = $doctrineManager->createNativeQuery('SELECT * FROM sentences ORDER BY RAND() LIMIT 1', $rsm);
			$response = $query->getSingleResult();
		}

		if($talk->previous !== '') {

			$textId = (int) $sentence->getId();
			$previous = $repository->findOneBySentence($talk->previous);
			$links = $previous->getLinks();

			$idExists = false;
			for($i = 0; $i < count($links['ids']); $i++) {
				$id = $links['ids'][$i];
				if((int) $id[0] == $textId) {
					$links['ids'][$i][1]++;
					$idExists = true;
					break;
				}
			}

			if(!$idExists) {
				$links['ids'] []= array($textId, 1);
			}

			$previous->setLinks($links);
			$doctrineManager->flush();
		}

		$count = (int) $doctrineManager->createQuery('SELECT COUNT(s) FROM AcmeIAFrontBundle:Sentence s')->getSingleScalarResult();

		$result = array(
			'response' => $response->getSentence(),
			'count' => $count
		);

		return $this->result(true, $result);
	}
}
