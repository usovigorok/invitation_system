<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="sender_id", type="integer")
     */
    private $senderId;

    /**
     * @var int
     *
     * @ORM\Column(name="receiver_id", type="integer")
     */
    private $receiverId;

    /**
     * @var int
     *
     * @ORM\Column(name="status_id", type="integer")
     */
    private $statusId;

    const STATUS_NOT_SET = 0;
    const STATUS_CANCELLED = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DECLINED = 3;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set senderId
     *
     * @param integer $senderId
     *
     * @return Invitation
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * Get senderId
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set receiverId
     *
     * @param integer $receiverId
     *
     * @return Invitation
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * Get receiverId
     *
     * @return int
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Set statusId
     *
     * @param integer $statusId
     *
     * @return Invitation
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return int
     */
    public function getStatusId()
    {
        return $this->statusId;
    }
}

