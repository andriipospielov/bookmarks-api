<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Bookmark;
use ApiBundle\Entity\Comment;

class CommentController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @ParamConverter("bookmark", class="ApiBundle:Bookmark")
     */
    public function storeAction(Bookmark $bookmark, Request $request)
    {
        $body = $request->get('text');
        $ipAddr = $request->getClientIp();

        $comment = new Comment();

        $comment->setBookmark($bookmark);
        $comment->setIpAddress($ipAddr);
        $comment->setText($body);
        $now = new \DateTime('now');
        $bookmark->setUpdatedAt($now);
        $bookmark->setCreatedAt($now);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($comment);
        $em->flush();

        return JsonResponse::create(
            [
                'status' => 'ok',
                'id' => $bookmark->getId(),
            ],
            Response::HTTP_CREATED
        );

    }

}
