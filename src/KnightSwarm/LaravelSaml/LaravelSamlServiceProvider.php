<?php

namespace Mlntn\LaravelSaml;

use Illuminate\Support\ServiceProvider;

class LaravelSamlServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot() {
    $this->publishes([
      __DIR__.'/../../config/saml.php' => config_path('saml.php'),
    ]);
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {

    app()->bind('Saml', function () {
      $samlboot = new Saml\SamlBoot(config('saml.sp_name', 'default-sp'));

      return $samlboot->getSimpleSaml();
    });
  }

}
