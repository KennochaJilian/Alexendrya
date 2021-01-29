<?php

namespace App\Command;

use DirectoryIterator;
use App\Entity\BookEpub;
use App\Service\ExtractEpubService;
use App\Repository\BookEpubRepository;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExtractMetaDataEpub extends Command
{

    protected static $defaultName = 'extract-data-epub';

    private $container;

    public function __construct(ContainerInterface $container, BookEpubRepository $repository)
    {
        parent::__construct();
        $this->container = $container;
        $this->repository = $repository;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = new DirectoryIterator('/home/aranxa/Documents/ebooks');
        $pathFiles = [];

        $entityManager = $this->container->get('doctrine')->getManager();

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if ($fileinfo->getExtension() == "epub") {
                    array_push($pathFiles, $fileinfo->getPathname());
                }
            }
        }

        try {
            foreach ($pathFiles as $pathFile) {
                $extractEpubService = new ExtractEpubService($pathFile);
                $newEpubBook = new BookEpub();
                $authorsArray = $extractEpubService->Authors();
                $author = array_shift($authorsArray);
                $title = $extractEpubService->chooseTitle($extractEpubService->Title(), $pathFile);
                $image = base64_encode($extractEpubService->Cover()['data']);

                $newEpubBook->setAuthor($author);
                $newEpubBook->setTitle($title);
                $newEpubBook->setDescription($extractEpubService->Description());
                $newEpubBook->setCoverImage($image);

                $entries = $this->repository->findBy(['author' => $author, 'title' => $title]);
                if (count($entries) == 0) {
                    $entityManager->persist($newEpubBook);
                    $entityManager->flush();
                }
            }
            return Command::SUCCESS;
        } catch (Exception $e) {
            return  Command::FAILURE;
        }
    }
}
