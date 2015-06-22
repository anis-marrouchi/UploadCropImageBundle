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
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller MediaController
 *
 * @author Anis Marrouchi <anismarrouchi@hotmail.com>
 * Skype marrouchi
 * Linkedin https://www.linkedin.com/in/marrouchi
 */
class MediaController extends Controller {

    /**
     * Upload Media
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadAction() {
        return $this->render('UploadCropImageBundle:Media:upload.modal.html.twig', array('form' => $form->createView()));
    }

}
