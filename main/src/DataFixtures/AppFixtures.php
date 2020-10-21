<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /* Initialisation Etats */
        $etatCreer = new Etat();
        $etatCreer->setLibelle('Créée');
        $manager->persist($etatCreer);


        $etatOuverte = new Etat();
        $etatOuverte->setLibelle('Ouverte');
        $manager->persist($etatOuverte);

        $etatCloturee = new Etat();
        $etatCloturee->setLibelle('Clôturée');
        $manager->persist($etatCloturee);

        $etatActiviteEnCours = new Etat();
        $etatActiviteEnCours->setLibelle('Activité en cours');
        $manager->persist($etatActiviteEnCours);

        $etatPassee = new Etat();
        $etatPassee->setLibelle('Passée');
        $manager->persist($etatPassee);

        $etatAnnulee = new Etat();
        $etatAnnulee->setLibelle('Annulée');
        $manager->persist($etatAnnulee);

        /* Initialisation Villes */
        $ville1 = new Ville();
        $ville1->setNom('Caen');
        $ville1->setCodePostal('14000');
        $manager->persist($ville1);

        $ville2 = new Ville();
        $ville2->setNom('Rennes');
        $ville2->setCodePostal('35000');
        $manager->persist($ville2);

        /* Initialisation Lieux */
        $lieu1 = new Lieu();
        $lieu1->setNom('Bibliothèque');
        $lieu1->setRue('rue des livres');
        $lieu1->setLatitude('1000');
        $lieu1->setLongitude('1000');
        $lieu1->setVille($ville1);
        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('Bowling');
        $lieu2->setRue('rue des compétition');
        $lieu2->setLatitude('2000');
        $lieu2->setLongitude('2000');
        $lieu2->setVille($ville1);
        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom('Piscine');
        $lieu3->setRue('rue des bouées');
        $lieu3->setLatitude('3000');
        $lieu3->setLongitude('3000');
        $lieu3->setVille($ville2);
        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNom('Karting');
        $lieu4->setRue('rue du bitume');
        $lieu4->setLatitude('4000');
        $lieu4->setLongitude('4000');
        $lieu4->setVille($ville2);
        $manager->persist($lieu4);

        /* Initialisation des Campus */
        $campus1 = new Campus();
        $campus1->setNom('Saint-Herblain');
        $manager->persist($campus1);

        $campus2 = new Campus();
        $campus2->setNom('Nantes');
        $manager->persist($campus2);

        /* Initialisation des Participants */
        $user = new Participant();
        $user->setPseudo("Toto");
        $user->setNom("Martin");
        $user->setPrenom("Thomas");
        $user->setTelephone("0607080910");
        $user->setMail("t.martin@test.fr");
        $user->setMotPasse("$2y$13\$t/0O8W.87B0E0yQWv3cjsuo.G/4RXbx3KGuXkNIJzDaq429gJi9Ya");
        $user->setAdministrateur(false);
        $user->setActif(true);
        $user->setCampus($campus1);
        $manager->persist($user);

        $organisateur = new Participant();
        $organisateur->setPseudo("JeanN");
        $organisateur->setNom("Neymar");
        $organisateur->setPrenom("Jean");
        $organisateur->setTelephone("0607080911");
        $organisateur->setMail("j.neymar@test.fr");
        $organisateur->setMotPasse("$2y$13\$t/0O8W.87B0E0yQWv3cjsuo.G/4RXbx3KGuXkNIJzDaq429gJi9Ya");
        $organisateur->setAdministrateur(false);
        $organisateur->setActif(true);
        $organisateur->setCampus($campus1);
        $manager->persist($organisateur);

        $admin = new Participant();
        $admin->setPseudo("John");
        $admin->setNom("Hamel");
        $admin->setPrenom("Jonathan");
        $admin->setTelephone("0607080912");
        $admin->setMail("j.hamel@test.fr");
        $admin->setMotPasse("$2y$13\$t/0O8W.87B0E0yQWv3cjsuo.G/4RXbx3KGuXkNIJzDaq429gJi9Ya");
        $admin->setAdministrateur(true);
        $admin->setActif(true);
        $admin->setCampus($campus2);
        $manager->persist($admin);

        /* Initialisation des Sorties */
        $dateDebut1 = new \DateTime();
        $dateDebut1->add(new \DateInterval("P1D"));
        $dateCloture1 = new \DateTime();
        $dateCloture1->add(new \DateInterval("P6D"));
        $sortie1 = new Sortie();

        $sortie1->setNom("Club de lecture");
        $sortie1->setDateHeureDebut($dateDebut1);
        $sortie1->setDuree(120);
        $sortie1->setDateLimiteInscription($dateCloture1);
        $sortie1->setNbInscriptionMax(10);
        $sortie1->setInfosSortie("Lecture et présentation de livre méconnu");
        $sortie1->setEtat($etatOuverte);
        $sortie1->setOrganisateur($organisateur);
        $sortie1->setLieu($lieu1);
        $sortie1->setCampus($campus1);
        $sortie1->addParticipant($user, $admin);
        $manager->persist($sortie1);

        $dateDebut2 = new \DateTime();
        $dateDebut2->add(new \DateInterval("P7D"));
        $dateCloture2 = new \DateTime();
        $dateCloture2->add(new \DateInterval("P14D"));
        $sortie2 = new Sortie();

        $sortie2->setNom("Compétition de Bowling");
        $sortie2->setDateHeureDebut($dateDebut2);
        $sortie2->setDuree(120);
        $sortie2->setDateLimiteInscription($dateCloture2);
        $sortie2->setNbInscriptionMax(8);
        $sortie2->setInfosSortie("Compétition interbranche de Bowling");
        $sortie2->setEtat($etatOuverte);
        $sortie2->setOrganisateur($organisateur);
        $sortie2->setLieu($lieu2);
        $sortie2->setCampus($campus1);
        $manager->persist($sortie2);

        $dateDebut3 = new \DateTime();
        $dateDebut3->add(new \DateInterval("P14D"));
        $dateCloture3 = new \DateTime();
        $dateCloture3->add(new \DateInterval("P14D"));
        $sortie3 = new Sortie();

        $sortie3->setNom("Concours de plongeon");
        $sortie3->setDateHeureDebut($dateDebut3);
        $sortie3->setDuree('90');
        $sortie3->setDateLimiteInscription($dateCloture3);
        $sortie3->setNbInscriptionMax(12);
        $sortie3->setInfosSortie("Qui sera le meilleur plongeur?!");
        $sortie3->setEtat($etatOuverte);
        $sortie3->setOrganisateur($organisateur);
        $sortie3->setLieu($lieu3);
        $sortie3->setCampus($campus2);
        $manager->persist($sortie3);

        $dateDebut4 = new \DateTime();
        $dateDebut4->add(new \DateInterval("P21D"));
        $dateCloture4 = new \DateTime();
        $dateCloture4->add(new \DateInterval("P14D"));
        $sortie4 = new Sortie();

        $sortie4->setNom("Course de karting");
        $sortie4->setDateHeureDebut($dateDebut4);
        $sortie4->setDuree(180);
        $sortie4->setDateLimiteInscription($dateCloture4);
        $sortie4->setNbInscriptionMax(20);
        $sortie4->setInfosSortie("Faites chauffer l'asphalt");
        $sortie4->setEtat($etatOuverte);
        $sortie4->setOrganisateur($organisateur);
        $sortie4->setLieu($lieu4);
        $sortie4->setCampus($campus2);
        $manager->persist($sortie4);

        $manager->flush();
    }
}
