<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class InvitationController extends Controller
{
  /**
   * @Route("/api/v1/invite/{senderId}/{receiverId}")
   * @Method("GET")
   */
  public function inviteAction($senderId, $receiverId) {
    $invitation = new Invitation();
    $invitation->setSenderId($senderId);
    $invitation->setReceiverId($receiverId);
    $invitation->setStatusId(Invitation::STATUS_NOT_SET);

    $em = $this->getDoctrine()->getManager();
    $em->persist($invitation);
    $em->flush();

    return new JsonResponse(array(
      'success' => 1,
      'message' => 'Invitation has been sent.',
      'id' => $invitation->getId()
    ));
  }

  /**
 * @Route("/api/v1/cancel/{senderId}/{invitationId}")
 * @Method("GET")
 */
  public function cancelAction($senderId, $invitationId) {
    $invitation = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findOneBy(
        array(
          'id' => $invitationId,
          'senderId' => $senderId,
          'statusId' => Invitation::STATUS_NOT_SET
        )
      );

    if (!$invitation) {
      return new JsonResponse(array(
        'success' => 0,
        'message' => 'No invitation found or it is already cancelled / accepted / declined'
      ));
    }

    $invitation->setStatusId(Invitation::STATUS_CANCELLED);

    $em = $this->getDoctrine()->getManager();
    $em->persist($invitation);
    $em->flush();

    return new JsonResponse(array(
      'success' => 1,
      'message' => 'Invitation cancelled'
    ));
  }

  /**
   * @Route("/api/v1/accept/{receiverId}/{invitationId}")
   * @Method("GET")
   */
  public function acceptAction($receiverId, $invitationId) {
    $invitation = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findOneBy(
        array(
          'id' => $invitationId,
          'receiverId' => $receiverId,
          'statusId' => Invitation::STATUS_NOT_SET
        )
      );

    if (!$invitation) {
      return new JsonResponse(array(
        'success' => 0,
        'message' => 'No invitation found or it is already cancelled / accepted / declined'
      ));
    }

    $invitation->setStatusId(Invitation::STATUS_ACCEPTED);

    $em = $this->getDoctrine()->getManager();
    $em->persist($invitation);
    $em->flush();

    return new JsonResponse(array(
      'success' => 1,
      'message' => 'Invitation accepted'
    ));
  }

  /**
   * @Route("/api/v1/accept/{receiverId}/{invitationId}")
   * @Method("GET")
   */
  public function declineAction($receiverId, $invitationId) {
    $invitation = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findOneBy(
        array(
          'id' => $invitationId,
          'receiverId' => $receiverId,
          'statusId' => Invitation::STATUS_NOT_SET
        )
      );

    if (!$invitation) {
      return new JsonResponse(array(
        'success' => 0,
        'message' => 'No invitation found or it is already cancelled / accepted / declined'
      ));
    }

    $invitation->setStatusId(Invitation::STATUS_DECLINED);

    $em = $this->getDoctrine()->getManager();
    $em->persist($invitation);
    $em->flush();

    return new JsonResponse(array(
      'success' => 1,
      'message' => 'Invitation declined'
    ));
  }

  /**
   * @Route("/api/v1/sentList/{senderId}")
   * @Method("GET")
   */
  public function getSentListAction($senderId) {
    $invitations = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findBy(array(
        'senderId' => $senderId
      ));

    $json = $this->jsonSerialize($invitations);
    $response = new Response($json, 200);

    return $response;
  }

  /**
   * @Route("/api/v1/invitedList/{receiverId}")
   * @Method("GET")
   */
  public function getInvitedListAction($receiverId) {
    $invitations = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findBy(array(
        'receiverId' => $receiverId
      ));

    $json = $this->jsonSerialize($invitations);
    $response = new Response($json, 200);

    return $response;
  }

  /**
   * Serialize in json format.
   *
   * @param $data
   * @return mixed
   */
  private function jsonSerialize($data)
  {
    return $this->container->get('jms_serializer')
      ->serialize($data, 'json');
  }
}