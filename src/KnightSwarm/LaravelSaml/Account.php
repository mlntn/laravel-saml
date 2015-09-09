<?php

namespace KnightSwarm\LaravelSaml;

use Saml;
use User;
use Cookie;

class Account {

  protected function getUserIdProperty() {
    return config('saml.internal_id_property', 'email');
  }

  protected function getSamlIdProperty() {
    return config('saml.saml_id_property', 'email');
  }

  public function IdExists($id) {
    $property = $this->getUserIdProperty();
    $check = config('saml.user.check');
    $user = call_user_func($check, $property, $id);

    return $user === 0 ? false : true;
  }

  public function samlLogged() {
    return Saml::isAuthenticated();
  }

  public function samlLogin() {
    Saml::requireAuth();
  }

  public function laravelLogin($id) {
    if ($this->IdExists($id)) {
      $property = $this->getUserIdProperty();
      $find = config('saml.user.find');
      $user = call_user_func($find, $property, $id);

      auth()->login($user);
    }
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

  /**
   * If mapping between saml attributes and object attributes are defined
   * then fill user object with mapped values.
   */
  protected function fillUserDetails($user) {
    $mappings = config('laravel-saml::saml.object_mappings', []);
    foreach ($mappings as $key => $mapping) {
      $user->{$key} = $this->getSamlAttribute($mapping);
    }
  }

  public function createUser() {
    $user                               = new User();
    $user->{$this->getUserIdProperty()} = $this->getSamlUniqueIdentifier();
    $this->fillUserDetails($user);
    $user->save();
    $this->laravelLogin($user->{$this->getUserIdProperty()});
  }

  public function logout() {
    auth()->logout();
    $auth_cookie = Cookie::forget('SimpleSAMLAuthToken');

    return $auth_cookie;
  }
}
