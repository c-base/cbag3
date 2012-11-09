<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dazs
 * Date: 11/9/12
 * Time: 8:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Cbase\Cbag3\ArtefactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cbase\Cbag3\ArtefactBundle\Document\Artefact;
use Cbase\Cbag3\ArtefactBundle\Document\ArtefactState;

class LoadArtefactData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $mainHall = new Artefact();
        $mainHall->setName('Mainhall');
        $mainHall->setDescription('die mainhall, eine multifunktionale fläche, die je nach bedarf mit verschiedenen '.
                'gegenständen ausgerüstet  wird. regelmäßig werden tische, stühle, sofas, stellwände verwendet. '.
                'die mainhall ist ausgestattet mit mindestens einem, manchmal zwei soundsystemen und variierend '.
                'zwischen einem und 6 beamern. die mtc steht hier und diverse andere artfakte');
        $mainHallState = new ArtefactState();
        $mainHallState->setHasAsset(true);
        $mainHallState->setHasImage(true);
        $mainHall->setState($mainHallState);

        $manager->persist($mainHall);
        $manager->flush();


        $mtc = new Artefact();
        $mtc->setName('mtc');
        $mtc->setDescription(
            'steht zumeist in der Mainhall. Auf eine in einem seitlich geschlossenen ' .
                'eines Beamers projeziert. Gleichzeitig wird die Glasplatte ebenfalls '.
                'von unten mit Infrarot-LEDs beleuchtet und mit einer Infrarot Kamera abgefilmt. Gegenstände und '.
                'natürlich Finger und Hände auf der Glasplatte (oder kurz darüber) werden so erkannt. Softwareseitig '.
                'können so beliebig viele Touchpositionen erkannt und ausgewertet werden.' .
                'Tisch eingebaute Glasplatte, die auf der Unterseite eine Diffusorfolie trägt, wird von unten mithilfe ');
        $mtcState = new ArtefactState();
        $mtcState->setHasText(true);
        $mtc->setState($mtcState);

        $manager->persist($mtc);
        $manager->flush();


        $tuerClingel = new Artefact();
        $tuerClingel->setName('türclingel');
        $tuerClingel->setDescription('drück drauf & dir wird aufgetan (sofern jemand anwesend ist)');

        $manager->persist($tuerClingel);
        $manager->flush();


        $bar = new Artefact();
        $bar->setName('bar');
        $bar->setDescription('');

        $manager->persist($bar);
        $manager->flush();


        $mameOMat = new Artefact();
        $mameOMat->setName('mame-o-mat');
        $mameOMat->setDescription('');

        $manager->persist($mameOMat);
        $manager->flush();


        $alienSecuritySecurityAlien = new Artefact();
        $alienSecuritySecurityAlien->setName('aliensecuritysecurityalien');
        $alienSecuritySecurityAlien->setDescription('wird bei großveranstaltungen aktiviert, wenn zu große hitze, zu wenig '.
                'platz & zu viel alkohol den einen oder anderen gast seine manieren vergessen läßt');

        $manager->persist($alienSecuritySecurityAlien);
        $manager->flush();


        $cGate = new Artefact();
        $cGate->setName('c-gate');
        $cGate->setDescription('mobiles modul aus 5 teilen, zusammen gebaut faltet es einen neuen partyraum im raum auf, '.
            'das gravitationsmodul des c-gate arbeitet unzuverlässig, crewmember verschwinden einfach, lang vermisste tauchen '.
            'wieder aus dem c-gate auf. wurde auch schon auf diversen außenmissionen aufgebaut. enthält display mit aktuellen '.
            'abfahrtszeiten von u-bahn, s-bahn, bus sowie weltraumimpressionen, straßenkarten, etc. im cervice modus. '.
            'hintergrundkulisse in puppetmastaz\' "midi mighty mo"');

        $manager->persist($cGate);
        $manager->flush();


        $cultOrgaBruecce = new Artefact();
        $cultOrgaBruecce->setName('cultorgabruecce');
        $cultOrgaBruecce->setDescription('wird benutzung zur organisation von cultur und veranstatltungen an bord. enthält '.
                'diverse gegenstände, die für den reinbungslosen ablauf von veranstaltungen von nöten sein kann');

        $manager->persist($cultOrgaBruecce);
        $manager->flush();

        $cTraenke = new Artefact();
        $cTraenke->setName('c-traenke');
        $cTraenke->setDescription('getränkereplikator mit differenzierung alien- / member-preis');
        $cTraenkeState = new ArtefactState();
        $cTraenkeState->setHasAsset(true);
        $cTraenke->setState($cTraenkeState);

        $manager->persist($cTraenke);
        $manager->flush();


        $spendenSchlund = new Artefact();
        $spendenSchlund->setName('spendenschlund');
        $spendenSchlund->setDescription('in anlehnung an den film flash gordon. erinnert an den initiationsritus der waldleute, '.
                'bei dem der junge anwärter seine hand in eines der löcher des baumstumpfes stecken muss, in der hoffnung, '.
                'dass der skorpion nicht gerade dort sitzt. hat es gerne, wenn man ihm devisen jeglicher art in den schlund '.
                'wirft, beißt zu, wenn man versucht, etwas herauszuholen');

        $manager->persist($spendenSchlund);
        $manager->flush();


        $masterBlaster = new Artefact();
        $masterBlaster->setName('masterblaster');
        $masterBlaster->setDescription('umfangreiche musik-bibliothek. mad max\' gegner in der donnerkuppel');

        $manager->persist($masterBlaster);
        $manager->flush();


        $vjUndCoundpult = new Artefact();
        $vjUndCoundpult->setName('vj und coundpult');
        $vjUndCoundpult->setDescription('hier befinden sich die steuereinheiten für die audiovisuelle untermalung der mainhall.');
        $vjUndCoundpultState = new ArtefactState();
        $vjUndCoundpultState->setHasAsset(true);
        $vjUndCoundpultState->setHasImage(true);
        $vjUndCoundpult->setState($vjUndCoundpultState);

        $manager->persist($vjUndCoundpult);
        $manager->flush();


        $he2 = new Artefact();
        $he2->setName('he2');
        $he2->setDescription('mobile & stationäre arbeitsplätze zum trainiern von hand-augen-koordination, taktik, reaktion, '.
                'und / oder (hier müsst ihr so programmierzeugs einsetzen)');
        $he2State = new ArtefactState();
        $he2State->getHasAsset(true);
        $he2State->getHasImage(true);
        $he2->setState($he2State);

        $manager->persist($he2);
        $manager->flush();


        $arboretum = new Artefact();
        $arboretum->setName('arboretum');
        $arboretum->setDescription('das freiluftlabor der genetic engineers zum testen der entwürfe des evolution designs, '.
                'gerne von der crew auch als entspannungsort und gemüsegarten genutzt,  von dem direkten ausblick auf die '.
                'antenne sagt man, er sei legendär...');

        $manager->persist($arboretum);
        $manager->flush();


        $antenne = new Artefact();
        $antenne->setName('antenne');
        $antenne->setDescription('wurde 1969 durch einen unglücklichen zufall enttarnt. seitdem als fernsehturm bekannt. hebt mit ab.');

        $manager->persist($antenne);
        $manager->flush();
    }

}