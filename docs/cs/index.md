Nápověda
========


Instalace
---------

Nejsnazší způsob instalace FreezyBee/MojeId je přes [Composer](http://getcomposer.org/):

```sh
$ composer require freezy-bee/moje-id
```

S Nette `2.3` určitě použijte registraci přes neon config.

```yml
extensions:
	mojeId: FreezyBee\MojeId\DI\MojeIdExtension
```

Celková konfigurace
-------------------

```yml
mojeId:
	serverUrl: "https://mojeid.fred.nic.cz/" # <- oficiální testovací server, default je -> https://mojeid.cz/
	policy: [password, certificate, physical] # <- způsoby ověření klienta, default je -> nic
	fieldsType: full # <- dotazovat se na všechny údaje, default je -> simple
```
Pokud už netestujete, tak konfigurace je vlastně nepotřebná...


Debugging
---------

Rozšíření monitoruje požadavky a odpovědi na mojeid.cz server. Informace jsou v Tracy panelu.


Příklad
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
		// registrujte listener onResponse vždy před voláním metody tryLogin!!!
		$this->mojeId->onResponse[] = function (Nette\Utils\ArrayHash $person) {
			
			// $person->identity obsahuje jedinečný identifikátor uživatele
			$user = $this->usersModel->findUserByMojeId($person->identity);

			// pokud jsme ho v DB nenalezli (je u nás poprvé), tak bude dobré ho vytvořit
			if ($user === null) {
				$user = $this->usersModel->registerMojeIdUser($person);
			}

			// login uživatele
			$this->user->login($user->name);
		};

		try {
			$this->mojeId->tryLogin();
		} catch (\FreezyBee\MojeId\Exceptions\MojeIdException $e) {
		
			// MojeIdException odchytává většinu nenormálních stavů
			Debugger::log($e);
			...
		}
	}
}
```

DŮLEŽITÉ !!!
------------

V šabloně je nutné do html headeru na hlavní stránku domény uvést meta tag (viz. dole).

V content je nutné uvést absolutní odkaz na soubor xrds.xml, v kterém je nutné upravit returnTo adresu. Je to nezbytné z důvodu ověření xrds serverem mojeid.cz.

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