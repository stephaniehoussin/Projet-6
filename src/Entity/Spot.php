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
    const STATUS_NEED_VALIDATION = 1;
    const STATUS_VALID = 2;
    const STATUS_REJECT = 0;
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
     * @Assert\Range(min = 0, max = 2)
     * 0 = refused, 1 = waiting, 2 = accepted
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="spots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="spot", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Love", mappedBy="spot", cascade={"remove"})
     */
    private $loves;

    /**
     * @ORM\OneToMany(targetEntity="Tree", mappedBy="spot", cascade={"remove"})
     */
    private $trees;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="spots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $infosSupp;


    public function __construct()
    {
        $this->date = new \DateTime();
        $this->updateAt = new \DateTime();
        $this->status = 1;
        $this->comments = new ArrayCollection();
        $this->loves = new ArrayCollection();
        $this->trees = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment() : Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments() : Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setSpot($this);
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
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
    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    public function getInfosSupp(): ?string
    {
        return $this->infosSupp;
    }

    public function setInfosSupp(?string $infosSupp): self
    {
        $this->infosSupp = $infosSupp;

        return $this;
    }

    public function libelleStatus()
    {
        switch ($this->status)
        {
            case 0:
                return 'Refusée';
                break;
            case 1:
                return 'En attente';
                break;
            case 2:
                return 'Acceptée';
                break;

        }
    }


    /**
     * @return Collection|Love[]
     */
    public function getLove() : Collection
    {
        return $this->loves;
    }

    /**
     * @return Collection|Love[]
     */
    public function getLoves() : Collection
    {
        return $this->loves;
    }

    /**
     * @param Love $love
     */
    public function addLove(Love $love)
    {
        $this->loves[] = $love;
        $love->setSpot($this);
    }

    /**
     * @param Love $love
     */
    public function removeLove(Love $love)
    {
        $this->loves->removeElement($love);
    }


    /**
     * @return Collection|Tree[]
     */
    public function getTree() : Collection
    {
        return $this->trees;
    }

    /**
     * @return Collection|Tree[]
     */
    public function getTrees() : Collection
    {
        return $this->trees;
    }

    /**
     * @param Tree $tree
     */
    public function addTree(Tree $tree)
    {
        $this->trees[] = $tree;
        $tree->setSpot($this);
    }

    /**
     * @param Tree $tree
     */
    public function removeTree(Tree $tree)
    {
        $this->trees->removeElement($tree);
    }


}

