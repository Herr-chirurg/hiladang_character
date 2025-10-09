<?php

namespace App\Tests\Controller;

use App\Entity\Building;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BuildingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $buildingRepository;
    private string $path = '/building/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->buildingRepository = $this->manager->getRepository(Building::class);

        foreach ($this->buildingRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Building index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'building[name]' => 'Testing',
            'building[type]' => 'Testing',
            'building[production]' => 'Testing',
            'building[bonus]' => 'Testing',
            'building[alias]' => 'Testing',
            'building[owner]' => 'Testing',
            'building[location]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->buildingRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Building();
        $fixture->setName('My Title');
        $fixture->setType('My Title');
        $fixture->setProduction('My Title');
        $fixture->setBonus('My Title');
        $fixture->setAlias('My Title');
        $fixture->setOwner('My Title');
        $fixture->setLocation('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Building');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Building();
        $fixture->setName('Value');
        $fixture->setType('Value');
        $fixture->setProduction('Value');
        $fixture->setBonus('Value');
        $fixture->setAlias('Value');
        $fixture->setOwner('Value');
        $fixture->setLocation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'building[name]' => 'Something New',
            'building[type]' => 'Something New',
            'building[production]' => 'Something New',
            'building[bonus]' => 'Something New',
            'building[alias]' => 'Something New',
            'building[owner]' => 'Something New',
            'building[location]' => 'Something New',
        ]);

        self::assertResponseRedirects('/building/');

        $fixture = $this->buildingRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getProduction());
        self::assertSame('Something New', $fixture[0]->getBonus());
        self::assertSame('Something New', $fixture[0]->getAlias());
        self::assertSame('Something New', $fixture[0]->getOwner());
        self::assertSame('Something New', $fixture[0]->getLocation());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Building();
        $fixture->setName('Value');
        $fixture->setType('Value');
        $fixture->setProduction('Value');
        $fixture->setBonus('Value');
        $fixture->setAlias('Value');
        $fixture->setOwner('Value');
        $fixture->setLocation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/building/');
        self::assertSame(0, $this->buildingRepository->count([]));
    }
}
