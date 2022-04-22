<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Parser\Parser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 299; $i++)
        {

            $parser = new Parser();
            if ($parser->create($i+random_int(1,1000)))
            {
                $product = new Products();
                $product->setName($parser->getName());
                $product->setCode($parser->getName());
                $product->setStatus(true);
                $product->setTags(false);
                $product->setSort($i);
                $product->setFilename($parser->getFilename());
                $manager->persist($product);

            }
        }

        $manager->flush();

    }
}
