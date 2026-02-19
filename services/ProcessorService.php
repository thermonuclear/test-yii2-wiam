<?php

namespace app\services;

use app\repositories\RequestRepository;

class ProcessorService
{
    private RequestRepository $requestRepository;

    public function __construct(
        RequestRepository $requestRepository,
    ) {
        $this->requestRepository = $requestRepository;
    }

    public function process(int $delay): void
    {
        $pendingRequests = $this->requestRepository->findPending();

        $hasApproved = [];

        foreach ($pendingRequests as $request) {
            // Эмулируем задержку
            sleep($delay);

            // Принимаем решение с вероятностью 10% для одобрения
            $approved = mt_rand(1, 100) <= 10;

            // Проверяем, есть ли у пользователя одобренные заявки
            $existingApproved = $hasApproved[$request->user_id] ?? $this->requestRepository->findApprovedByUserId($request->user_id);

            if ($approved && $existingApproved) {
                // Если у пользователя уже есть одобренная заявка, отклоняем
                $approved = false;
            }

            $status = $approved ? 'approved' : 'declined';
            $this->requestRepository->updateStatus($request->id, $status);

            if ($approved || $existingApproved) {
                $hasApproved[$request->user_id] = 1;
            }
        }
    }
}
