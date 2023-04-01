<?php

namespace App\Test\Controller;

use App\Entity\Provider;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProviderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProviderRepository $repository;
    private string $path = '/provider/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Provider::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Provider index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'provider[name]' => 'Testing',
            'provider[address]' => 'Testing',
            'provider[createdAt]' => 'Testing',
            'provider[description]' => 'Testing',
            'provider[logo]' => 'Testing',
        ]);

        self::assertResponseRedirects('/provider/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Provider();
        $fixture->setName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLogo('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Provider');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Provider();
        $fixture->setName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLogo('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'provider[name]' => 'Something New',
            'provider[address]' => 'Something New',
            'provider[createdAt]' => 'Something New',
            'provider[description]' => 'Something New',
            'provider[logo]' => 'Something New',
        ]);

        self::assertResponseRedirects('/provider/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLogo());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Provider();
        $fixture->setName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLogo('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/provider/');
    }
}
