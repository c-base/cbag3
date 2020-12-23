<?php
/*
 * (c) 2019 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\RequestObject;

use ReflectionClass;
use ReflectionException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class RequestObjectConverter implements ParamConverterInterface
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration): bool
    {
        if (!$configuration->getClass()) {
            return false;
        }

        try {
            $object = new ReflectionClass($configuration->getClass());
            if ($object->implementsInterface(RequestObjectInterface::class)) {
                return true;
            }
        } catch (ReflectionException $exception) {
        }

        return false;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool true if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $object = $this->serializer->deserialize($request->getContent(), $class, 'json');
        $request->attributes->set($configuration->getName(), $object);

        return true;
    }
}
