<?php

namespace FreezyBee\MojeId;

use FreezyBee\MojeId\Exceptions\MojeIdException;
use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Utils\ArrayHash;

/**
 * Class MojeId
 * @package App\Model
 * @method onRequest(\Auth_OpenID_AuthRequest $authRequest)
 * @method onResponse(ArrayHash $person, \Auth_OpenID_ConsumerResponse $response)
 */
class MojeId
{
    use \Nette\SmartObject;
    
    /** @var callable[]  function (\Auth_OpenID_AuthRequest $authRequest); */
    public $onRequest = [];

    /** @var callable[]  function (ArrayHash $person, Auth_OpenID_ConsumerResponse $response); */
    public $onResponse = [];

    /**
     * @var string
     */
    private $tempDir;

    /**
     * @var array
     */
    private $config;

    /**
     * @var Request
     */
    private $httpRequest;

    /**
     * @var Response
     */
    private $httpResponse;

    /**
     * @var \Auth_OpenID_FileStore
     */
    private $store;

    /**
     * @var array
     */
    private $extAttributes;

    /**
     * @param array $config
     * @param Request $httpRequest
     * @param Response $httpResponse
     */
    public function __construct(array $config, Request $httpRequest, Response $httpResponse)
    {
        $this->tempDir = $config['tempDir'];
        $this->config = $config;
        $this->httpRequest = $httpRequest;
        $this->extAttributes = Attributes::getFields($config['fieldsType']);
        $this->httpResponse = $httpResponse;

        $this->disableRandSource();
    }

    private function disableRandSource()
    {
        ob_start();

        if (!@is_readable('/dev/urandom')) {
            define('Auth_OpenID_RAND_SOURCE', null);
        }

        ob_end_clean();
    }

    /**
     * @return \Auth_OpenID_FileStore
     */
    private function getStore()
    {
        if ($this->store === null) {
            $this->store = new \Auth_OpenID_FileStore($this->tempDir);
        }

        return $this->store;
    }

    /**
     * @return string
     */
    private function getReturnTo()
    {
        $url = $this->httpRequest->getUrl();
        return trim($url->getHostUrl() . $url->getPath(), '/') . '/';
    }

    /**
     * @return string
     */
    private function getTrustRoot()
    {
        return $this->httpRequest->getUrl()->getBaseUrl();
    }

    /**
     * @return \Auth_OpenID_Consumer
     */
    private function getConsumer()
    {
        return new \Auth_OpenID_Consumer($this->getStore());
    }

    /**
     * @return string
     */
    private function getEndPoint()
    {
        return $this->config['serverUrl'] . 'endpoint/';
    }

    /**
     * @param \Auth_OpenID_AX_FetchResponse $response
     * @param $identity
     * @return ArrayHash
     */
    private function processAxResponse(\Auth_OpenID_AX_FetchResponse $response, $identity)
    {
        $tmp['identity'] = $identity;

        foreach ($this->extAttributes as $key => $value) {
            $tmp[$key] = (isset($response->data[$value['scheme']][0]) ? $response->data[$value['scheme']][0] : '');
        }

        return ArrayHash::from($tmp);
    }

    /**
     * @throws MojeIdException
     */
    private function begin()
    {
        /** @var \Auth_OpenID_Consumer $consumer */
        $consumer = $this->getConsumer();

        /** @var \Auth_OpenID_AuthRequest $authRequest */
        $authRequest = $consumer->begin($this->getEndPoint());

        if (!$authRequest) {
            throw new MojeIdException('FAILED TO CREATE AUTH REQUEST: not a valid OpenID - ' . $this->getEndPoint());
        }

        $axRequest = new \Auth_OpenID_AX_FetchRequest();

        foreach ($this->extAttributes as $id => $data) {
            $axRequest->add(new \Auth_OpenID_AX_AttrInfo($data['scheme'], 1, $data['required'], $id));
        }

        $authRequest->addExtension($axRequest);

        // add policy
        if ($this->config['policy']) {
            $authRequest->addExtension(new \Auth_OpenID_PAPE_Request($this->config['policy']));
        }

        if ($authRequest->shouldSendRedirect() || 1) {
            $redirectUrl = $authRequest->redirectURL($this->getTrustRoot(), $this->getReturnTo());

            if (\Auth_OpenID::isFailure($redirectUrl)) {
                throw new MojeIdException('Could not redirect to server: ' . $redirectUrl->message);
            }

            $this->httpResponse->setHeader('Location', $redirectUrl);
            $this->httpResponse->setCode(Response::S301_MOVED_PERMANENTLY);

        } else {
            $formHtml = $authRequest->htmlMarkup(
                $this->getTrustRoot(),
                $this->getReturnTo(),
                false,
                ['id' => 'mojeid_form']
            );

            if (\Auth_OpenID::isFailure($formHtml)) {
                throw new MojeIdException('Could not redirect to server: ' . $formHtml->message);
            }

            echo $formHtml;
        }

        $this->onRequest($authRequest);
    }

    /**
     * @return ArrayHash
     * @throws MojeIdException
     */
    private function complete()
    {
        $consumer = $this->getConsumer();
        $response = $consumer->complete($this->getReturnTo());

        if ($response->status == Auth_OpenID_CANCEL) {
            throw new MojeIdException('Verification cancelled');
        } elseif ($response->status == Auth_OpenID_FAILURE) {
            throw new MojeIdException('OpenID authentication failed: ' . $response->message);
        } elseif ($response->status == Auth_OpenID_SUCCESS) {
            $identity = (isset($response->endpoint->claimed_id) ?
                $response->endpoint->claimed_id :
                $response->getDisplayIdentifier());

            $axResponse = \Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);

            if ($axResponse) {
                $person = $this->processAxResponse($axResponse, $identity);
                $this->onResponse($person, $response);
            } else {
                throw new MojeIdException('Invalid axResponse');
            }
        }

        throw new MojeIdException('Unknown status');
    }

    public function tryLogin()
    {
        if ($this->httpRequest->getPost()) {
            $this->complete();
        } else {
            $this->begin();
        }
    }
}
