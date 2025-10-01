<?php

namespace App\Tests\Controller;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CharacterControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $characterRepository;
    private string $path = '/character/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->characterRepository = $this->manager->getRepository(Character::class);

        foreach ($this->characterRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Character index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'character[name]' => 'Testing',
            'character[title]' => 'Testing',
            'character[img]' => 'Testing',
            'character[level]' => 'Testing',
            'character[xp_current]' => 'Testing',
            'character[xp_current_mj]' => 'Testing',
            'character[gp]' => 'Testing',
            'character[pr]' => 'Testing',
            'character[end_activity]' => 'Testing',
            'character[owner]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->characterRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Character();
        $fixture->setName('My Title');
        $fixture->setTitle('My Title');
        $fixture->setImg('My Title');
        $fixture->setLevel('My Title');
        $fixture->setXp_current('My Title');
        $fixture->setXp_current_mj('My Title');
        $fixture->setGp('My Title');
        $fixture->setPr('My Title');
        $fixture->setEnd_activity('My Title');
        $fixture->setOwner('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Character');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Character();
        $fixture->setName('Value');
        $fixture->setTitle('Value');
        $fixture->setImg('Value');
        $fixture->setLevel('Value');
        $fixture->setXp_current('Value');
        $fixture->setXp_current_mj('Value');
        $fixture->setGp('Value');
        $fixture->setPr('Value');
        $fixture->setEnd_activity('Value');
        $fixture->setOwner('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'character[name]' => 'Something New',
            'character[title]' => 'Something New',
            'character[img]' => 'Something New',
            'character[level]' => 'Something New',
            'character[xp_current]' => 'Something New',
            'character[xp_current_mj]' => 'Something New',
            'character[gp]' => 'Something New',
            'character[pr]' => 'Something New',
            'character[end_activity]' => 'Something New',
            'character[owner]' => 'Something New',
        ]);

        self::assertResponseRedirects('/character/');

        $fixture = $this->characterRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getImg());
        self::assertSame('Something New', $fixture[0]->getLevel());
        self::assertSame('Something New', $fixture[0]->getXp_current());
        self::assertSame('Something New', $fixture[0]->getXp_current_mj());
        self::assertSame('Something New', $fixture[0]->getGp());
        self::assertSame('Something New', $fixture[0]->getPr());
        self::assertSame('Something New', $fixture[0]->getEnd_activity());
        self::assertSame('Something New', $fixture[0]->getOwner());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Character();
        $fixture->setName('Value');
        $fixture->setTitle('Value');
        $fixture->setImg('Value');
        $fixture->setLevel('Value');
        $fixture->setXp_current('Value');
        $fixture->setXp_current_mj('Value');
        $fixture->setGp('Value');
        $fixture->setPr('Value');
        $fixture->setEnd_activity('Value');
        $fixture->setOwner('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/character/');
        self::assertSame(0, $this->characterRepository->count([]));
    }
}
