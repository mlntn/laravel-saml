<?php

namespace Mlntn\LaravelSaml;

use Mlntn\LaravelSaml\Contracts\User;
use Saml;
use Cookie;

class Account {

  /**
   * @var User
   */
  protected $user;

  public function __construct(User $user) {
    $this->user = $user;
  }

  protected function getSamlIdProperty() {
    return config('saml.saml_id_property', 'email');
  }

  public function exists($id) {
    return $this->user->exists($id);
  }

  public function samlLogged() {
    return Saml::isAuthenticated();
  }

  public function samlLogin() {
    return Saml::requireAuth();
  }

  public function laravelLogin($id) {
    $user = $this->user->get($id);

    auth()->login($user);
  }

  public function setupUser($id) {
    return $this->user->setup($id);
  }

  public function getSamlAttribute($attribute) {
    $data = Saml::getAttributes();

    return $data[$attribute][0];
  }

  public function getSamlUniqueIdentifier() {
    return $this->getSamlAttribute($this->getSamlIdProperty());
  }

  public function laravelLogged() {
    return auth()->check();
  }

  public function logout() {
    auth()->logout();
    $auth_cookie = Cookie::forget('SimpleSAMLAuthToken');

    return $auth_cookie;
  }
}
