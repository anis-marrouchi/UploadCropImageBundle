<?php

namespace Marrouchi\UploadCropImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UploadCropImageBundle:Default:index.html.twig', array('name' => $name));
    }
}
