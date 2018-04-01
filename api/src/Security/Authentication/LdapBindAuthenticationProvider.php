<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Security\Authentication;

use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\LdapInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * LdapBindAuthenticationProvider retrieves users for UsernamePasswordToken tokens.
 */
class LdapBindAuthenticationProvider implements AuthenticationProviderInterface
{
    /** LdapInterface */
    private $ldap;

    /** @var boolean */
    private $hideUserNotFoundExceptions;

    /** @var string */
    private $queryString;

    /** @var string */
    private $providerKey;

    public function __construct(string $providerKey, LdapInterface $ldap, $queryString, $hideUserNotFoundExceptions = true)
    {
        $this->providerKey = $providerKey;
        $this->ldap = $ldap;
        $this->queryString = $queryString;
        $this->hideUserNotFoundExceptions = $hideUserNotFoundExceptions;
    }

    /**
     * Attempts to authenticate a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            throw new AuthenticationException('The token is not supported by this authentication provider.');
        }

        try {
            $this->checkAuthentication($token);
        } catch (BadCredentialsException $exception) {
            if ($this->hideUserNotFoundExceptions) {
                throw new BadCredentialsException('Bad credentials.', 0, $exception);
            }
            throw $exception;
        }

        $authenticatedToken = new UsernamePasswordToken($token->getUsername(), $token->getCredentials(), $this->providerKey, ['ROLE_USER']);
        $authenticatedToken->setAttributes($token->getAttributes());

        return $authenticatedToken;
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return get_class($token) == UsernamePasswordToken::class;
    }

    private function checkAuthentication(TokenInterface $token)
    {
        $username = $token->getUsername();
        $password = $token->getCredentials();

        if (empty($username)) {
            throw new BadCredentialsException('The presented username must not be empty.');
        }

        if (empty($password)) {
            throw new BadCredentialsException('The presented password must not be empty.');
        }

        try {
            $username = $this->ldap->escape($username, '', LdapInterface::ESCAPE_DN);
            $dn = str_replace('{username}', $username, $this->queryString);
            $this->ldap->bind($dn, $password);
        } catch (ConnectionException $e) {
            throw new BadCredentialsException('The presented credentials are invalid.');
        }
    }
}
