<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('ZimZim');
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->addRole('ROLE_ADMIN');
        $user->setCreatedAt(new \DateTime('now'));
        $user->setEmail('zimzim@gmail.com');
        $this->addReference($user->getUsername(), $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('Fred');
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->addRole('ROLE_ADMIN');
        $user->setCreatedAt(new \DateTime('now'));
        $user->setEmail('fred@gmail.com');
        $this->addReference($user->getUsername(), $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('Gilles');
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setEmail('gilles@gmail.com');
        $this->addReference($user->getUsername(), $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('Sebastien');
        $plainPassword = $user->getUsername();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setEmail('sebastien@gmail.com');
        $this->addReference($user->getUsername(), $user);
        $manager->persist($user);

        $manager->flush();
    }
}
