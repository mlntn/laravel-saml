<?php

namespace Mlntn\LaravelSaml\Facades;

use Illuminate\Support\Facades\Facade;

class Saml extends Facade {

  protected static function getFacadeAccessor() {
    return 'Saml';
  }

} 