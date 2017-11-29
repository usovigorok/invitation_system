<?php
/**
 * Created by IntelliJ IDEA.
 * User: iusovich
 * Date: 29.11.17
 * Time: 21:06
 */

namespace Tests\AppBundle\Controller\Api\v1;

class InvitationControllerTest extends \PHPUnit_Framework_TestCase
{
  public function testInvite() {
    $client = new \GuzzleHttp\Client([
      'base_url' => 'http://127.0.0.1:8000',
      'defaults' => [
        'exceptions' => false
      ]
    ]);

    $response = $client->get('/api/v1/invite/1/2');
    $finishedData = json_decode($response->getBody(true), true);

    $invitation = $this->getDoctrine()
      ->getRepository(Invitation::class)
      ->findOneBy(
        array(
          'id' => $finishedData['id']
        )
      );

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('1', $finishedData['success']);
    $this->assertEquals($invitation->getId(), $finishedData['id']);

  }
}