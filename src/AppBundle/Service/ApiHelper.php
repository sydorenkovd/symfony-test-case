<?php
/**
 * Created by PhpStorm.
 * User: sydorenkovd
 * Date: 21.10.17
 * Time: 22:30
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiHelper
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function checkStatusCompatibility(int $statusRequest, int $statusModel): bool
    {
        if ($statusRequest === $statusModel) {
            return false;
        } else {
            try {
                $allowedStatusArr = json_decode(
                    $this->em->getRepository('Model:BookCompatibleStatus')
                        ->findBy(['status' => $statusModel])[0]->getAllowedStatuses()
                );
                return in_array($statusRequest, $allowedStatusArr);
            } catch (\Exception $e) {
                // log error TaskManager::logError($e->getMessage(), ...)
                return false;
            }
        }
    }

    public function checkDataRequestKeys(array $dataRequest): bool
    {
        if (array_key_exists('id', $dataRequest) && array_key_exists('status', $dataRequest)) {
            return true;
        }
        return false;
    }

    public function responseError(string $message = null, int $code = 500) {
        return new JsonResponse(['status' => false, 'error' => $message], $code);
    }
}