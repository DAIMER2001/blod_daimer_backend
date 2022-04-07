<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testCreateBlogInvalidData()
    {
        $client = static::createClient();

        $client->request(
        'POST',
        '/api/blogs',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        '{   "title": "" }'
    );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
    public function testCreateBlogEmptyData()
    {
        $client = static::createClient();

        $client->request(
        'POST',
        '/api/blogs',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        '{}'
    );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
    public function testSuccess()
    {
        $client = static::createClient();

        $client->request(
        'POST',
        '/api/books',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        '{   "title": "CIEN AÑOS DE SOLEDAD",
            "author": "GABRIEL GARCIA MARQUES",
            "text": " TRATA DE UNA TERRORIFICA CASA Q ASUSTAN"}'
    );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

?>