<?php
        require_once __DIR__."/../vendor/autoload.php";
        require_once __DIR__."/../src/Restaurant.php";
        require_once __DIR__."/../src/Cuisine.php";
        use Symfony\Component\HttpFoundation\Request;
        Request::enableHttpMethodParameterOverride();

        $app = new Silex\Application();
        $app['debug'] = true;

        $DB = new PDO('pgsql:host=localhost;dbname=yelp');

        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../views'
        ));

        $app->get("/", function() use ($app) {
            return $app['twig']->render('index.html.twig', array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
        });

        $app->post("/cuisine", function() use ($app){
             $new_cuisine = new Cuisine($_POST['cuisine_type']);
             $new_cuisine->save();
             return $app ['twig']->render('cuisine.html.twig', array('cuisine' => $new_cuisine));
        });

        $app->get("/cuisines/{id}/edit", function($id) use ($app) {
            $found_cuisine = Cuisine::search($id);
            return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $found_cuisine));
        });

        $app->patch("/cuisines/{id}", function($id) use ($app) {
            $type = $_POST['type'];
            $cuisine = Cuisine::search($id);
            $cuisine->update($type);
            return $app ['twig']->render('cuisine.html.twig', array ('cuisine' => $cuisine));
        });

        $app->post("/restaurant", function() use ($app){
            $new_restaurant = new Restaurant($_POST['name']);
            $new_restaurant->save();
            $restaurants = Restaurant::getAll();

             return $app['twig']->render('restaurant.html.twig', array('restaurants' => $restaurants, 'restaurant' => $new_restaurant));

        });

        $app->get("/restaurants/{id}/edit", function($id) use ($app){
            $found_restaurant = Restaurant::search($id);
            return $app['twig']->render('restaurant_edit.html.twig', array ('restaurant' => $found_restaurant));
        });

        $app->get("/new_page/{id}", function($id) use ($app){
                $cuisine = Cuisine::search($id);
                return $app['twig']->render('new_page.html.twig', array ('cuisine' => $cuisine, 'restaurants'=>$cuisine->getRestaurants()));
        });

        $app->post("/new_page", function() use ($app){
                $new_name = $_POST['name1'];
                $cuisine_id = $_POST['cuisine_id'];

                $new_category_restaurant = new Restaurant($new_name, $id = null, $cuisine_id);
                $new_category_restaurant->save();
                $cuisine = Cuisine::search($cuisine_id);

            return $app['twig']->render('new_page.html.twig', array('cuisine' => $cuisine,
            'restaurants' => Cuisine::getAll()));
        });

        $app->patch("/restaurants/{id}", function($id) use ($app) {
            $restaurant_type = $_POST['restaurant_name'];
            $restaurant = Restaurant::search($id);
            $restaurant->update($restaurant_type);
            return $app['twig']->render('restaurant.html.twig', array ('restaurant' => $restaurant));
        });

        $app->delete("cuisines/{id}", function ($id) use ($app) {
            $cuisine = Cuisine::search($id);
            $cuisine->delete();
            return $app['twig']->render('index.html.twig', array ('cuisines'=> Cuisine::getAll(), 'restaurants' => Restaurant::getAll()));
        });

        $app->post("/delete", function() use ($app) {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
            return $app['twig']->render('index.html.twig', array('restaurants' => Restaurant::deleteAll(), 'cuisines' => Cuisine::deleteAll()));
        });

        return $app;


?>
