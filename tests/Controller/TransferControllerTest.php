<?php

namespace App\Tests\Controller;

use App\Entity\Transfer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TransferControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $transferRepository;
    private string $path = '/transfer/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->transferRepository = $this->manager->getRepository(Transfer::class);

        foreach ($this->transferRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transfer index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'transfer[gp]' => 'Testing',
            'transfer[pr]' => 'Testing',
            'transfer[extra_pr]' => 'Testing',
            'transfer[initiator]' => 'Testing',
            'transfer[recipient]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->transferRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transfer();
        $fixture->setGp('My Title');
        $fixture->setPr('My Title');
        $fixture->setExtra_pr('My Title');
        $fixture->setInitiator('My Title');
        $fixture->setRecipient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transfer');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transfer();
        $fixture->setGp('Value');
        $fixture->setPr('Value');
        $fixture->setExtra_pr('Value');
        $fixture->setInitiator('Value');
        $fixture->setRecipient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'transfer[gp]' => 'Something New',
            'transfer[pr]' => 'Something New',
            'transfer[extra_pr]' => 'Something New',
            'transfer[initiator]' => 'Something New',
            'transfer[recipient]' => 'Something New',
        ]);

        self::assertResponseRedirects('/transfer/');

        $fixture = $this->transferRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getGp());
        self::assertSame('Something New', $fixture[0]->getPr());
        self::assertSame('Something New', $fixture[0]->getExtra_pr());
        self::assertSame('Something New', $fixture[0]->getInitiator());
        self::assertSame('Something New', $fixture[0]->getRecipient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transfer();
        $fixture->setGp('Value');
        $fixture->setPr('Value');
        $fixture->setExtra_pr('Value');
        $fixture->setInitiator('Value');
        $fixture->setRecipient('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/transfer/');
        self::assertSame(0, $this->transferRepository->count([]));
    }
}
