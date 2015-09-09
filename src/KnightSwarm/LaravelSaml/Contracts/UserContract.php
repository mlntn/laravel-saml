<?php

namespace KnightSwarm\Contracts;

interface UserContract {

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