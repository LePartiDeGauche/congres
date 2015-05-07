<?php

namespace AppBundle\Entity\Text;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * The amendment proposed to the congress.
 *
 * @ORM\Table(name="amendments")
 * @ORM\Entity
 */
class Amendment
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
     * The author of the contribution.
     *
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @Assert\NotNull
     *
     */
    private $author;

    /**
     * The text concerned by the amendments.
     *
     * @var \AppBundle\Entity\Text\Text
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\Text")
     * @Assert\NotNull
     */
    private $text;

    /**
     * The line concerned by the amendment.
     *
     * @var integer
     *
     * @ORM\Column(name="start_line", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $startLine;

    /**
     * The type of the amendment : add/modify/delete.
     *
     * @var string
     *
     * @ORM\Column(name="amendment_type")
     * @Assert\NotBlank
     * @Assert\Choice(choices = {"add", "delete", "modify"})
     */
    private $amendmentType;

    /**
     * The contribution.
     *
     * @var string
     *
     * @ORM\Column(name="amendment_content", type="text")
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $amendmentContent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param Text $text
     */
    public function setText(Text $text)
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * @param int $startLine
     */
    public function setStartLine($startLine)
    {
        $this->startLine = $startLine;
    }

    /**
     * @return string
     */
    public function getAmendmentType()
    {
        return $this->amendmentType;
    }

    /**
     * @param string $amendmentType
     */
    public function setAmendmentType($amendmentType)
    {
        $this->amendmentType = $amendmentType;
    }

    /**
     * @return mixed
     */
    public function getAmendmentContent()
    {
        return $this->amendmentContent;
    }

    /**
     * @param mixed $amendmentContent
     */
    public function setAmendmentContent($amendmentContent)
    {
        $this->amendmentContent = $amendmentContent;
    }
}
