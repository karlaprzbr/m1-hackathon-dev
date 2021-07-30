<?php

namespace App\DataFixtures;

use App\Entity\Podcast;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i < 20; $i++) {
            $podcast = new Podcast();
            $podcast->setTitle('Episode #'.$i);
            $podcast->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, alias hic et velit quod eligendi assumenda reprehenderit minima est sunt quam ipsum, incidunt molestias blanditiis enim dolorem ad deleniti illum.');
            $podcast->setPath('public/podcasts/episode'.$i.'.mp3');
            $podcast->setPublishedAt(new \DateTimeImmutable());
            $manager->persist($podcast);
            $manager->flush();
        }
        
    }
}