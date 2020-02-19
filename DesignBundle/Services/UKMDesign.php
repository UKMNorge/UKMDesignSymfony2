<?php
namespace UKMNorge\DesignBundle\Services;

use Symfony\Component\HttpKernel\Config\FileLocator;
use UKMNorge\Design\Sitemap\Section;
use UKMNorge\Design\Image;
use UKMNorge\Design\UKMDesign as UKMNorgeUKMDesign;
use UKMNorge\Design\YamlLoader;

class UKMDesign extends UKMNorgeUKMDesign {

    public function __construct(FileLocator $fileLocator, $kernel_cache_dir)
    {
        require_once('UKMconfig.inc.php');
        static::setCurrentSection(
            new Section(
                'delta',
                'delta.'. UKM_HOSTNAME,
                'Delta på UKM'
            )
        );

        // Opprett cache-mappe om den ikke finnes
        try {
            $fileLocator->locate($kernel_cache_dir.'/ukmdesignbundle/');
        } catch( \InvalidArgumentException $e ) {
            mkdir( $kernel_cache_dir .'/ukmdesignbundle/', 0777, true );
        }
        

        $yamlLoader = new YamlLoader(
            $fileLocator->locate($kernel_cache_dir.'/ukmdesignbundle/'),
            str_replace(
                'designsymfony2/DesignBundle',
                'design', 
                $fileLocator->locate('@UKMDesignBundle/Resources/config/')
            )
        );
        static::_initUKMDesign( $yamlLoader );

    }

    /**
     * Sett opp standard-data i UKMDesign
     * 
     * Basert på konfig - setter standard-data for SEO blant annet
     *
     * @return void
     */
    private static function _initUKMDesign( $yamlLoader )
    {
        UKMDesign::init( $yamlLoader );
        UKMDesign::getHeader()::getSeo()
            ->setImage(
                new Image(
                    UKMDesign::getConfig('SEOdefaults.image.url'),
                    intval(UKMDesign::getConfig('SEOdefaults.image.width')),
                    intval(UKMDesign::getConfig('SEOdefaults.image.height')),
                    UKMDesign::getConfig('SEOdefaults.image.type')
                )
            )
            ->setSiteName(UKMDesign::getConfig('SEOdefaults.site_name'))
            ->setType('website')
            ->setTitle(UKMDesign::getConfig('SEOdefaults.title'))
            ->setDescription(UKMDesign::getConfig('slogan'))
            ->setAuthor(UKMDesign::getConfig('SEOdefaults.author'))
            ->setFBAdmins(UKMDesign::getConfig('facebook.admins'))
            ->setFBAppId(UKMDesign::getConfig('facebook.app_id'))
            ->setGoogleSiteVerification(UKMDesign::getConfig('google.site_verification'));
    }
}