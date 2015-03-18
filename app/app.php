<?php
        require_once __DIR__."/../vendor/autoload.php";
        require_once __DIR__."/../src/Restaurant.php";
        require_once __DIR__."/../src/Cuisine.php";

        $app = new Silex\Application();
        $app['debug'] = true;

        $DB = new PDO('pgsql:host=localhost;dbname=yelp');

        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../views'
        ));

        $app->get("/", function() use ($app) {
            return $app['twig']->render('index.html.twig', array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
        });

        $app->post("/", function() use ($app){
            if ($_POST['name'] = null )
            {
            $new_restaurant = new Restaurant($_POST['name']);
            $new_restaurant->save();
            $restaurants = Restaurant::getAll();
            return $app['twig']->render('index.html.twig', array('restaurants' => $restaurants);
            $new_cuisine = new Cuisine($_POST['cuisine_type']);
            $new_cuisine->save();
            $cuisines = Cuisine::getAll();
            return $app['twig']->render('index.html.twig', array('restaurants' => $restaurants, 'cuisines' => $cuisines));
        });


        $app->post("/delete_restaurant", function() use ($app) {
            $restaurants = Restaurant::deleteAll();
            return $app['twig']->render('restaurant.html.twig', array('restaurants' => $restaurants));
        });

        $app->post("/cuisine", function() use ($app){
            $cuisines = Cuisine::getAll();
            return $app['twig']->render('cuisine.html.twig', array('cuisines' => $cuisines ));

        });







        return $app;


?>
