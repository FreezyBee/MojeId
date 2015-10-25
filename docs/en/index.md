Quickstart
==========


Installation
-----------

The best way to install FreezyBee/MojeId is using  [Composer](http://getcomposer.org/):

```sh
$ composer require freezy-bee/moje-id
```

With Nette `2.3` and newer, you can enable the extension using your neon config.

```yml
extensions:
	mojeId: FreezyBee\MojeId\DI\MojeIdExtension
```

        'serverUrl' => 'https://mojeid.cz/',
        'policy' => [],
        'fieldsType' => 'simple',
        'debugger' => '%debugMode%',
        'tempDir' => '%tempDir%'


Full configuration
---------------------

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

	/** @var UsersModel */
	private $usersModel;

	/*
	 *	@param $request - required !!!
	 */
	public function actionMojeId($request)
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
			// $request is required !!!
			$this->mojeId->tryLogin($request);
		} catch (\FreezyBee\MojeId\Exceptions\MojeIdException $e) {
			Debugger::log($e);
			...
		}
	}
}
```

In layout you MUST add this line - content = absolute path to mojeId action with parameter 'request' => 'xrds' 
It is necessarily for server mojeid.cz.

```smarty
<meta http-equiv="x-xrds-location" content="{plink //Sign:mojeId, request => xrds}"/>
```
