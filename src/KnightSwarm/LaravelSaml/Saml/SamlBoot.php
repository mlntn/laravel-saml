<?php

namespace KnightSwarm\LaravelSaml\Saml;

class SamlBoot {

  protected $path;
  protected $sp;
  protected $saml;

  public function __construct($samlSpResolver) {
    $this->sp_resolver = $samlSpResolver;
    $this->saml        = $this->setupSimpleSaml();
  }

  public function getSimpleSaml() {
    return $this->saml;
  }

  protected function setupSimpleSaml() {
    return new \SimpleSAML_Auth_Simple($this->sp_resolver);
  }

}
