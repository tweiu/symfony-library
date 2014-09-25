<?php
namespace Intaro\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Intaro\LibraryBundle\Entity\BookRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="intaro_book")
 */

class Book
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $title;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $author;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cover;

    protected $oldCover;
    /**
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Поддерживаются только изображения формата jpeg или png"
     *     )
     */
    protected $coverInput;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $file;

    protected $oldFile;
    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage = "Поддерживаются файлы до {{ limit }} {{ suffix }}"
     *     )
     */
    protected $fileInput;
    /**
     * @ORM\Column(name="read_at", type="datetime", nullable=true)
     */
    protected $readAt;
    /**
     * @ORM\Column(name="allow_download", type="boolean", nullable=true)
     */
    protected $allowDownload;

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
     * Set title
     *
     * @param  string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param  string $author
     * @return Book
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
     * Set cover
     *
     * @param  string $cover
     * @return Book
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        if ($this->cover) {
            return "/" . $this->getUploadDir() . "/" . $this->getPathToFile($this->cover);
        }
    }

    /**
     * Set file
     *
     * @param  string $file
     * @return Book
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        if ($this->file) {
            return "/" . $this->getUploadDir() . "/" . $this->getPathToFile($this->file);
        } else {
            return false;
        }
    }

    /**
     * Set readAt
     *
     * @param  \DateTime $readAt
     * @return Book
     */
    public function setReadAt($readAt)
    {
        $this->readAt = $readAt;

        return $this;
    }

    /**
     * Get readAt
     *
     * @return \DateTime
     */
    public function getReadAt()
    {
        return $this->readAt;
    }

    /**
     * Set allowDownload
     *
     * @param  boolean $allowDownload
     * @return Book
     */
    public function setAllowDownload($allowDownload)
    {
        $this->allowDownload = $allowDownload;

        return $this;
    }

    /**
     * Get allowDownload
     *
     * @return boolean
     */
    public function isAllowDownload()
    {
        return $this->allowDownload;
    }

    /**
     * Get allowDownload
     *
     * @return boolean
     */
    public function getAllowDownload()
    {
        return $this->allowDownload;
    }

    /**
     * Sets CoverInput.
     *
     * @param UploadedFile $file
     */
    public function setCoverInput(UploadedFile $file = null)
    {
        $this->coverInput = $file;
        if (isset($this->cover)) {
            // store the old name to delete after the update
            $this->oldCover = $this->cover;
            $this->cover = null;
        } else {
            $this->cover = 'initial';
        }

        return $this;
    }

    /**
     * Gets CoverDel.
     *
     * @return string
     */
    public function getCoverDel()
    {
        return null;
    }

    /**
     * Sets CoverDel.
     *
     * @param string $coverDel
     */
    public function setCoverDel($coverDel)
    {
        if ($coverDel == "Y") {
            unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->cover));
            $this->cover = null;
        }

        return $this;
    }

    /**
     * Gets FileDel.
     *
     * @return string
     */
    public function getFileDel()
    {
        return null;
    }

    /**
     * Sets FileDel.
     *
     * @param string $fileDel
     */
    public function setFileDel($fileDel)
    {
        if ($fileDel == "Y") {
            unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->file));
            $this->file = null;
        }

        return $this;
    }

    /**
     * Get CoverInput.
     *
     * @return UploadedFile
     */
    public function getCoverInput()
    {
        return $this->coverInput;
    }

    /**
     * Sets FileInput.
     *
     * @param UploadedFile $file
     */
    public function setFileInput(UploadedFile $file = null)
    {
        $this->fileInput = $file;
        if (isset($this->file)) {
            // store the old name to delete after the update
            $this->oldFile = $this->file;
            $this->file = null;
        } else {
            $this->file = 'initial';
        }

        return $this;
    }

    /**
     * Get FileInput.
     *
     * @return UploadedFile
     */
    public function getFileInput()
    {
        return $this->fileInput;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFileInput()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->file = $filename.'.'.$this->getFileInput()->getClientOriginalExtension();
        }
        if (null !== $this->getCoverInput()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->cover = $filename.'.'.$this->getCoverInput()->getClientOriginalExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null !== $this->getCoverInput()) {
            // move takes the target directory and then the
            // target filename to move to
            $this->getCoverInput()->move(
                $this->getUploadRootDir()."/".$this->getFilenamePrefix($this->cover),
                $this->cover
            );
            if ($this->oldCover) {
                unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->oldCover));
                $this->oldCover = null;
            }
            // clean up the file property as you won't need it anymore
            $this->coverInput = null;
        }
        // the file property can be empty if the field is not required
        if (null !== $this->getFileInput()) {
            // move takes the target directory and then the
            // target filename to move to
            $this->getFileInput()->move(
                $this->getUploadRootDir()."/".$this->getFilenamePrefix($this->file),
                $this->file
            );
            if ($this->oldFile) {
                unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->oldFile));
                $this->oldFile = null;
            }
            // clean up the file property as you won't need it anymore
            $this->fileInput = null;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->file)) {
            unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->file));
        }
        if (isset($this->cover)) {
            unlink($this->getUploadRootDir().'/'.$this->getPathToFile($this->cover));
        }
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        return 'uploads/files';
    }
    public function getPathToFile($filename)
    {
        return $this->getFilenamePrefix($filename) . "/" . $filename;
    }
    protected function getFilenamePrefix($filename)
    {
        return substr($filename, 0, 2);
    }
}
