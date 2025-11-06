<?php

namespace App\Tests\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class ArticleControllerTest extends WebTestCase
{
    private $client;
    private ?EntityManagerInterface $em;

    protected function setUp(): void
    {
        // 1) cliente que simula peticiones HTTP
        $this->client = static::createClient();

        // 2) obtener EntityManager (Symfony 6.4: static::getContainer())
        $this->em = static::getContainer()->get(EntityManagerInterface::class);

        // Opcional: limpiar/asegurar estado si necesitas
        // $this->em->createQuery('DELETE FROM App\Entity\Article a')->execute();
    }

    public function testGetArticlesPageLoadsSuccessfully(): void
    {
        // Simula GET /articles (ajusta la ruta a la real)
        $crawler = $this->client->request('GET', '/');

        // Comprueba que la respuesta HTTP es 200
        $this->assertResponseIsSuccessful();

        // Comprueba que existe un <h1> en la página. Cambia el selector si tu plantilla es diferente.
        $this->assertSelectorExists('h1');
    }

    public function testAddArticleFormSubmission(): void
    {
        // Ir a la página con el formulario de creación
        $crawler = $this->client->request('GET', '/articles/add');

        // Busca el botón del formulario (texto del botón que usa tu Twig)
        $button = $crawler->selectButton('Guardar');

        // Obtener el formulario y rellenar campos
        $form = $button->form([
            'article[title]' => 'Article from test',
            'article[slug]' => 'article-from-test',
            'article[content]' => 'Content test',
            'article[status]' => 'draft',
            'article[isFeatured]' => false,

            // otros campos si existen, p.e. 'article[status]' => 'published'
        ]);

        // Enviar formulario
        $this->client->submit($form);

        // Si el controlador hace redirect, seguirlo (muy común)
        $this->client->followRedirect();

        // Verificar que el artículo fue persistido en la DB
        $article = $this->em->getRepository(Article::class)
            ->findOneBy(['title' => 'Artículo de prueba desde test']);

        $this->assertNotNull($article, 'El artículo debe existir en la base de datos');
        $this->assertSame('artículo-de-prueba-desde-test', $article->getSlug());
    }

    public function testDeleteArticleRemovesIt(): void
    {
        // Crear entidad manualmente para luego borrarla
        $article = new Article();
        $article->setTitle('Para eliminar test');
        $article->setSlug('para-eliminar-test');
        $article->setContent('Contenido');
        $article->setCreateAt(new \DateTime());
        $article->setUpdatedAt(new \DateTime());

        $this->em->persist($article);
        $this->em->flush();

        // Llamar a la ruta de borrado (ajusta la URL a la real)
        $this->client->request('GET', '/articles/delete/' . $article->getId());

        // Seguir redirect si aplica
        $this->client->followRedirect();

        // Comprobar que ya no existe
        $deleted = $this->em->getRepository(Article::class)->find($article->getId());
        $this->assertNull($deleted, 'El artículo debe haber sido eliminado');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Cerrar em para evitar memory leaks
        if ($this->em) {
            $this->em->close();
        }
        $this->em = null;
    }
}
