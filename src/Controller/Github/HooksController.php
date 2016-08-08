<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/6/16
 * Time: 7:59 PM
 */

namespace Com\Youzan\ZanPhpIo\Controller\Github;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;
use Com\Youzan\ZanPhpIo\Github\Service\HooksService;
use Zan\Framework\Foundation\Core\Config;

class HooksController extends Controller
{
    private $config;
    private $secret;
    private $event;
    private $delivery;

    public function updateDoc()
    {
        $this->config = Config::get('hooks.doc');
        $this->secret = $this->config['secret'];

        if (!$this->validate()) {
            yield $this->r(10001, 'invalid secret!', null);
            return;
        }

        $service = new HooksService($this->config);
        try {
            yield $service->updateDoc();
        } catch (\RuntimeException $e) {
            yield $this->r(10001, 'update doc failed', null);
            return;
        }
        yield $this->r(0, 'success', null);
    }

    private function validate()
    {
        $headers = $this->request->headers;
        $signature = $headers->get('x-hub-signature');
        $event = $headers->get('x-github-event');
        $delivery = $headers->get('x-github-delivery');
        $payload = $this->request->getContent();

        if (!isset($signature, $event, $delivery)) {
            return false;
        }
        if (!$this->validateSignature($signature, $payload)) {
            return false;
        }

        $this->event = $event;
        $this->delivery = $delivery;
        return true;
    }

    protected function validateSignature($gitHubSignatureHeader, $payload)
    {
        list ($algo, $gitHubSignature) = explode("=", $gitHubSignatureHeader);
        if ($algo !== 'sha1') {
            // see https://developer.github.com/webhooks/securing/
            return false;
        }
        $payloadHash = hash_hmac($algo, $payload, $this->secret);
        return ($payloadHash === $gitHubSignature);
    }

}
