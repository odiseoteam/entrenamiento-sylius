<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use JMS\Serializer\Annotation as JMS;

/**
 * @Entity
 * @Table(name="app_testimony")
 */
class Testimony implements ResourceInterface, TimestampableInterface, TranslatableInterface
{
    const STATE_PENDING = 'pending_review';
    const STATE_PUBLISHED = 'published';
    const STATE_REJECTED = 'rejected';

    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @JMS\Exclude();
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", nullable=false, unique=false)
     */
    private $state;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->state = self::STATE_PENDING;
        $this->initializeTranslationsCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getTranslation()->getTitle();
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->getTranslation()->setTitle($title);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getTranslation()->getDescription();
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): TestimonyTranslation
    {
        return new TestimonyTranslation();
    }
}
