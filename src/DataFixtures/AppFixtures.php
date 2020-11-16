<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setUsername("Anonyme")
            ->setEmail("anonyme@anonyme.com")
            ->setPassword($hash);
        $manager->persist($user);

        for($i=0;$i<8; $i++){
            $task = new Task();
            $task->setTitle('tache n°'.$i)
                 ->setContent('test')
                 ->setUser($user);
            $manager->persist($task);

        }


        $manager->flush();
    }
}
