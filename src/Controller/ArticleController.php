<?php


namespace App\Controller;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Services\MarkdownService;
use App\Services\PeterStringService;
use Doctrine\ORM\EntityManagerInterface;
use Michelf\MarkdownInterface;
//use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{


    private $isDebug;

    public function __construct(bool $isDebug){
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);

    }
    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article/*, CommentRepository $commentRepository/*, Client $slack*/)
    {
        /*if ($slug === 'khaaaaaan')
        {
            $message = $slack->createMessage()
                ->from('Khan')
                ->withIcon(':ghost:')
                ->setText('Ah, Kirk, my old friend...');
            $slack->sendMessage($message);
        }*/


//        //dd($slug);
//        $repo = $em->getRepository(Article::class);
//        //dd($repo);
//        /** @var Article $article */
//        $article = $repo->findOneBy(['slug' => $slug]);
//        //dd($slug);
//        if ( !$article){
//            throw $this->createNotFoundException( sprintf("No article found with slug %s", $slug));
//        }


        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render( 'article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ] );




//        $markdown_content = <<<EOF
//Spicy jalapeno bacon ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow **turkey** shank eu pork belly meatball non cupim.
//Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
//laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder, capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt occaecat lorem meatball prosciutto quis strip steak.
//Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
//fugiat.
//EOF;


//        $articleContent = $markdownService->parse($markdown_content);
//        $articleContent = $peterStringService->capital($articleContent);
//
//
//        return $this->render('article/show.html.twig', [
//            'title' => ucwords(str_replace('-', ' ', $slug)),
//            'slug' => $slug,
//            'content' => $articleContent,
//            'comments' => $comments,
//        ]);
    }


    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        // TODO - actually heart/unheart the article!
        $article->incrementHeartCount();
        $entityManager->flush();

        $logger->info('Article is being hearted!');

        //return new JsonResponse(['hearts' => rand(5, 100)]);
        return $this->json(['hearts' => $article->getHeartCount()]);
    }



};



