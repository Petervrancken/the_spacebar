<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleAdminController extends AbstractController
{

    /**
     * @Route("/admin/article/new")
     */
    public function new( EntityManagerInterface $entityManager )
    {
        $a = new Article();

        $randomnr = rand(100,999);
        $a->setTitle("Why asteroids taste like bacon" . $randomnr);
        $a->setSlug("why-asteroids-taste-like-bacon" . $randomnr );
        $a->setContent(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident … Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck fugiat.
EOF
        );

        if ( rand(1,10) > 2 ){
            $a->setPublishedAt( new \DateTime( sprintf('-%d days', rand(1,100))));
        }

        $a->setAuthor("Mike Vandenborre")
            ->setHeartCount(rand(5,100))
            ->setImageFilename('asteroid.jpeg');

        $entityManager->persist($a);
        $entityManager->flush();


        return new Response(
            sprintf("New article id %d, slug %s", $a->getId(), $a->getSlug())
        );
    }
}
