# UKMDesignSymfony2
 UKMDesign for Symfony2-applikasjoner

Todo: flytt følgende konfig inn i selve bundle'n

**Hentet fra delta/app/config/config.yml**
```yaml
twig:
    paths:
        "%kernel.root_dir%/../vendor/ukmnorge/design/Resources/views": ~
    globals:
        UKMDesign: "@UKMDesign" # Definert i UKMNorge\DesignSymfony2\Resources\config\services.yml
        UKM_HOSTNAME: "%UKM_HOSTNAME%"
```
