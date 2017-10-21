<?php
/**
 * Created by PhpStorm.
 * User: sydorenkovd
 * Date: 21.10.17
 * Time: 14:16
 */

namespace AppBundle\Controller;


use AppBundle\Service\ApiHelper;
use Doctrine\ORM\EntityManager;
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
        $apiHelper = $this->get(ApiHelper::class);
        try {
            $em = $this->getDoctrine()->getManager();
            $dataRequest = json_decode($request->getContent(), true);
            if($apiHelper->checkDataRequestKeys($dataRequest)) {
                $status = is_array($dataRequest['status']) ? (int)$dataRequest['status'][$dataRequest['id']] : (int)$dataRequest['status'];
                $model = $em->getRepository('AppBundle:Book')->find($dataRequest['id']);
                if($apiHelper->checkStatusCompatibility((int)$status, (int)$model->getStatus())) {
                    $model->setBookStatus($em->getRepository('AppBundle:BookStatus')->find($status));
                    $em->persist($model);
                    $em->flush();
                } else {
                    return $apiHelper->responseError('Нельзя изменить статус', 424);
                }
            } else {
                return $apiHelper->responseError('Ошибка', 400);
            }
        } catch (\Exception $e) {
            return $apiHelper->responseError($e->getMessage(), 500);
        }
        return new JsonResponse(['status' => true, 'error' => null], 200);
    }

}