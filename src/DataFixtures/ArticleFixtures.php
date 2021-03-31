<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort',
    ];


    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function( Article $a, $count ) use ($manager){

            $a->setTitle($this->faker->randomElement(self::$articleTitles) );
            //$a->setSlug($this->faker->slug );
            $a->setContent(<<<EOF
    Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident …
    Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck fugiat.
EOF
            );

            if ( $this->faker->boolean(70)){
                $a->setPublishedAt( $this->faker->dateTimeBetween('-100 days', '-1 day'));
            }

            $a->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount( $this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            $comment1 = new Comment();
            $comment1->setAuthorName("Mike Stallone");
            $comment1->setContent('Everybody wants to learn doctrine!');
            $comment1->setArticle($a);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthorName("Mike Willis");
            $comment2->setContent('Nobody wants to learn doctrine!');
            $comment2->setArticle($a);
            $manager->persist($comment2);


        });

        $manager->flush();

    }
}


