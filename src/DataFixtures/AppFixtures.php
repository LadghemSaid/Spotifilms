<?php

namespace App\DataFixtures;

use App\Entity\Episodes;
use App\Entity\Kind;
use App\Entity\Series;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $dataDirectory;

    public function __construct($dataDirectory)
    {
        $this->dataDirectory = $dataDirectory;
    }


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $filesKind = file_get_contents($this->dataDirectory."/genres.json");
        $kinds = json_decode($filesKind, true);

        foreach($kinds as $name){
            $kind = new Kind();
            $kind->setName($name['nom']);
            $manager->persist($kind);
            $this->addReference($kind->getName(), $kind);
        }

        $filesData = file_get_contents($this->dataDirectory."/series.json");
        $datas = json_decode($filesData, true);

        foreach($datas as $data){
            $serie = new Series();
            $serie->setName($data['nom']);
            $serie->setSummary($data['resume']);
            $serie->setCreatedAt(new \DateTime());
            $serie->setLanguage($data['language']);
            $serie->setScore($data['note']);
            $serie->setStatus($data['statut']);
            $serie->setPremiere(new \DateTime($data['premiere']));
            $serie->setImage($data['urlImage']);
            foreach($data['genres'] as $genre){
                $serie->addKind($this->getReference($genre));
            }

            foreach($data['episodes'] as $episodeData){

                $episode = new Episodes();
                $episode->setName($episodeData['nom']);
                $episode->setSummary($episodeData['resume']);
                $episode->setCreatedAt(new \DateTime());
                $episode->setNumber($episodeData['numero']);
                $episode->setSeason($episodeData['saison']);
                $episode->setDuration($episodeData['duree']);
                $date = $episodeData['premiere'];
                if($date === '0000-00-00'){
                    $date = date('Y-m-d');
                }
                $episode->setPremiere(new \DateTime($date));
                $episode->setImage($episodeData['urlImage']);
                $episode->setCreatedAt(new \DateTime());
                $episode->setSeries($serie);
                $manager->persist($episode);
            }

            $manager->persist($serie);
        }


        $manager->flush();
    }
}
