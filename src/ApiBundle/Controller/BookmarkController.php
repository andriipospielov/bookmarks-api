<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Bookmark;

class BookmarkController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
            ' SELECT b
                  FROM ApiBundle:Bookmark b
                  '
        );

        $bookmarks = $query->getArrayResult();

        return JsonResponse::create(
            [
                'status' => 'ok',
                'bookmarks' => $bookmarks,
            ],
            Response::HTTP_OK
        );
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function storeAction(Request $request)
    {
        $url = $request->get('url');

        $repo = $this->getDoctrine()->getRepository('ApiBundle:Bookmark');

        $bookmark = $repo->findOneBy(['url' => $url]);

        if (null === $bookmark) {
            $bookmark = new Bookmark();
            $bookmark->setUrl($url);
            $now = new \DateTime('now');
            $bookmark->setUpdatedAt($now);
            $bookmark->setCreatedAt($now);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($bookmark);
            $em->flush();
            return JsonResponse::create(
                [
                    'status' => 'ok',
                    'id' => $bookmark->getId(),
                ],
                Response::HTTP_CREATED
            );
        } else {
            return JsonResponse::create(
                [
                    'status' => 'ok',
                    'id' => $bookmark->getId(),
                ],
                Response::HTTP_OK
            );
        }
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @ParamConverter("bookmark", class="ApiBundle:Bookmark")
     */
    public function showAction(Bookmark $bookmark)
    {

        return JsonResponse::create(
            [
                'status' => 'ok',
                'comments' => $bookmark->getComments()->toArray(),
            ],
            Response::HTTP_OK
        );
    }


}
