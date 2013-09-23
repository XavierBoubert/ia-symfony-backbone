<?php

namespace Acme\IAFrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\IAFrontBundle\Entity\Sentence;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$doctrineManager = $this->getDoctrine()->getManager();

		$resources = array(
			'robot_id' => rand(1, 500),
			'content_count' => (int) $doctrineManager->createQuery('SELECT COUNT(s) FROM AcmeIAFrontBundle:Sentence s')->getSingleScalarResult()
		);

        return $this->render('AcmeIAFrontBundle:Default:index.html.twig', $resources);
    }

    public function graphAction()
    {
		$doctrineManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AcmeIAFrontBundle:Sentence');

		$resources = array(
            'content_count' => (int) $doctrineManager->createQuery('SELECT COUNT(s) FROM AcmeIAFrontBundle:Sentence s')->getSingleScalarResult()
        );

		$query = $repository->createQueryBuilder('s')->orderBy('s.sentence', 'ASC')->setMaxResults(100)->getQuery();
		$sentences = $query->getResult();

		$sentencesResult = array();
		for($i = 0; $i < sizeof($sentences); $i++) {
			$sentence = $sentences[$i];
			$links = $sentence->getLinks();
			$ids = $links['ids'];

			$sentencesResult [$i] = array(
				'id' => (int) $sentence->getId(),
				'sentence' => $sentence->getSentence(),
				'responses' => array()
			);
	
			if(count($ids) > 0) {
				for($j = 0; $j < sizeof($sentences); $j++) {
					$sentenceResponse = $sentences[$j];
	
					for($k = 0; $k < count($ids); $k++) {
						if((int) $ids[$k][0] == (int) $sentenceResponse->getId()) {
							$sentencesResult[$i]['responses'] []= array(
								'sentence' => $sentenceResponse->getSentence(),
								'weigth' => $ids[$k][1]
							);
							break;
						}
					}
				}
			}
		}

		$resources['sentences'] = $sentencesResult;

        return $this->render('AcmeIAFrontBundle:Default:graph.html.twig', $resources);
    }
}
