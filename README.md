SocialTagsBundle
================

Social tags bundle for eZ Publish (facebook opengraph, twitter, pinterest, etc)

## Roadmap :
- opengraph meta : done
- twitter card meta
- pinterest meta
- mapping fields for each class


## Install
- 1/ install bundle in src/nlescure/SocialTagsBundle
- 2/ activate the bundle in EzPublishKernel.php :
    new nlescure\SocialTagsBundle\SocialTagsBundle(),

## Opengraph usage :
In the twig that displays the metas:

{{ render(controller('SocialTagsBundle:Tags:opengraph', { "locationId": content.contentInfo.mainLocationId }, {"strategy": "esi"} )) }}

