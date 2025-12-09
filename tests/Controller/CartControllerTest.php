<?php

namespace App\Tests\Controller;

use App\Entity\CartGP;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CartGPControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $cartGPRepository;
    private string $path = '/cartGP/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->cartGPRepository = $this->manager->getRepository(CartGP::class);

        foreach ($this->cartGPRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CartGP index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cartGP[date]' => 'Testing',
            'cartGP[status]' => 'Testing',
            'cartGP[buyer]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->cartGPRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CartGP();
        $fixture->setDate('My Title');
        $fixture->setStatus('My Title');
        $fixture->setBuyer('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CartGP');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CartGP();
        $fixture->setDate('Value');
        $fixture->setStatus('Value');
        $fixture->setBuyer('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cartGP[date]' => 'Something New',
            'cartGP[status]' => 'Something New',
            'cartGP[buyer]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cartGP/');

        $fixture = $this->cartGPRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getBuyer());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new CartGP();
        $fixture->setDate('Value');
        $fixture->setStatus('Value');
        $fixture->setBuyer('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/cartGP/');
        self::assertSame(0, $this->cartGPRepository->count([]));
    }
}
