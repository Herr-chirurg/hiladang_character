<?php

namespace App\Tests\Controller;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ActivityControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $activityRepository;
    private string $path = '/activity/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->activityRepository = $this->manager->getRepository(Activity::class);

        foreach ($this->activityRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Activity index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'activity[type]' => 'Testing',
            'activity[date]' => 'Testing',
            'activity[cost_gp]' => 'Testing',
            'activity[cost_pr]' => 'Testing',
            'activity[duration]' => 'Testing',
            'activity[description]' => 'Testing',
            'activity[participant]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->activityRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Activity();
        $fixture->setType('My Title');
        $fixture->setDate('My Title');
        $fixture->setCost_gp('My Title');
        $fixture->setCost_pr('My Title');
        $fixture->setDuration('My Title');
        $fixture->setDescription('My Title');
        $fixture->setParticipant('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Activity');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Activity();
        $fixture->setType('Value');
        $fixture->setDate('Value');
        $fixture->setCost_gp('Value');
        $fixture->setCost_pr('Value');
        $fixture->setDuration('Value');
        $fixture->setDescription('Value');
        $fixture->setParticipant('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'activity[type]' => 'Something New',
            'activity[date]' => 'Something New',
            'activity[cost_gp]' => 'Something New',
            'activity[cost_pr]' => 'Something New',
            'activity[duration]' => 'Something New',
            'activity[description]' => 'Something New',
            'activity[participant]' => 'Something New',
        ]);

        self::assertResponseRedirects('/activity/');

        $fixture = $this->activityRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getCost_gp());
        self::assertSame('Something New', $fixture[0]->getCost_pr());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getParticipant());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Activity();
        $fixture->setType('Value');
        $fixture->setDate('Value');
        $fixture->setCost_gp('Value');
        $fixture->setCost_pr('Value');
        $fixture->setDuration('Value');
        $fixture->setDescription('Value');
        $fixture->setParticipant('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/activity/');
        self::assertSame(0, $this->activityRepository->count([]));
    }
}
