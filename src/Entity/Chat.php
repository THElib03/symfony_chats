<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'chat')]
    private Collection $message_chat;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'chats')]
    private Collection $listUser;

    public function __construct()
    {
        $this->message_chat = new ArrayCollection();
        $this->listUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageChat(): Collection
    {
        return $this->message_chat;
    }

    public function addMessageChat(Message $messageChat): static
    {
        if (!$this->message_chat->contains($messageChat)) {
            $this->message_chat->add($messageChat);
            $messageChat->setChat($this);
        }

        return $this;
    }

    public function removeMessageChat(Message $messageChat): static
    {
        if ($this->message_chat->removeElement($messageChat)) {
            // set the owning side to null (unless already changed)
            if ($messageChat->getChat() === $this) {
                $messageChat->setChat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getListUser(): Collection
    {
        return $this->listUser;
    }

    public function addListUser(User $listUser): static
    {
        if (!$this->listUser->contains($listUser)) {
            $this->listUser->add($listUser);
        }

        return $this;
    }

    public function removeListUser(User $listUser): static
    {
        $this->listUser->removeElement($listUser);

        return $this;
    }
}
