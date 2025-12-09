<?php

namespace App\Event;

use App\Entity\Building;
use App\Entity\Character;
use App\Entity\Scenario;
use App\Repository\CharacterRepository;
use App\Service\DiscordWebhookService;
use DH\Auditor\Event\LifecycleEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DHAuditorListener implements EventSubscriberInterface
{
    private $characterRepository;
    private DiscordWebhookService $discordWebhookService;

    public function __construct(DiscordWebhookService $discordWebhookService, CharacterRepository $characterRepository) {
        $this->discordWebhookService = $discordWebhookService;
        $this->characterRepository = $characterRepository;
    }

    
    public static function getSubscribedEvents(): array
    {
        return [
            LifecycleEvent::class => 'onAuditEvent',
        ];
    }
    public function onAuditEvent(LifecycleEvent $event): LifecycleEvent
    {

        switch ($event->getPayload()["entity"]) {
            case Character::class :
                $this->handleCharacter($event);

            case Building::class :
                $this->handleBuilding($event);

            case Scenario::class :
                $this->handleScenario($event);

            default;
                $this->handleDefault($event);
                
        }

        return $event;
    }

    public function handleCharacter($event) {
        $character = $this->characterRepository->find($event->getPayload()["object_id"]);

        if ($character->getWebhookLink() == null) {
            return;
        }

        $diffs = json_decode($event->getPayload()["diffs"]);

        $logs = "";
        foreach ($diffs as $key => $diff) {
            if ($key == "last_action_description" || $key == "webhook_link") {
                continue;
            }

            $log = $key." : ";
            if (isset($diff->old)) {
                if (isset($diff->old->id)) {
                    $log .= $diff->old->id;
                } else {
                    $log .= $diff->old;
                }
            }

            if (is_numeric($diff->old) && is_numeric($diff->new)) {
                $substract = $diff->new - $diff->old;
                $prefixe = ($substract >= 0) ? '+' : '-';
                $log .= " ".$prefixe." ".($substract);
            }
            $log .= " -> ";

            if (isset($diff->new)) {
                if (isset($diff->new->id)) {
                    $log .= " ".$diff->new->id;
                } else {
                    $log .= " ".$diff->new;
                }
            }

            $logs = $logs.$log."\n";

        }

        $logs = $logs."Description : ".$diffs->last_action_description->new;

        $this->discordWebhookService->send($character->getWebhookLink(), $logs);
    }

    public function handleBuilding($event) {

    }

    public function handleScenario($event) {

    }

    public function handleDefault($event) {

    }
}