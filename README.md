opauth-soundcloud-strategy
=============
[Opauth][1] strategy for Soundcloud authentication.

Implemented based on http://developers.soundcloud.com/docs#authentication

Getting started
----------------
1. Install opauth-soundcloud-strategy:
   ```bash
   cd path_to_opauth/Strategy
   git clone git@github.com:fuyi/opauth-soundcloud-strategy.git Soundcloud
   ```

2. Create Soundcloud application at http://soundcloud.com/you/apps
   - Important: set your app redirect URI to http://path_to_opauth/soundcloud/int_callback, if your authentication endpoint is at http://path_to_opauth

3. Configure Opauth Soundcloud strategy with at least `Client ID` and `Secret`.

4. Direct user to `http://path_to_opauth/soundcloud` to authenticate

Strategy configuration
----------------------

Required parameters:

```php
<?php
'Soundcloud' => array(
   'client_id' => 'Your client ID',
   'secret' => 'Your secret'
)
```

License
---------
opauth-soundcloud-strategy is MIT Licensed  
Copyright © 2013 fuyi (yvesfu@gmail.com)

[1]: https://github.com/uzyn/opauth