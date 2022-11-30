<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesGroup extends Fixture
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $groups = [];

        for($i = 0; $i <= 9 ; $i++)
        {
            $group = new Group();
            $group->setName('group_'. $i);
            $groups[] = $group;

            $manager->persist($group);
            $manager->flush();
        }

        $user = $this->userRepository->findOneBy(['mail' => 'test@test.com']);

        for($i = 0; $i <= 9 ; $i++)
        {
            $trick = new Trick();
            $trick->setName('Trick_' . $i);
            $trick->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ex urna, gravida eget nisl nec, pretium 
            facilisis purus. Vivamus velit risus, vestibulum ac nibh quis, gravida pretium dolor. Aenean in lacus lobortis, 
            pretium metus at, fermentum sem. Pellentesque augue tortor, pharetra nec est vitae, tincidunt venenatis magna. 
            Integer molestie nulla velit, commodo feugiat erat egestas sed. Sed');
            $trick->setUser($user);
            $trick->setTrickGroup($groups[$i]);

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug('Trick_' . $i);
            $trick->setSlug($slug);

            $video = new Video();
            $video->setLink('<iframe width="560" height="315" src="https://www.youtube.com/embed/GBR0dlVgiiQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
            $video->setTrick($trick);

            $image = new Image();
            $image->setTitle('default.jpg');
            $image->setTrick($trick);
            
            $manager->persist($image);
            $manager->persist($video);
            $manager->persist($trick);
            $manager->flush();
        }


    }

    public function getOrder(): int
    {
        return 2; // smaller means sooner
    }

}
