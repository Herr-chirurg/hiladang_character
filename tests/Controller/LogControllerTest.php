<?php

namespace App\Tests\Controller;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LogControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $logRepository;
    private string $path = '/log/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->logRepository = $this->manager->getRepository(Log::class);

        foreach ($this->logRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Log index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'log[item_type]' => 'Testing',
            'log[item_id]' => 'Testing',
            'log[created_at]' => 'Testing',
            'log[field_name]' => 'Testing',
            'log[old_value]' => 'Testing',
            'log[new_value]' => 'Testing',
            'log[description]' => 'Testing',
            'log[user_id]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->logRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Log();
        $fixture->setItem_type('My Title');
        $fixture->setItem_id('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setField_name('My Title');
        $fixture->setOld_value('My Title');
        $fixture->setNew_value('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUser_id('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Log');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Log();
        $fixture->setItem_type('Value');
        $fixture->setItem_id('Value');
        $fixture->setCreated_at('Value');
        $fixture->setField_name('Value');
        $fixture->setOld_value('Value');
        $fixture->setNew_value('Value');
        $fixture->setDescription('Value');
        $fixture->setUser_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'log[item_type]' => 'Something New',
            'log[item_id]' => 'Something New',
            'log[created_at]' => 'Something New',
            'log[field_name]' => 'Something New',
            'log[old_value]' => 'Something New',
            'log[new_value]' => 'Something New',
            'log[description]' => 'Something New',
            'log[user_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/log/');

        $fixture = $this->logRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getItem_type());
        self::assertSame('Something New', $fixture[0]->getItem_id());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getField_name());
        self::assertSame('Something New', $fixture[0]->getOld_value());
        self::assertSame('Something New', $fixture[0]->getNew_value());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getUser_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Log();
        $fixture->setItem_type('Value');
        $fixture->setItem_id('Value');
        $fixture->setCreated_at('Value');
        $fixture->setField_name('Value');
        $fixture->setOld_value('Value');
        $fixture->setNew_value('Value');
        $fixture->setDescription('Value');
        $fixture->setUser_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/log/');
        self::assertSame(0, $this->logRepository->count([]));
    }
}
