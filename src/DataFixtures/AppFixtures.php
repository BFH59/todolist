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
        $userAnonyme = new User();
        $hash = $this->encoder->encodePassword($userAnonyme, 'password');
        $userAnonyme->setUsername("Anonyme")
            ->setEmail("anonyme@anonyme.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_USER']);
        $manager->persist($userAnonyme);

        //create task linked to anonymous user
        for($i=0;$i<8; $i++){
            $task = new Task();
            $task->setTitle('tache n°'.$i)
                ->setContent('test')
                ->setUser($userAnonyme);
            $manager->persist($task);

        }

        //create user "bbb" with role_user (for unit test purpose)
        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'bbb');
        $user->setUsername("bbb")
            ->setEmail("bbb@bbb.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);

        //create task for user 'bbb' for unit test purpose
        $task = new Task();
        $task->setTitle('tache de BBB')
            ->setContent('test bbb')
            ->setUser($user);
        $manager->persist($task);

        $adminUser = new User();
        $hash = $this->encoder->encodePassword($adminUser, 'admin');
        $adminUser->setUsername("admin")
            ->setEmail("admin@admin.com")
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);

        //create 50 tests users for blackfire performance testing purpose

        for($i = 0; $i <= 50; $i++) {

            $randomUser = new User();

            $hash = $this->encoder->encodePassword($randomUser, 'password');

            $randomUser->setUsername('randomUser-'.$i)
                ->setEmail('randomUser-'.$i.'@randomuser.com')
                ->setPassword($hash)
                ->setRoles(['ROLE_USER']);;
            $manager->persist($randomUser);

            $randomUserTask = new Task();
            $randomUserTask->setTitle('random task n°'.$i)
                ->setContent('random txt')
                ->setUser($randomUser);
            $manager->persist($randomUserTask);
        }



        $manager->flush();
    }
}
