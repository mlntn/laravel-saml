laravel-saml
============

Open Source SAML Auth Support for Laravel using simplesamlphp.


#### Requeriments
- Laravel install, of course
- Working SimpleSAMLphp instance acting like an Service Provider


#### Instalation

First, we need this package available on Laravel, update your `composer.json` dependencies with:
    
    "knight-swarm/laravel-saml": "dev-master"
and run `composer update`

After we have this package, we need to load it on Laravel, for this, add this

    'KnightSwarm\LaravelSaml\LaravelSamlServiceProvider'

service provider on the `'providers'` array (`config/app.php`)

and the 

    'Saml'      => 'KnightSwarm\LaravelSaml\Facades\Saml'

 facade on the `'aliases'` array.
 
 
 Now, we need to configure it, run
 
     php artisan vendor:publish
    
 the above command will create a `saml.php` file inside `config`, edit this file and be sure to insert:
 
 Your default SP id
 
     'sp_name' => 'saml.dev',
     
 And after logout, where users, should go,
 
     'logout_target' => 'http://saml.dev'
     
You will need to setup routes like this:

    Route::post('sso/login', '\KnightSwarm\LaravelSaml\Controllers\SamlController@login');
    Route::post('sso/logout', '\KnightSwarm\LaravelSaml\Controllers\SamlController@logout');


