<?php

namespace KnightSwarm\LaravelSaml\Controllers;

use Illuminate\Routing\Controller as BaseController;
use KnightSwarm\LaravelSaml\Account;

class SamlController extends BaseController {

  private $account;

  public function __construct(Account $account) {
    $this->account = $account;
  }

  public function login() {
    if (request()->has('url')) {
      // only allow local urls as redirect destinations
      $url = request()->input('url');
      if (!preg_match("~^(//|[^/]+:)~", $url)) {
        session()->flash('url.intended', $url);
      }
    }

    if (!$this->account->samlLogged()) {
      auth()->logout();
      $this->account->samlLogin();
    }

    if ($this->account->samlLogged()) {
      $id = $this->account->getSamlUniqueIdentifier();
      if (!$this->account->IdExists($id)) {
        if (config('laravel-saml::saml.can_create', true)) {
          $this->account->createUser();
        }
        else {
          return response(config('laravel-saml::saml.can_create_error'), 400);
        }
      }
      else {
        if (!$this->account->laravelLogged()) {
          $this->account->laravelLogin($id);
        }
      }
    }

    if ($this->account->samlLogged() && $this->account->laravelLogged()) {
      $intended = str_replace(config('app.url'), '', session('url.intended'));
      session()->flash('url.intended', $intended);

      return redirect()->intended('/');
    }

  }

  public function logout() {
    $auth_cookie = $this->account->logout();

    return redirect()->to(config('laravel-saml::saml.logout_target', 'http://' . $_SERVER['SERVER_NAME']))->withCookie($auth_cookie);
  }

}
