<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/6/16
 * Time: 7:59 PM
 */

namespace Com\Youzan\ZanPhpIo\Controller\Git;


use Com\Youzan\ZanPhpIo\Controller\Base\BaseController as Controller;
use Com\Youzan\ZanPhpIo\Git\Service\HooksService;
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
        $signature = @$_SERVER['HTTP_X_HUB_SIGNATURE'];
        $event = @$_SERVER['HTTP_X_GITHUB_EVENT'];
        $delivery = @$_SERVER['HTTP_X_GITHUB_DELIVERY'];
        $payload = file_get_contents('php://input');

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
