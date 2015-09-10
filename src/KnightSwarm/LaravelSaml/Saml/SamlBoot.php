<?php

namespace Mlntn\LaravelSaml\Saml;

use SimpleSAML_Configuration;

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
    SimpleSAML_Configuration::setConfigDir(base_path('saml'));

    return new \SimpleSAML_Auth_Simple($this->sp_resolver);
  }

}
