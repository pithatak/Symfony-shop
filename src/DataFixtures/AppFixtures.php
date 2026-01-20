<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(public ProductFactory $productFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $category = new Category();
        $category->setName('Toys');
        $manager->persist($category);

        for ($i = 1; $i <= 15; $i++) {
            $name = 'Amogus_' . $i;
            $root = dirname(__DIR__, 2);

            $product = $this->productFactory->create(
                $name,
                mt_rand(10, 100),
                $category,
                $admin,
                $root . '/files/fixtures/images/products/' . $name . '.jpg'
            );

            $manager->persist($product);
        }

        $manager->flush();
    }
}
