<?php


namespace App\Controller\Api;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BooksController extends AbstractFOSRestController {
    /**
     * @Rest\Get(path="/books")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        BookRepository $bookRepository
    ) {
        return $bookRepository->findAll();
    }

    
    /**
     * @Rest\Post(path="/books")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em, Request $request
    ) {
        $book = new Book();
        $response = new JsonResponse();
        $title = $request->get('title', null);
        if (empty($title)) {
            $response->setData([
                'success' => false,
                'error' => 'title not empty',
                'data' => null

            ]);
            return $response;
        }
        $book->setTitle($title);
        $em->persist($book);
        $em->flush();
        return $book;
    }

    
}
?>