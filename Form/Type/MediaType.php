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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType {

    private $data_class;

    public function __construct($data_class) {
        $this->data_class = $data_class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('file', 'file')
                ->add('dimensions', 'crop_image', array('mapped' => false, 'label' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->data_class
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'marrouchi_uploadcropimagebundle_media';
    }

}
