<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Products
{
    public const SERVER_PATH_TO_IMAGE_FOLDER = 'images';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private ?string $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private ?string $code;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private ?int $sort;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $filename;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updated;

    /**
     * Unmapped property to handle file uploads
     */
    private ?UploadedFile $file = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $status;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus( bool $status): Products
    {
        $this->status = $status;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags( bool $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function setFile(?UploadedFile $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload(): void
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $this->getFile()->getClientOriginalName()
        );

        $this->filename = $this->getFile()->getClientOriginalName();
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server.
     */
    public function lifecycleFileUpload(): void
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire.
     */
    public function refreshUpdated(): void
    {
        $this->setUpdated(new \DateTime());
        $this->lifecycleFileUpload();
    }

    public function getWebPath():string
    {
        return self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$this->getFilename();
    }

}
