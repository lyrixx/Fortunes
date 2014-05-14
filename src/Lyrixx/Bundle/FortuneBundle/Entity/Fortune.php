<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fortune
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FortuneRepository")
 */
class Fortune
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="quotes", type="text")
     * @Assert\NotBlank()
     */
    private $quotes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="votes", type="integer")
     */
    private $votes;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->votes = 0;
        $this->author = 'Anonymous';
    }

    public function vote($dir)
    {
        if ('up' == $dir) {
            $this->votes++;
        } elseif ('down' == $dir) {
            $this->votes--;
        } else {
            throw new \InvalidArgumentException(sprintf('The "%s" direction is not a valid choices ("down", "up").', $dir));
        }

        return $this;
    }

    public function getQuotesAsArray()
    {
        $quotes = array();

        foreach (explode("\n", $this->quotes) as $line) {
            if (preg_match('/^<(?P<nick>.*?)>\s*(?P<quote>.*)\s*$/', trim($line), $matches)) {
                $quotes[] = array(
                    'nick' => $matches['nick'],
                    'quote' => $matches['quote'],
                );
            } else {
                $quotes[] = array(
                    'nick' => '',
                    'quote' => trim($line),
                );
            }
        }

        return $quotes;
    }

    /**
     * @Assert\True(message="Quotes are not valid. It should respect the following format: '<nickname> quote...'")
     */
    public function isQuotesValid()
    {
        foreach (explode("\n", $this->quotes) as $line) {
            if (!preg_match('/^<.+>.+$/', trim($line), $matches)) {
                return false;
            }
        }

        return true;
    }

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
     * Set author
     *
     * @param  string  $author
     * @return Fortune
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set quotes
     *
     * @param  string  $quotes
     * @return Fortune
     */
    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;

        return $this;
    }

    /**
     * Get quotes
     *
     * @return string
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get votes
     *
     * @return integer
     */
    public function getVotes()
    {
        return $this->votes;
    }
}
