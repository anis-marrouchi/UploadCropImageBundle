<?php

/*
 * This file is part of the UploadCropImageBundle package.
 *
 * (c) upload-crop-image <#>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marrouchi\UploadCropImageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Add a new twig.form.resources
 *
 * @author Anis Marrouchi <anismarrouchi@hotmail.com>
 * Skype marrouchi
 * Linkedin https://www.linkedin.com/in/marrouchi
 */
class TwigFormPass implements CompilerPassInterface {

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container) {
        $template = "UploadCropImageBundle:Form:fields.html.twig";
        $resources = [];
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources');
        }

        $resources[] = $template;

        $container->setParameter('twig.form.resources', $resources);
    }

}
