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
            ->setPassword($hash)
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);

        //create user "bbb" with role_user (for unit test purpose)
        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'bbb');
        $user->setUsername("bbb")
            ->setEmail("bbb@bbb.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $adminUser = new User();
        $hash = $this->encoder->encodePassword($adminUser, 'admin');
        $adminUser->setUsername("admin")
            ->setEmail("admin@admin.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);

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
