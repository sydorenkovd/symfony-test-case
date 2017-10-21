<?php
/**
 * Created by PhpStorm.
 * User: sydorenkovd
 * Date: 21.10.17
 * Time: 14:16
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/api", name="api")
     */
    public function indexAction(Request $request) {
        $error = '';
        $responseStatus = true;
        $code = 200;
        try {
            $em = $this->getDoctrine()->getManager();
            $dataRequest = json_decode($request->getContent(), true);
            if($this->checkDataRequest($dataRequest)) {
                $model = $em->getRepository('AppBundle:Book')->find($dataRequest['id']);
                if($this->checkStatusCompatibility($dataRequest['status'], $model->getStatus())) {
                    $model->setBookStatus($em->getRepository('AppBundle:BookStatus')->find($dataRequest['status']));
                    $em->persist($model);
                    $em->flush();
                } else {
                    $responseStatus = false;
                    $error = 'Нельзя изменить статус';
                    $code = 500;
                }
            } else {
                $error = 'Ошибка';
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return new JsonResponse(['status' => $responseStatus, 'error' => $error], $code);
    }

    private function checkStatusCompatibility($statusRequest, $statusModel) {
        if($statusRequest === $statusModel) {
            return false;
        } else {
            try {
                $allowedStatusArr = json_decode(
                    $this->getDoctrine()->getRepository('Model:BookCompatibleStatus')
                        ->findBy(['status' => $statusModel])[0]->getAllowedStatuses()
                );
                return in_array($statusRequest, $allowedStatusArr);
            } catch (\Exception $e) {
                // log error TaskManager::logError($e->getMessage(), ...)
                return false;
            }
        }
    }
    private function checkDataRequest($dataRequest) {
        if(array_key_exists('id', $dataRequest) &&  array_key_exists('status', $dataRequest)) {
            return true;
        }
        return false;
    }
}