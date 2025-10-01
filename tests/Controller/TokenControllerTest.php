<?php

namespace App\Tests\Controller;

use App\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TokenControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $tokenRepository;
    private string $path = '/token/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->tokenRepository = $this->manager->getRepository(Token::class);

        foreach ($this->tokenRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Token index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'token[name]' => 'Testing',
            'token[type]' => 'Testing',
            'token[usage_rate]' => 'Testing',
            'token[value]' => 'Testing',
            'token[value_pr]' => 'Testing',
            'token[date_of_reception]' => 'Testing',
            'token[scenario]' => 'Testing',
            'token[character]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->tokenRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Token();
        $fixture->setName('My Title');
        $fixture->setType('My Title');
        $fixture->setUsage_rate('My Title');
        $fixture->setValue('My Title');
        $fixture->setValue_pr('My Title');
        $fixture->setDate_of_reception('My Title');
        $fixture->setScenario('My Title');
        $fixture->setCharacter('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Token');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Token();
        $fixture->setName('Value');
        $fixture->setType('Value');
        $fixture->setUsage_rate('Value');
        $fixture->setValue('Value');
        $fixture->setValue_pr('Value');
        $fixture->setDate_of_reception('Value');
        $fixture->setScenario('Value');
        $fixture->setCharacter('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'token[name]' => 'Something New',
            'token[type]' => 'Something New',
            'token[usage_rate]' => 'Something New',
            'token[value]' => 'Something New',
            'token[value_pr]' => 'Something New',
            'token[date_of_reception]' => 'Something New',
            'token[scenario]' => 'Something New',
            'token[character]' => 'Something New',
        ]);

        self::assertResponseRedirects('/token/');

        $fixture = $this->tokenRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getUsage_rate());
        self::assertSame('Something New', $fixture[0]->getValue());
        self::assertSame('Something New', $fixture[0]->getValue_pr());
        self::assertSame('Something New', $fixture[0]->getDate_of_reception());
        self::assertSame('Something New', $fixture[0]->getScenario());
        self::assertSame('Something New', $fixture[0]->getCharacter());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Token();
        $fixture->setName('Value');
        $fixture->setType('Value');
        $fixture->setUsage_rate('Value');
        $fixture->setValue('Value');
        $fixture->setValue_pr('Value');
        $fixture->setDate_of_reception('Value');
        $fixture->setScenario('Value');
        $fixture->setCharacter('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/token/');
        self::assertSame(0, $this->tokenRepository->count([]));
    }
}
