<?php

use App\Entity\Event;
use App\Entity\User;


//fichier neccessaire : chermin vers bootstrap.php 
require_once "bootstrap.php";

//fichier neccessaire : chermin vers fichier entity.php 
require_once "src/Entity/User.php";
require_once "src/Entity/Event.php";


// Faker\Generator instance
$faker = Faker\Factory::create();

//create user
$sexe = [
    1 => "masculin",
    2 => "feminin"
];

$userNum = 50;
$password = "azerty123";

for ($i = 0; $i < $userNum; $i++) {
    $createUser = (new User())->setFullname($faker->name())
        ->setSexe($sexe[rand(1, 2)])
        ->setEmail($faker->email())
        ->setPassword(sha1($password))
        ->setAge(rand(25, 70));

    $em->persist($createUser);

    $users[] = $createUser;
}
$em->flush();


//create events
$eventNum = 200;

for ($i = 0; $i < $eventNum; $i++) {
    $createEvent = (new Event())->setTitle($faker->text(300))
        ->setDescription($faker->text(rand(4000, 4500)))
        ->setImgUrl($faker->imageUrl(360, 360, 'animals', true, 'cats'))
        ->setPromotedBy($users[rand(0, $userNum - 1)])
        // ->addEventParticipated($users[rand(0, $userNum - 1)])
        ->addEventParticipated($users[rand(0, $userNum - 1)]);

    $em->persist($createEvent);
}
$em->flush();
