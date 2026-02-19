<?php

namespace app\repositories;

use Exception;
use app\models\Request;
use yii\db\Connection;

class RequestRepository
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function save(Request $request): bool
    {
        return $request->save();
    }

    public function findById(int $id): ?Request
    {
        return Request::findOne($id);
    }

    public function findApprovedByUserId(int $userId): ?Request
    {
        return Request::findOne([
            'user_id' => $userId,
            'is_approved' => 1,
        ]);
    }

    public function findPendingByUserId(int $userId): ?Request
    {
        return Request::findOne([
            'user_id' => $userId,
            'status' => 'pending'
        ]);
    }

    public function findPending(): array
    {
        return Request::find()
            ->where(['status' => 'pending'])
            ->all();
    }

    public function updateStatus(int $id, string $status): void
    {
        $request = $this->findById($id);
        if (!$request || $request->status == $status) {
            return;
        }

        $request->status = $status;
        if ($status === 'approved') {
            $request->is_approved = 1;
        }

        try {
            $request->save();
        } catch (Exception $e) {

        }
    }
}
