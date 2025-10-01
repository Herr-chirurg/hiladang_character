<?php

namespace App\Tests\Controller;

use App\Entity\Scenario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ScenarioControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $scenarioRepository;
    private string $path = '/scenario/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->scenarioRepository = $this->manager->getRepository(Scenario::class);

        foreach ($this->scenarioRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Scenario index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'scenario[name]' => 'Testing',
            'scenario[level]' => 'Testing',
            'scenario[date]' => 'Testing',
            'scenario[description]' => 'Testing',
            'scenario[img]' => 'Testing',
            'scenario[post_link]' => 'Testing',
            'scenario[summary_link]' => 'Testing',
            'scenario[status]' => 'Testing',
            'scenario[game_master]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->scenarioRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scenario();
        $fixture->setName('My Title');
        $fixture->setLevel('My Title');
        $fixture->setDate('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImg('My Title');
        $fixture->setPost_link('My Title');
        $fixture->setSummary_link('My Title');
        $fixture->setStatus('My Title');
        $fixture->setGame_master('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Scenario');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scenario();
        $fixture->setName('Value');
        $fixture->setLevel('Value');
        $fixture->setDate('Value');
        $fixture->setDescription('Value');
        $fixture->setImg('Value');
        $fixture->setPost_link('Value');
        $fixture->setSummary_link('Value');
        $fixture->setStatus('Value');
        $fixture->setGame_master('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'scenario[name]' => 'Something New',
            'scenario[level]' => 'Something New',
            'scenario[date]' => 'Something New',
            'scenario[description]' => 'Something New',
            'scenario[img]' => 'Something New',
            'scenario[post_link]' => 'Something New',
            'scenario[summary_link]' => 'Something New',
            'scenario[status]' => 'Something New',
            'scenario[game_master]' => 'Something New',
        ]);

        self::assertResponseRedirects('/scenario/');

        $fixture = $this->scenarioRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getLevel());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImg());
        self::assertSame('Something New', $fixture[0]->getPost_link());
        self::assertSame('Something New', $fixture[0]->getSummary_link());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getGame_master());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scenario();
        $fixture->setName('Value');
        $fixture->setLevel('Value');
        $fixture->setDate('Value');
        $fixture->setDescription('Value');
        $fixture->setImg('Value');
        $fixture->setPost_link('Value');
        $fixture->setSummary_link('Value');
        $fixture->setStatus('Value');
        $fixture->setGame_master('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/scenario/');
        self::assertSame(0, $this->scenarioRepository->count([]));
    }
}
