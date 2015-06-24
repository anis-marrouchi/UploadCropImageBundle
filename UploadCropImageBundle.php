<?php

namespace Marrouchi\UploadCropImageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Marrouchi\UploadCropImageBundle\DependencyInjection\Compiler\TwigFormPass;

class UploadCropImageBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new TwigFormPass());
    }

}
