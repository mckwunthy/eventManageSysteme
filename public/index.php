<?php

use App\Entity\User;
use Slim\Views\Twig;
use App\Entity\Event;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


require_once dirname(__DIR__) . "/bootstrap.php";

// Instantiate App
$app = AppFactory::create();


// Create Twig
$twig = Twig::create(dirname(__DIR__) . '/templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes : home
$app->get('/', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    //get all events
    $eventRepo = $GLOBALS["em"]->getRepository(Event::class);
    $events = $eventRepo->findAll();

    // var_dump($events[10]->getEventParticipated()->getValues()[1]->getId());
    // exit(1);
    $viewData = [
        "events" => $events,
        "name" => "Home Page"
    ];

    return $renderer->render($response, '/home/home.php', $viewData);
})->setName('profile');


// Add routes : create event->get
$app->get('/create_event', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $viewData = [
        'name' => 'Create Event'
    ];

    return $renderer->render($response, '/create_event/create_event.php', $viewData);
})->setName('profile');

// Add routes : create event->post
$app->post('/create_event', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $requestData = $request->getParsedBody();

    //verification
    foreach ($requestData as $key => $value) {
        if ($key == "imgUrl" && empty($value)) {
            $value = "https://i.ibb.co/hCtYydv/foo.png";
            $data[$key] = $value;
        } else {
            if ($value === "") {
                $value = "AUCUN";
            }
        }
        $data_t = trim($value);
        $data_t = stripslashes($data_t);
        $data_t = strip_tags($data_t);
        $data_t = htmlspecialchars($data_t);
        $requestData[$key] = $data_t;
    }

    //enregistrement de l'entite
    //->si les donnees sont valide
    if (!($requestData["title"] == "AUCUN" || $requestData["description"] == "AUCUN")) {
        //-> get user before
        $user = $GLOBALS["em"]->getRepository(User::class)->find($requestData["promotedBy"]);

        $createEvent = (new Event())->setTitle($requestData["title"])
            ->setDescription($requestData["description"])
            ->setImgUrl($requestData["imgUrl"])
            ->setPromotedBy($user);

        $GLOBALS["em"]->persist($createEvent);
        $GLOBALS["em"]->flush();
    }

    // Get all POST parameters
    $viewData = [
        "requestData" => $requestData,
        "name" => "Create Event"
    ];

    return $renderer->render($response, '/create_event/create_event.php', $viewData);
})->setName('profile');

//Add routes : singin
$app->post('/signin', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $requestData = $request->getParsedBody();

    //clean data
    foreach ($requestData as $key => $value) {
        $data_t = trim($value);
        $data_t = stripslashes($data_t);
        $data_t = strip_tags($data_t);
        $data_t = htmlspecialchars($data_t);
        $requestData[$key] = $data_t;
    }

    //user
    $user = $GLOBALS["em"]->getRepository(User::class)->findBy(array('email' => $requestData["userEmail"]));

    if (count($user) == 0) {
        $user[] = [];
    }

    $viewData = [
        "pwdEnter" => $requestData["userPassword"],
        "user" => $user[0],
        "name" => "Create Event"
    ];

    return $renderer->render($response, '/create_event/create_event.php', $viewData);
})->setName('profile');

// Add routes : logout
$app->get('/logout', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $viewData = [
        "name" => "Home Page"
    ];

    return $renderer->render($response, '/logout/logout.php', $viewData);
})->setName('profile');

//Add routes : articles {slug}
$app->get('/single_event/{slug}', function ($request, $response, $args) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    //get attribut slug and after find article
    $slug = $request->getAttribute('slug');
    $eventRepo = $GLOBALS["em"]->getRepository(Event::class);
    $events = $eventRepo->findOneBySlug($slug);

    // $resuuu = $events->getEventParticipated()->getValues();
    // var_dump($resuuu[0]->getId);
    // exit(1);

    $viewData = [
        "events" => $events,
        "name" => "Event Details"
    ];

    return $renderer->render($response, '/single_event/single_event.php', $viewData);
})->setName('profile');

//Add routes : take part (inscription à un evenement) : get
$app->get('/participate/{slug}/{id}', function ($request, $response, $args) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    //get attribut slug and after inscrire à levenement à defaut invite a creer un compte
    $slug = $request->getAttribute('slug');
    $user_id = $request->getAttribute('id');

    $eventRepo = $GLOBALS["em"]->getRepository(Event::class);
    $events = $eventRepo->findOneBySlug($slug);

    $userRepo = $GLOBALS["em"]->getRepository(User::class);
    $user = $userRepo->find($user_id);

    //add user to event if $user is type of object
    $message = "echec, creez un compte pour continuer !";
    if (gettype($user) === "object") {
        // $res = $events->setEventParticipated($user);
        $res = $events->addEventParticipated($user);
        // var_dump($user->getId());
        $GLOBALS["em"]->persist($events);
        $GLOBALS["em"]->flush();
        $message = "participation enregistrée";
    }

    $viewData = [
        "events" => $events,
        "message" => $message,
        "name" => "Event Details"
    ];

    return $renderer->render($response, '/single_event/single_event.php', $viewData);
})->setName('profile');

// Add routes : participate : get
$app->get('/participate_event/{id}', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    //get id
    $user_id = $request->getAttribute('id');

    //get all events
    $eventRepo = $GLOBALS["em"]->getRepository(Event::class);
    $events = $eventRepo->findAll();

    $userRepo = $GLOBALS["em"]->getRepository(User::class);
    $user = $eventRepo->find($user_id);

    $user_events = [];
    // var_dump($events[2]->getEventParticipated()->getValues()[0]->getId());
    // exit(1);

    foreach ($events as $value) {
        $participator_table = $value->getEventParticipated()->getValues();
        foreach ($participator_table as $participator) {
            if ($participator->getId() == $user_id) {
                $user_events[] = $value;
            }
        }
    }
    // var_dump($user_events);
    // exit(1);

    $viewData = [
        "events" => $user_events,
        "name" => "Participate Event"
    ];

    return $renderer->render($response, '/home/home.php', $viewData);
})->setName('profile');

//Add routes : create_account : post
$app->post('/create_account', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $requestData = $request->getParsedBody();

    //clean data
    foreach ($requestData as $key => $value) {
        $data_t = trim($value);
        $data_t = stripslashes($data_t);
        $data_t = strip_tags($data_t);
        $data_t = htmlspecialchars($data_t);
        $requestData[$key] = $data_t;
    }

    //verifiy if email exist
    $user = $GLOBALS["em"]->getRepository(User::class)->findBy(array('email' => $requestData["email"]));

    $message_error = "";

    if (count($user) > 0) {
        $message_error = "this email is already register !";
        $user[0] = [];
    } else {
        //create user
        $createUser = (new User())->setFullname($requestData["fullname"])
            ->setSexe($requestData["sexe"])
            ->setEmail($requestData["email"])
            ->setPassword(sha1($requestData["password"]))
            ->setAge($requestData["age"]);

        $GLOBALS["em"]->persist($createUser);
        $GLOBALS["em"]->flush();

        $user = $GLOBALS["em"]->getRepository(User::class)->findBy(array('email' => $requestData["email"]));
    }

    $viewData = [
        "pwdEnter" => $requestData["password"],
        "user" => $user[0],
        "name" => "Create Event",
        "message_error" => $message_error
    ];

    return $renderer->render($response, '/create_event/create_event.php', $viewData);
})->setName('profile');

$app->add(function (Request $request, RequestHandler $handler) {
    $method = $request->getMethod();
    return $handler->handle($request);
});

// Run app
$app->run();
