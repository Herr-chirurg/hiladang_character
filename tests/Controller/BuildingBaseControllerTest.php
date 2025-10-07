<?php

namespace App\Tests\Controller;

use App\Entity\BuildingBase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BuildingBaseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $buildingBaseRepository;
    private string $path = '/building/base/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->buildingBaseRepository = $this->manager->getRepository(BuildingBase::class);

        foreach ($this->buildingBaseRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('BuildingBase index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'building_base[name]' => 'Testing',
            'building_base[price]' => 'Testing',
            'building_base[type]' => 'Testing',
            'building_base[production]' => 'Testing',
            'building_base[bonus]' => 'Testing',
            'building_base[upgrade_to]' => 'Testing',
            'building_base[upgrade_from]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->buildingBaseRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new BuildingBase();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setType('My Title');
        $fixture->setProduction('My Title');
        $fixture->setBonus('My Title');
        $fixture->setUpgrade_to('My Title');
        $fixture->setUpgrade_from('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('BuildingBase');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new BuildingBase();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setType('Value');
        $fixture->setProduction('Value');
        $fixture->setBonus('Value');
        $fixture->setUpgrade_to('Value');
        $fixture->setUpgrade_from('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'building_base[name]' => 'Something New',
            'building_base[price]' => 'Something New',
            'building_base[type]' => 'Something New',
            'building_base[production]' => 'Something New',
            'building_base[bonus]' => 'Something New',
            'building_base[upgrade_to]' => 'Something New',
            'building_base[upgrade_from]' => 'Something New',
        ]);

        self::assertResponseRedirects('/building/base/');

        $fixture = $this->buildingBaseRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getProduction());
        self::assertSame('Something New', $fixture[0]->getBonus());
        self::assertSame('Something New', $fixture[0]->getUpgrade_to());
        self::assertSame('Something New', $fixture[0]->getUpgrade_from());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new BuildingBase();
        $fixture->setName('Value');
        $fixture->setPrice('Value');
        $fixture->setType('Value');
        $fixture->setProduction('Value');
        $fixture->setBonus('Value');
        $fixture->setUpgrade_to('Value');
        $fixture->setUpgrade_from('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/building/base/');
        self::assertSame(0, $this->buildingBaseRepository->count([]));
    }
}
