<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function( Article $a, $count ){

            $a->setTitle("Why asteroids taste like bacon" . $count);
            $a->setSlug("why-asteroids-taste-like-bacon" . $count );
            $a->setContent(<<<EOF
    Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident …
    Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck fugiat.
EOF
            );

            if ( rand(1,10) > 2 ){
                $a->setPublishedAt( new \DateTime( sprintf('-%d days', rand(1,100))));
            }

            $a->setAuthor("Mike Ferengi")
                ->setHeartCount( rand(5,100))
                ->setImageFilename('asteroid.jpeg');
        });

        $manager->flush();

    }
}


