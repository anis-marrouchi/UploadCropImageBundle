<?php

/*
 * This file is part of the UploadCropImageBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Twittstrap <http://twittstrap.com>
 *
 * @copyright Copyright 2015 Anis Marrouchi <anismarrouchi@hotmail.com>
 * @link https://github.com/anis-marrouchi/upload-crop-image
 */

namespace Marrouchi\UploadCropImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description: Media
 * @todo adjust to your need if you want to handle uploads by lifecyclecallback
 * @ORM\Entity
 * @ORM\Table()
 * //@ORM\HasLifecycleCallbacks <-
 */
class Media {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    public function getPath() {
        return $this->path;
    }

    /**
     * @ORM\Column(name="created",type="date")
     */
    protected $created;

    /**
     * @var File
     *
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    protected $file;

    public function __construct() {
        $this->created = new \Datetime();
    }

    public function getUploadRootDir() {
        // absolute path to your directory where images must be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir() {
        return 'uploads/';
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->id . '.' . $this->path;
    }

    public function getWebPath() {
        return null === $this->name ? null : '/' . $this->getUploadDir() . '/' . $this->name;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $filename = sha1(uniqid(mt_rand(), true));
            $this->name = $filename;
            $this->path = $filename . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Media
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /* Set file
     *
     * @param $file
     * @return Media
     */

    public function setFile($file) {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return $file
     */
    public function getFile() {
        return $this->file;
    }

}
