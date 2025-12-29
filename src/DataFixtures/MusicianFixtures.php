<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Domain\Model\Musician;
use App\Domain\Repository\BandRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;

class MusicianFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly DecoderInterface $decoder,
        private readonly BandRepositoryInterface $bandRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $file = 'musicians.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv');

        foreach ($csv as $musicianInfo) {
            $musician = new Musician();
            $musician->setFirstname($musicianInfo['firstname'])
                ->setLastname($musicianInfo['lastname'])
                ->setEmail($musicianInfo['email'])
                ->setPhone($musicianInfo['phone'])
                ->setIsActive(filter_var($musicianInfo['is_active'], FILTER_VALIDATE_BOOLEAN))
                ->setPictureFile(new ReplacingFile(__DIR__ . '/../../assets/images/avatar.png'));

            foreach ($musicianInfo as $key => $info) {
                $musicianBand = $this->bandRepository->findOneBy(['slug' => $key]);
                if ($musicianBand && $info) {
                    $musician->addBand($musicianBand);
                }
            }

            $manager->persist($musician);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BandFixtures::class,
        ];
    }
}
