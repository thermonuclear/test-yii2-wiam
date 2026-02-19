<?php

namespace app\services;

use Exception;
use app\models\Request;
use app\repositories\RequestRepository;

class RequestService
{
    private RequestRepository $requestRepository;

    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    public function create(array $data): ?array
    {
        $request = new Request();
        $request->setAttributes($data);
        $request->status = 'pending';

        // Проверяем, есть ли у пользователя одобренные заявки
        if ($this->requestRepository->findApprovedByUserId($data['user_id'])) {
            return [
                'result' => false,
            ];
        }

        if (!$request->validate()) {
            return [
                'result' => false,
            ];
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->requestRepository->save($request);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                'result' => false,
            ];
        }

        return [
            'result' => true,
            'id' => $request->id,
        ];
    }
}
