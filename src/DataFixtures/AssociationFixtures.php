<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Association;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssociationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $association = new Association();
        $association->setName('Tutti Frutti');
        $association->setPhone('+33980727471');
        $association->setEmail('cameleonproduction42@gmail.com');
        $association->setCreatedAt(new DateTimeImmutable('21-04-2014'));
        $association->setAddress('Le Mazot');
        $association->setZipCode('42140');
        $association->setCity('La Gimond');
        $association->setSiret('81126403500015');
        $association->setDescription("Panel Production 42 est un groupement informel de musiciens professionnels liés par la même passion : animer vos soirées et moments festifs en leur donnant une vraie touche d'originalité, de convivialité et un goût d'authenticité 100% live qui feront de votre évènement un moment pas comme les autres !
        Salles de spectacles, communes, associations, particuliers, n'hésitez plus !");
        $manager->persist($association);

        $manager->flush();
    }
}
