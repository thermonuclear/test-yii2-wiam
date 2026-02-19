<?php

namespace app\controllers;

use app\services\ProcessorService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ProcessorController extends Controller
{
    private ProcessorService $processorService;

    public function __construct(
        $id,
        $module,
        ProcessorService $processorService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->processorService = $processorService;
    }

    public function actionProcess(): Response
    {
        $request = Yii::$app->request;
        $delay = (int)$request->get('delay', 0);

        if (!$request->isGet) {
            Yii::$app->response->setStatusCode(405);
            return $this->asJson(['error' => 'Method not allowed']);
        }

        if ($delay < 0) {
            return $this->asJson([
                'result' => false,
            ]);
        }

        $this->processorService->process($delay);

        return $this->asJson([
            'result' => true,
        ]);
    }
}
