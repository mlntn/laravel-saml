<?php

return array(

  /*
  |--------------------------------------------------------------------------
  | laravel-saml config file
  |--------------------------------------------------------------------------
  |
  | Here you need to specify a working phpsimplesaml install working as
  | a Service Provider already connected (or acting like) a Identity provider
  |
  */

  /*
   * The service provider name
   */
  'sp_name'          => 'best-venue',

  /*
   * The redirect destination after logging out
   */
  'logout_target'    => config('app.url'),

  'user'             => [
    'check' => function ($property, $id) {
      // TODO: put your own logic here, should return a boolean
      return false;
    },

    'find'  => function ($property, $id) {
      // TODO: put your own logic here, should return a user model object
      return null;
    },
  ],

  /*
   * Internal id property, defaults to email.
   * The property to identify users by in the system.
   * 'internal_id_property' => 'email',
   */

  /*
   * Saml id property defaults to email, the property
   * in the saml packet which should be mapped to the
   * internal id property.
   *
   */
  'saml_id_property' => 'uid',

  /*
   * object_mappings.
   * an array of string with string keys.
   * Key is a value on your User object, value is the
   * SAML value that this is mapped to.
   * When user is created these values will be copied
   * to your user object.
   *
   * 'object_mappings' => [
   *  'email' => 'email',
   * ],
   */

  /*
   * can_create and can_create_error.
   * If you don't want users to be created via saml set can_create to false.
   * They will then be presented with an error and the value of can_create_error.
   * 'can_create' => false,
   * 'can_create_error' => 'You can not register on this system.',
   */
);
