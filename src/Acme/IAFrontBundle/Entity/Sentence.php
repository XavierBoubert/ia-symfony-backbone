<?php

namespace Acme\IAFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sentences")
 */
class Sentence
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
     * @ORM\Column(type="text")
     */
    protected $sentence;

	/**
     * @ORM\Column(type="text")
     */
    protected $links;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     * @return Sentence
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
    
        return $this;
    }

    /**
     * Get sentence
     *
     * @return string 
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set links
     *
     * @param string $links
     * @return Sentence
     */
    public function setLinks($links)
    {
        $this->links = json_encode($links);
    
        return $this;
    }

    /**
     * Get links
     *
     * @return string 
     */
    public function getLinks()
    {
        return json_decode($this->links, true);
    }
}
