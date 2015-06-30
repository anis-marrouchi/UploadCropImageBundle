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

namespace Marrouchi\UploadCropImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Marrouchi\UploadCropImageBundle\Form\Type\MediaType;
use Marrouchi\UploadCropImageBundle\Entity\Media;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller MediaController
 *
 * @author Anis Marrouchi <anismarrouchi@hotmail.com>
 * Skype marrouchi
 * Linkedin https://www.linkedin.com/in/marrouchi
 */
class MediaController extends Controller {

    /**
     * Upload Media form
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadAction(Request $request) {
        $entityName = $this->container->getParameter('upload_crop_image.media_entity');
        $media = new $entityName;
        //Set filename to false to preview placeholder
        $filename = false;
        $form = $this->createForm(new MediaType(), $media);
        return $this->render('UploadCropImageBundle:Media:upload.html.twig', array('form' => $form->createView(), 'filename' => $filename));
    }

    public function jsonUploadAction(Request $request) {
//Process upload in controller
        $entityName = $this->container->getParameter('upload_crop_image.media_entity');
        $media = new $entityName;
        //Set filename to false to preview placeholder
        $filename = false;
        $form = $this->createForm(new MediaType(), $media);
        $form->handleRequest($request);
        //Process the form
        if ($form->isValid()) {
            $file = $form->get('file')->getData();
            $name = sha1(uniqid(mt_rand(), true)) . "." . $file->guessExtension();
            $directory = $media->getUploadRootDir();
            $asset = $this->container->get('templating.helper.assets')->getUrl("uploads/$name");
            $file->move($directory, $name);
            return new JsonResponse(array('filename' => $filename, 'name' => $name, 'directory' => $directory, 'asset' => $asset));
        } else {
            $error = $form->getErrorsAsString();
            return new JsonResponse(array('error' => $error));
        }
    }

    public function cropAction(Request $request) {
        //Process upload in controller
        $entityName = $this->container->getParameter('upload_crop_image.media_entity');
        $media = new $entityName;
        //Set filename to false to preview placeholderz
        $asset = false;
        $form = $this->createForm(new MediaType(), $media);
        $form->handleRequest($request);
        //Process the form
        if ($form->isValid()) {
            //Basic Cropping image adapted from Jcrop gd2 extension required
            extract($form->get('dimensions')->getData());
            $quality = 90;
            $filename = $directory . $name;
            $asset = $this->container->get('templating.helper.assets')->getUrl("uploads/$name");
            $srcImage = imagecreatefromjpeg($filename);
            $dstImage = ImageCreateTrueColor($w, $h);
            imagecopyresampled($dstImage, $srcImage, 0, 0, $x, $y, $w, $h, $w, $h);
            imagejpeg($dstImage, $filename, $quality);
            //TODO: persist to database
            //TODO: redirect to the controller of your choice once done
        }
        return $this->render('UploadCropImageBundle:Media:upload.html.twig', array('form' => $form->createView(), 'asset' => $asset));
    }

}
