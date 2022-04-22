<?php

namespace App\Controller;

use App\Parser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class TestParserController extends AbstractController
{
    /**
     * @Route("/test/parser", name="app_test_parser")
     */
    public function index(): Response
    {
        for ($i = 0; $i <= 10; $i++) {

            $name = 'test';
            $filename = 'test';
            $parser = new Parser();
            if ($parser->create($i))
            {
                $filename = $parser->getFilename();
                $name = $parser->getName();
            }

        }

        return $this->render('test_parser/index.html.twig', [
            'controller_name' => 'TestParserController',
            'parser_name'=> $filename,
            'parser_filename'=> $name
        ]);
    }
}
