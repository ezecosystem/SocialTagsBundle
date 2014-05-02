<?php

namespace nlescure\SocialTagsBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

class TagsController extends Controller
{
    public function opengraphAction($locationId)
    {
        //$fbAppId = $this->container->getParameter( 'social_tags.opengraph.site_name' );
        //get generic info for facebook
        $fbSiteName = $this->container->getParameter( 'social_tags.opengraph.site_name' );
        $fbAppId = $this->container->getParameter( 'social_tags.opengraph.app_id' );

        try {
            //get specific info
            $location = $this->getRepository()->getLocationService()->loadLocation( $locationId );
        }
        catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e ) {
            return false;
        }
        catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e ) {
            return false;
        }

        //load data
        $contentService = $this->getRepository()->getContentService();
        $urlAliasService = $this->getRepository()->getURLAliasService();
        $contentInfo = $location->getContentInfo();
        $content = $contentService->loadContent( $contentInfo->id );

        //define values for facebook metas
        $title = $contentInfo->name;
        $url = $urlAliasService->reverseLookup($location)->path;
        $description = '';
        $image = '';

        if(  $content->getFieldValue('fbType') ) {
            $type = $content->getFieldValue('fbType')->value;
        }
        else {
            $type = 'article';
        }

        if(  $content->getFieldValue('description') ) {
            $description = $content->getFieldValue('description');
        }

        if(  $content->getFieldValue('image') ) {
            $image = $content->getFieldValue('image')->uri;
        }

        //define cache
        $response = new Response;
        $response->setPublic();
        $response->setSharedMaxAge( 86400 );
        $response->headers->set( 'X-Location-Id', $locationId );

        return $this->render(
            'SocialTagsBundle:Default:index.html.twig',
            array(
                'fbSiteName' => $fbSiteName,
                'fbAppId' => $fbAppId,
                'fbType' => $type,
                'fbTitle' => $title,
                'fbUrl' => $url,
                'fbDescription' => $description,
                'fbImage' => $image
            ),
            $response);
    }
}
