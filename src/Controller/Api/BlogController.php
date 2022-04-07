<?php


namespace App\Controller\Api;

use App\Entity\Blog;
use App\Form\Model\BlogDto;
use App\Form\Type\BlogFormType;
use App\Repository\BlogRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Timezones;

class BlogController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/blogs")
     * @Rest\View(serializerGroups={"blog"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        BlogRepository $blogRepository
    ) {
        return $blogRepository->findAll();
    }


    /**
     * @Rest\Post(path="/blogs")
     * @Rest\View(serializerGroups={"blog"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        Request $req,
        EntityManagerInterface $em,
        FileUploader $fileUploader,
        BlogRepository $blogRepository

    ) {


        $blogDto = new BlogDto();
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blogDto);
        $form->handleRequest($req);
        if(!$form->isSubmitted()) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            if($blogDto->base64Image){
                $filename = $fileUploader->uploadBase64File($blogDto->base64Image);
                $blog->setImage($filename);
            } else
            {
                $blog->setImage('.');
                
            }
            echo 'asdasd';
            $blog->setTitle($blogDto->title);
            $blog->setAuthor($blogDto->author);
            $blog->setText($blogDto->text);
            $blog->setDatetime(new \DateTime());
            $em->persist($blog);
            $em->flush();
            // $blogRepository->add($blog, true);
            return $blog;
        }
        return $form;

    }
}
?>
