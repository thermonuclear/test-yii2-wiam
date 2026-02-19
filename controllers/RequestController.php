<?php

namespace  app\controllers;

use app\services\RequestService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class RequestController extends Controller
{
    private RequestService $requestService;

    public function __construct(
        $id,
        $module,
        RequestService $requestService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->requestService = $requestService;
    }

    public function actionCreate(): Response
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            Yii::$app->response->setStatusCode(405);
            return $this->asJson(['error' => 'Method not allowed']);
        }

        $data = $request->post();
        $result = $this->requestService->create($data);

        if ($result['result']) {
            Yii::$app->response->setStatusCode(201);
        } else {
            Yii::$app->response->setStatusCode(400);
        }

        return $this->asJson($result);
    }
}
