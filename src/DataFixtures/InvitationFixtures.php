<?php

namespace App\DataFixtures;

use App\Entity\Invitation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InvitationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    { 
        $this->loadInvitations($manager); 
    }

    private function loadInvitations(ObjectManager $manager)
    { 
        for ($i = 0; $i < 50; $i++) {     
            $c = new Invitation();     
            $c->setTitle($this->fakeTitle());
            $c->setDescription($this->fakeContent());
            $c->setCreatedBy($this->fakeUser());
            $date = new \DateTime();
            $date->modify('-' . rand(30, 50) . ' day');
            $c->setCreatedAt($date);
            $date = new \DateTime();
            $date->modify('-' . rand(1, 25) . ' day');
            $c->setUpdatedAt($date);
            $manager->persist($c); 
        }
        $manager->flush();
    }


    private function fakeUser(){ 
        $array = ['ganesh35@gmail.com', 'ganesh.35@gmail.com'];
        return $array[rand ( 0 , count($array) -1)];
    }
    private function fakeTitle(){ 
        $array = ['Always Remember music.', 'The music Confessions.', 'The Discovery of music.', 'The Past, Current, and Future of music.', 'The music International Symposium.', 'No Better Time for music.'];
        return $array[rand ( 0 , count($array) -1)];
    }
    private function fakeContent(){ 
        $array = [
            'Exquisite Singapore elegant discerning, Asia-Pacific efficient premium ANA sophisticated extraordinary punctual sharp izakaya boulevard Beams. Marylebone izakaya global, remarkable essential hub cosy the best Nordic ANA classic flat white sophisticated extraordinary. Tote bag business class cutting-edge, efficient premium Swiss Ginza hand-crafted smart first-class Melbourne extraordinary K-pop. Boutique liveable first-class, punctual the best essential remarkable charming ANA joy. Winkreative delightful ryokan sharp Helsinki discerning izakaya elegant classic bureaux signature.', 
            'The highest quality airport Nordic Gaggenau Lufthansa Fast Lane bulletin Marylebone Winkreative sophisticated Scandinavian. Hub Asia-Pacific finest airport, classic alluring elegant extraordinary. Zürich espresso impeccable, artisanal first-class sharp craftsmanship emerging Swiss Baggu. International Melbourne bespoke izakaya Comme des Garçons Singapore. Punctual joy hand-crafted the highest quality concierge pintxos Muji eclectic St Moritz.', 
            'Hub bespoke extraordinary Nordic. Helsinki Gaggenau quality of life concierge impeccable wardrobe. Discerning smart destination craftsmanship first-class uniforms soft power global flat white. Iconic Baggu finest Porter global, boutique perfect hand-crafted Swiss soft power sleepy extraordinary espresso Beams signature.', 
            'Emerging ANA hub finest business class artisanal K-pop. Business class bureaux quality of life Toto. Espresso lovely iconic Swiss uniforms, pintxos Winkreative signature remarkable Nordic izakaya conversation finest punctual wardrobe. Perfect bespoke remarkable ANA exclusive discerning Muji smart Zürich. Charming iconic destination discerning uniforms. Boeing 787 delightful tote bag punctual ryokan impeccable.', 
            'Intricate Zürich quality of life Nordic elegant craftsmanship, boutique efficient charming boulevard eclectic joy artisanal international tote bag. Bureaux impeccable signature alluring artisanal wardrobe. Destination discerning Asia-Pacific Fast Lane eclectic smart impeccable. Conversation soft power Lufthansa, airport intricate ANA Singapore first-class premium punctual flat white destination delightful Tsutaya emerging. Liveable quality of life pintxos lovely carefully curated the highest quality alluring eclectic. Hand-crafted Beams global pintxos boutique Winkreative Tsutaya international efficient signature exquisite sharp. Essential punctual Swiss, artisanal alluring smart intricate eclectic airport.', 
            'Ginza quality of life airport exquisite Baggu Tsutaya Swiss destination emerging. Sharp Sunspel soft power Asia-Pacific bulletin Winkreative global alluring cosy. Toto ryokan the highest quality hand-crafted. Signature Scandinavian pintxos, airport Swiss Gaggenau cutting-edge Fast Lane international hub lovely bureaux Melbourne. Muji extraordinary Marylebone Toto remarkable. Flat white finest Ginza artisanal vibrant, Swiss conversation business class pintxos.', 
            'Dolore sint laborum eiusmod Gaggenau carefully curated consequat remarkable delightful extraordinary. Culpa fugiat exclusive, pariatur Nordic officia Porter soft power smart alluring boulevard hub global et bulletin. K-pop hub in elegant signature dolore eiusmod dolore est first-class sunt craftsmanship. Carefully curated hand-crafted id laborum, K-pop consectetur aliqua ullamco quis culpa flat white. Voluptate premium dolore, ut aliqua in elegant irure reprehenderit remarkable.', 
            'Enim Ettinger Boeing 787 in commodo Marylebone, craftsmanship aliqua. Ettinger duis in, esse delightful excepteur aute Marylebone bespoke Boeing 787 laborum pintxos. Hand-crafted dolore aliquip aliqua concierge nisi sophisticated premium cosy bulletin. Beams business class sint boulevard mollit tote bag Muji deserunt Nordic global proident wardrobe pintxos conversation.', 
            'Shinkansen Ginza sharp Winkreative destination Porter airport tote bag concierge business class. Washlet sophisticated smart finest intricate. Global tote bag hub emerging izakaya Sunspel. Helsinki izakaya K-pop lovely liveable. Finest punctual liveable Comme des Garçons Porter ANA first-class Washlet Singapore izakaya pintxos K-pop Baggu. Smart uniforms handsome finest. Wardrobe Nordic premium flat white.'];
        return $array[rand ( 0 , count($array) -1)];
    }

}
