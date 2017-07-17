<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use  ApiBundle\Entity\Bookmark;

/**
 * Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\CommentRepository")
 */
class Comment
{
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(name="ip_address", type="string", length=50, nullable=true)
     * @Assert\Ip(version="all_public")
     */
    private $ipAddress;

    // ...
    /**
     * Many Comments have One Bookmark.
     * @ORM\ManyToOne(targetEntity="Bookmark", inversedBy="comments")
     * @ORM\JoinColumn(name="bookmark_id", referencedColumnName="id")
     */
    private $bookmark;

    /**
     * @return mixed
     */
    public function getBookmark()
    {
        return $this->bookmark;
    }

    /**
     * @param mixed $bookmark
     * @return Comment
     */
    public function setBookmark($bookmark)
    {
        $this->bookmark = $bookmark;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return Comment
     */
    public function setIpAddress( $ipAddress)
    {
        $this->ipAddress = $ipAddress;
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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}

