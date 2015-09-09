<?php

namespace KnightSwarm\LaravelSaml\Controllers;

use Illuminate\Routing\Controller as BaseController;
use KnightSwarm\Contracts\UserContract;
use KnightSwarm\LaravelSaml\Account;

class SamlController extends BaseController {

  private $account;

  public function __construct(UserContract $user) {
    $this->account = new Account($user);
  }

  public function login() {
    if (request()->has('url')) {
      // only allow local urls as redirect destinations
      $url = request()->input('url');
      if (!preg_match("~^(//|[^/]+:)~", $url)) {
        session()->flash('url.intended', $url);
      }
    }

    if ($this->account->samlLogged()) {
      $id = $this->account->getSamlUniqueIdentifier();

      if ($this->account->exists($id)) {
        if ($this->account->laravelLogged() === false) {
          $this->account->laravelLogin($id);
        }

        $intended = str_replace(config('app.url'), '', session('url.intended'));
        session()->flash('url.intended', $intended);

        return redirect()->intended('/');
      }
      else {
        return $this->account->setupUser($id);
      }
    }
    else {
      auth()->logout();
      return $this->account->samlLogin();
    }
  }

  public function logout() {
    $auth_cookie = $this->account->logout();

    return redirect()->to(config('saml.logout_target', config('app.url')))->withCookie($auth_cookie);
  }

}
