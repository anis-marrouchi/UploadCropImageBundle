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

namespace Marrouchi\UploadCropImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class CropType extends AbstractType {

    /**
     * Form builds the form
     * @param FormBuilderInterface $builder
     * @param array                $options
     * @todo a better a way to pass in the directory path
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('x', "hidden")
                ->add('x2', "hidden")
                ->add('y', "hidden")
                ->add('y2', "hidden")
                ->add('h', "hidden")
                ->add('w', "hidden")
                ->add("name", "hidden")
                ->add("directory", "hidden")
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'crop_image';
    }

}
