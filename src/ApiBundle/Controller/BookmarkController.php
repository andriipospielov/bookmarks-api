<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Bookmark;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
                  ORDER BY b.createdAt DESC 
                  '
        );

        $bookmarks = $query->setMaxResults(10)->getArrayResult();

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
     * @return Response
     * @ParamConverter("bookmark", class="ApiBundle:Bookmark")
     */
    public function showAction(Bookmark $bookmark)
    {
        $comments = $bookmark->getComments();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('bookmark'));
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        $jsonifiedData = $serializer->serialize($comments, 'json');
        return Response::create($jsonifiedData, Response::HTTP_OK);
    }


}
