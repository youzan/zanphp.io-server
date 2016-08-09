<?php

/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/9/16
 * Time: 1:12 PM
 */

namespace Com\Youzan\ZanPhpIo\Middleware;

use Zan\Framework\Contract\Network\Request;
use Zan\Framework\Contract\Network\RequestFilter;
use Zan\Framework\Foundation\Core\Config;
use Zan\Framework\Network\Http\Response\JsonResponse;
use Zan\Framework\Utilities\DesignPattern\Context;

class GithubFilter implements RequestFilter
{
    private $config;
    private $secret;
    private $event;
    private $delivery;

    public function __construct()
    {
        $this->config = Config::get('hooks.doc');
    }

    public function doFilter(Request $request, Context $context)
    {
        if (!$this->validate($request)) {
            yield $this->r(10001, 'invalid secret!', null);
            return;
        }
        yield null;
    }

    private function r($code, $msg, $data)
    {
        $data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return new JsonResponse($data);
    }

    private function validate($request)
    {
        $headers = $request->headers;
        $signature = $headers->get('x-hub-signature');
        $event = $headers->get('x-github-event');

        if ($event !== 'push') {
            return false;
        }

        $delivery = $headers->get('x-github-delivery');
        $payload = $request->getContent();

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
