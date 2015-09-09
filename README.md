laravel-saml
============

Open Source SAML Auth Support for Laravel using simplesamlphp.


#### Requirements
- Laravel install, of course
- Working SimpleSAMLphp instance acting like an Service Provider


#### Installation

First, we need this package available on Laravel, update your `composer.json` dependencies with:
    
    "jmellentine/laravel-saml": "dev-master"
    
and run `composer update`

After we have this package, we need to load it on Laravel, for this, add this service provider to the `'providers'` array in `config/app.php`

    'KnightSwarm\LaravelSaml\LaravelSamlServiceProvider'



and the 

    'Saml' => 'KnightSwarm\LaravelSaml\Facades\Saml'

 facade on the `'aliases'` array.
 
 
 Now, we need to configure it, run the following to create a `saml.php` file inside `config`:
 
     php artisan vendor:publish
     
You will need to setup routes like this:

    Route::post('sso/login', '\KnightSwarm\LaravelSaml\Controllers\SamlController@login');
    Route::post('sso/logout', '\KnightSwarm\LaravelSaml\Controllers\SamlController@logout');


You will also need to create a service provider class that implements `KnightSwarm\LaravelSaml\Contracts\User` and register that class in AppServiceProvider.

Here is an example implementation:

```php
<?php

namespace App\Services;

use App\Models\User;
use KnightSwarm\LaravelSaml\Contracts\User as UserContract;

class SamlUser implements UserContract {

  /**
   * @param string $identifier
   * @return boolean
   */
  public function exists($identifier) {
    return User::join('user_saml', 'user.id', '=', 'user_id')->whereSamlIdentifier($identifier)->count() > 0;
  }

  /**
   * @param string $identifier
   * @return mixed
   */
  public function get($identifier) {
    return User::select('user.*')->join('user_saml', 'user.id', '=', 'user_id')->whereSamlIdentifier($identifier)->firstOrFail();
  }

  /**
   * @param string $identifier
   * @return mixed
   */
  public function setup($identifier) {
    if (auth()->check()) {
      $user = auth()->user();
      $user->setSamlIdentifier($identifier);
      $user->save();

      return redirect()->intended('/');
    }
    else {
      session()->flash('saml_identifier', $identifier);

      return redirect()->to('/auth/login');
    }
  }

}
```