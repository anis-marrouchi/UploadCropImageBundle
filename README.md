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

	```  json
    {
        "require": {
            "marrouchi/upload-crop-image-bundle": "dev-master",
        }
    }

    ```

2. Register UploadCropImageBundle in your app/AppKernel.php:

    ``` php
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

3. Add Media entity, run schema update to generate table, and install assets  (Composer should install asset post the installation but just in case)

    ``` php
    namespace YourNamespace\YourBundle\Entity;

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
                // faites ce que vous voulez pour gÃ©nÃ©rer un nom unique
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

            // s'il y a une erreur lors du dÃ©placement du fichier, une exception
            // va automatiquement Ãªtre lancÃ©e par la mÃ©thode move(). Cela va empÃªcher
            // proprement l'entitÃ© d'Ãªtre persistÃ©e dans la base de donnÃ©es si
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

    ```

    ``` bash
    php app/console doctrine:schema:update --force
    ```

    ``` bash
    php app/console asset:install
    ```

4. Include the route to your routing.yml and the config to your config.yml:

    ``` yml
    upload_crop_image:
        resource: "@UploadCropImageBundle/Resources/config/routing.yml"
        prefix:   /
    ```
 If you did not install the JSroutingBundle include them.

    ``` yml
    # app/config/routing.yml
    fos_js_routing:
    	resource: "@UploadCropImageBundle/Resources/config/routing/routing.xml"
    ```

    ``` yml
    upload_crop_image:
        media_entity: YourNamespace\YourBundle\Entity\Media
    ```
5. include the style and the javascript in your templates. The demo include is for demo purposes.

    ``` twig
        <head>
        …
        <script src="{{asset("bundles/uploadcropimage/js/jquery.min.js") }}"></script>
        <script src="{{ asset('bundles/fosjsrouting/js/router.js') }}"></script>
        <script src="{{ path('fos_js_routing_js', {'callback': 'fos.Router.setData'}) }}"></script>
        {% include 'UploadCropImageBundle:Commun:demo.includes.html.twig' %}
        {% include 'UploadCropImageBundle:Commun:crop.includes.html.twig' %}
    </head>
    ```

6. Include the javascript before the closing body tag

	``` twig
	<body>
        …
	{% include "UploadCropImageBundle:Commun:script.html.twig" %}
	</body>

	```

7. Add the following to your Media/Image/Photo form type buildForm method

        ``` php
        public function buildForm(FormBuilderInterface $builder, array $options) {
                $builder
                        …
                        ->add('file', 'file')
                        ->add('dimensions', 'crop_image', array('mapped' => false, 'label' => false))
                        …
                ;
            }
        ```

8. Now in your view, where you are rendering the form, include the following

       ``` html
       …
       <img src="holder.js/300x300?bg=#b8ebb8&fg=#ffffff" id="cropbox">
       …
       ```

9. Now add the form tag the coordinate checker and render your form

    ``` twig
    …
    <form name="upload" action="{{ path('your_path') }}" {{ form_enctype(form) }} method="POST"  onsubmit="return checkCoords();">
    …
    ```

If you are rendering the form fields individually, you will need to include the following to your form

    ``` twig
    …
    {{ form_widget(form.dimensions) }}
    …
    ```

And that's it, let me know if you are facing some problem and let me know ways i can improve the bundle. Enjoy! ;)