<?php

namespace Modules\Auth\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Modules\Auth\Entities\User;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('JWT_SECRET');
        $header = $request->getHeader("Authorization");
        $token = null;

        // extract the token from the header
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        // check if token is null or empty
        if (is_null($token) || empty($token)) {
            $response = service('response');
            $response->setJSON(["code" => "401", "message" => 'Access denied']);
            $response->setStatusCode(401);
            return $response;
        }

        try {
            $decoded = JWT::decode($token, new Key($key, "HS256"));
            helper('Modules\Auth\Auth');
            loginUser(new User(['id' => $decoded->id, 'email' => $decoded->email]));
        } catch (Exception $ex) {
            $response = service('response');
            $response->setJSON([
                'message' => "Invalid JWT"
            ]);
            log_message("error", $ex);
            $response->setStatusCode(401);
            return $response;
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
