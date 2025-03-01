<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function createOrder(Request $request): JsonResponse
    {
        try {

            $order = $this->orderService->createOrder($request->all());
            return response()->json(['status' => true, 'message' => 'Order created successfully', 'data' => $order], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getAllOrders(): JsonResponse
    {
        return response()->json(['status' => true, 'data' => $this->orderService->getAllOrders()]);
    }

    public function getOrder($id): JsonResponse
    {
        return response()->json(['status' => true, 'data' => $this->orderService->getOrderById($id)]);
    }

    public function processApproval($id): JsonResponse
    {
        try {
            $order = $this->orderService->approveOrder($id);
            return response()->json(['status' => true, 'message' => 'Order approved successfully', 'data' => $order]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function deleteOrder($id): JsonResponse
    {
        try {
            $this->orderService->deleteOrder($id);
            return response()->json(['status' => true, 'message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
