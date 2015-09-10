<?php

namespace Mlntn\LaravelSaml\Contracts;

interface User {

  /**
   * @param string $identifier
   * @return boolean
   */
  public function exists($identifier);

  /**
   * @param string $identifier
   * @return mixed
   */
  public function get($identifier);

  /**
   * @param string $identifier
   * @return mixed
   */
  public function setup($identifier);

}