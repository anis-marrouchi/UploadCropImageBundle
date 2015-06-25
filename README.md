# UploadCropImageBundle
Upload and crop an image for Symfony2
This bundle helps you add a custom file form field. You can single upload and crop an image. The bundle is based on the JCrop JQuery library.
Your contribution is welcome.

# Requirements:
- PHP GD2 extension
- JQuery
- friendsofsymfony/jsrouting-bundle

# Demo:
![Animated GIF demo](https://raw.githubusercontent.com/anis-marrouchi/UploadCropImageBundle/master/Resources/doc/images/crop.gif)

# Installation
------------

1. Add this bundle to your project in composer.json:

	```
    {
        "require": {
            "marrouchi/upload-crop-image-bundle": "dev-master",
        }
    }
    ```
2. Register UploadCropImageBundle in your app/AppKernel.php:

    ```
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Marrouchi\UploadCropImageBundle\UploadCropImageBundle(),
            // ...
        );
    }
    ```
And don't forget the JsRoutingBundle.

3. Include the route to your routing.yml:

    ```
    upload_crop_image:
        resource: "@UploadCropImageBundle/Resources/config/routing.yml"
        prefix:   /
    ```
 If you did not install the JSroutingBundle include them.
    ```
    # app/config/routing.yml
    fos_js_routing:
    	resource: "@UploadCropImageBundle/Resources/config/routing/routing.xml"
    ```
4. include the style and the javascript in your templates. The demo include is for demo purposes.

```
        <head>
        …
        <script src="{{asset("bundles/uploadcropimage/js/jquery.min.js") }}"></script>
        <script src="{{ asset('bundles/fosjsrouting/js/router.js') }}"></script>
        <script src="{{ path('fos_js_routing_js', {'callback': 'fos.Router.setData'}) }}"></script>
        {% include 'UploadCropImageBundle:Commun:demo.includes.html.twig' %}
        {% include 'UploadCropImageBundle:Commun:crop.includes.html.twig' %}
    </head>
```
5. Include the javascript before the closing body tag
	```
	<body>
        …
	{% include "UploadCropImageBundle:Commun:script.html.twig" %}
	</body>

	```
6. Add the following to your Media/Image/Photo form type buildForm method
        ```
public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                …
                ->add('file', 'file')
                ->add('dimensions', 'crop_image', array('mapped' => false, 'label' => false))
                …
        ;
    }
        ```
7. Now in your view, where you are rendering the form, include the following
       ```
       …
       <img src="holder.js/300x300?bg=#b8ebb8&fg=#ffffff" id="cropbox">
       …
       ```
8. Now add to form tag the coordinate checker and render your form

    ```
    …
    <form name="upload" action="{{ path('your_path') }}" {{ form_enctype(form) }} method="POST"  onsubmit="return checkCoords();">
    …
    ```
If you are rendering the form fields individually, you will need to include the following to your form

    ```
    …
    {{ form_widget(form.dimensions) }}
    …
    ```
And that's it, let me know if you are facing some problem and let me know ways i can improve the bundle. Enjoy! ;)