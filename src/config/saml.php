<?php

return [

  /*
   * The service provider name
   */
  'sp_name'          => 'sp',

  /*
   * The redirect destination after logging out
   */
  'logout_target'    => config('app.url'),

  /*
   * Saml id property defaults to email, the property
   * in the saml packet which should be mapped to the
   * internal id property.
   *
   */
  'saml_id_property' => 'uid',
];
