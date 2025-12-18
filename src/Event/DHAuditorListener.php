<?php

namespace App\Event;

use App\Entity\Building;
use App\Entity\Character;
use App\Entity\Scenario;
use App\Repository\CharacterRepository;
use App\Service\DiscordWebhookService;
use DH\Auditor\Event\LifecycleEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DHAuditorListener implements EventSubscriberInterface
{
    private $characterRepository;
    private ParameterBagInterface $params;
    private DiscordWebhookService $discordWebhookService;

    public function __construct(DiscordWebhookService $discordWebhookService, CharacterRepository $characterRepository, ParameterBagInterface $params) {
        $this->discordWebhookService = $discordWebhookService;
        $this->characterRepository = $characterRepository;
        $this->params = $params;
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

        if ($character == null) {
            return;
        }

        $diffs = json_decode($event->getPayload()["diffs"]);

        $logs = $character->getName()."\n";
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

            if (isset($diff->old) && is_numeric($diff->old) && is_numeric($diff->new) && isset($diff->new)) {
                $substract = $diff->new - $diff->old;
                $prefixe = ($substract >= 0) ? '+' : "";
                $log .= $prefixe.($substract);
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

        $logs = $logs."Description : ".(isset($diffs->last_action_description) ? $diffs->last_action_description->new : "");

        return; // desactivation de ce code. pas satisfait du comportement de last_action.

        if ($character->getWebhookLink()) {
            $this->discordWebhookService->send($character->getWebhookLink(), $logs);
        }

        if (isset($diffs->last_action) && $character->getLastAction() == Character::TRADE_PNJ && $this->params->get('webhook_trade_npc')) {
            $this->discordWebhookService->send($this->params->get('webhook_trade_pc'), $logs);
        } elseif (isset($diffs->last_action) && $character->getLastAction() == Character::TRADE_PJ && $this->params->get('webhook_trade_pc')) {
            $this->discordWebhookService->send($this->params->get('webhook_trade_pc'), $logs);
        }
    }

    public function handleBuilding($event) {

    }

    public function handleScenario($event) {

    }

    public function handleDefault($event) {

    }

    public function tradePJ($event) {


    }

    public function tradePNJ($event) {

    }
}