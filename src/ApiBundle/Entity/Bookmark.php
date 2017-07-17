<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\Comment;
use Gedmo\Mapping\Annotation as Gedmo;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Bookmark
 *
 * @ORM\Table(name="bookmarks")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\BookmarkRepository")
 */
class Bookmark
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * One Bookmark has many Comments.
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="bookmark")
     */
    private $comments;

    /**
     * @return mixed
     */

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     * @return Bookmark
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Bookmark
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}

