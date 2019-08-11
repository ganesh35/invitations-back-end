<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InviteeRepository")
 */
class Invitee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $invitationId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $invitationTo;

    /**
     * @ORM\Column(type="string", length=32)
     * Invited, Accepted, Declined, Revoked
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvitationId(): ?int
    {
        return $this->invitationId;
    }

    public function setInvitationId(int $invitationId): self
    {
        $this->invitationId = $invitationId;

        return $this;
    }

    public function getInvitationTo(): ?string
    {
        return $this->invitationTo;
    }

    public function setInvitationTo(string $invitationTo): self
    {
        $this->invitationTo = $invitationTo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
