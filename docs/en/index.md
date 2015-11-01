Quickstart
==========


Installation
------------

The best way to install FreezyBee/MojeId is using  [Composer](http://getcomposer.org/):

```sh
$ composer require freezy-bee/moje-id
```

With Nette `2.3` and newer, you can enable the extension using your neon config.

```yml
extensions:
	mojeId: FreezyBee\MojeId\DI\MojeIdExtension
```

Full configuration
------------------

```yml
mojeId:
	serverUrl: "https://mojeid.fred.nic.cz/" # default https://mojeid.cz/
	policy: [password, certificate, physical] # default [password]
	fieldsType: full # default simple
```

But you don't need to enter anything... 


Debugging
---------

The extension monitors request and response, when in debug mode. All that information is available in Tracy panel



Example
-------

```php
class SignPresenter extends BasePresenter
{

	/** @var \FreezyBee\MojeId\MojeId @inject */
	public $mojeId;

	/** @var UsersModel @inject */
	public $usersModel;

	public function actionMojeId()
	{
		// register onResponse must be BEFORE calling tryLogin
		$this->mojeId->onResponse[] = function (Nette\Utils\ArrayHash $person) {
			
			$user = $this->usersModel->findUserByMojeId($person->identity);

			if ($user === null) {
				$user = $this->usersModel->registerMojeIdUser($person);
			}

			$this->user->login($user->name);
		};

		try {
			$this->mojeId->tryLogin();
		} catch (\FreezyBee\MojeId\Exceptions\MojeIdException $e) {
			Debugger::log($e);
			...
		}
	}
}
```

IMPORTANT !!!
-------------

In layout you MUST add this line - content = absolute path to xrds.xml file. 
It is necessarily for server mojeid.cz. And you MUST fill correct returnTo address.

```smarty
<meta http-equiv="x-xrds-location" content="{$baseUrl}/pathToXrds.xml"/>
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<xrds:XRDS xmlns:xrds="xri://$xrds" xmlns="xri://$xrd*($v*2.0)">
    <XRD>
        <Service>
            <Type>http://specs.openid.net/auth/2.0/return_to</Type>
            <URI>** FILL returnTo URL **</URI>
        </Service>
    </XRD>
</xrds:XRDS>
```