<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Symfony\Form;

use App\Infrastructure\Doctrine\Entity\Band;
use App\Infrastructure\Symfony\Form\BandType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class BandPictureTest extends KernelTestCase
{
    public function testSquareWebpPictureIsAccepted(): void
    {
        $_SERVER['DATABASE_URL'] ??= 'mysql://test:test@127.0.0.1:3306/test?serverVersion=8.0.37';
        $_ENV['DATABASE_URL'] ??= $_SERVER['DATABASE_URL'];
        self::bootKernel();
        $path = tempnam(sys_get_temp_dir(), 'band-image-');
        $image = imagecreatetruecolor(10, 10);
        imagewebp($image, $path);
        imagedestroy($image);

        try {
            $builder = self::getContainer()->get('form.factory')->createBuilder(data: new Band(), options: ['csrf_protection' => false]);
            (new BandType())->buildForm($builder, []);
            foreach (['name', 'description', 'isActive', 'flashInformation', 'tagline', 'priceCategory', 'events', 'musicStyles', 'leader', 'musicians', 'color'] as $name) {
                $builder->remove($name);
            }
            $form = $builder->getForm();
            $form->submit(['pictureFile' => ['file' => new UploadedFile($path, 'picture.webp', 'image/webp', null, true)]]);

            self::assertCount(0, $form->get('pictureFile')->getErrors(true));
        } finally {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }
}
