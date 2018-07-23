<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SpotRepository")
 * @Vich\Uploadable
 */
class Spot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\Valid
     */
    private $picture;
    /**
     * @Assert\File(maxSize="2M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @var File
     * @Vich\UploadableField(mapping="spot_images", fileNameProperty="picture")
     */
    private $pictureFile;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @ORM\Column(type="text", length=255)
     */
    private $description;
    /**
     * @ORM\Column(type="float")
     */
    private $latitude;
    /**
     * @ORM\Column(type="float")
     */
    private $longitude;
    /**
     * @ORM\Column(type="integer")
     * Assert\Range(min = 0, max = 2)
     * 0 = refused, 1 = waiting, 2 = accepted
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="spots")
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="spot", cascade="remove")
     */
    private $comments;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", cascade="persist")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     * @Assert\Type(type="App\Entity\Category")
     * @Assert\Valid()
     */
    private $category;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->updateAt = new \DateTime();
        $this->status = 1;
      //  $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Spot
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param null|string $picture
     */
    public function setPicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @return null|File
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @param null|File $picture
     */
    public function setPictureFile(?File $picture = null):void
    {
        $this->pictureFile = $picture;
        if (null != $picture) {
            $this->updateAt = new \DateTime();
        }
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param $updateAt
     * @return $this
     */
    public function setUpdateAt( $updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Spot
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Spot
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Spot
     */
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Spot
     */
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Spot
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }
    /**
     * @param string $comments
     * @return Spot
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }


    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setSpot($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getSpot() === $this) {
                $comment->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Spot
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }


}