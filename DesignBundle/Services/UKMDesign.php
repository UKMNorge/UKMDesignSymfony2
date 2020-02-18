<?php
namespace UKMNorge\DesignBundle\Services;

use UKMNorge\Design\Sitemap\Section;
use UKMNorge\Design\Image;
use UKMNorge\Design\UKMDesign as UKMNorgeUKMDesign;

class UKMDesign extends UKMNorgeUKMDesign {

    private static $log;

    public function __construct($logger)
    {
        static::$log = $logger;
        static::$log->info("Constructing UKM Design service");
        require_once('UKMconfig.inc.php');
        static::setCurrentSection(
            new Section(
                'delta',
                'delta.'. UKM_HOSTNAME,
                'Delta på UKM'
            )
        );

        static::_initUKMDesign();

    }

    /**
     * Sett opp standard-data i UKMDesign
     * 
     * Basert på konfig - setter standard-data for SEO blant annet
     *
     * @return void
     */
    private static function _initUKMDesign()
    {
        static::$log->info("Initializing UKM Design service");
        UKMDesign::init();
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